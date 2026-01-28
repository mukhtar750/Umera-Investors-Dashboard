<?php

namespace App\Services;

use App\Models\Allocation;
use App\Models\ImportSession;
use App\Models\Offering;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InvestorImportService
{
    private function extractCustomFields(array $row): array
    {
        $baseKeys = [
            'email',
            'full_name',
            'first_name',
            'last_name',
            'name',
            'dob',
            'phone',
            'address',
            'next_of_kin_name',
            'next_of_kin_email',
            'next_of_kin_relationship',
            'next_of_kin_phone',
            'affiliate',
            'affiliate_commission',
            'land_name',
            'block_name',
            'unit_number',
            'investment_amount',
            'total_paid',
            'roi_percentage',
            'investment_year',
            'investment_month',
            'investment_date',
            'moa_signed',
            'moa_signed_date',
        ];

        $custom = [];
        foreach ($row as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            if (in_array($key, $baseKeys, true)) {
                continue;
            }
            if (preg_match('/^year_(\\d+)$/', $key)) {
                continue;
            }
            $custom[$key] = $value;
        }

        return $custom;
    }

    // Map and validate headers; returns header map and normalized headers
    public function resolveHeaderMap(array $header): array
    {
        $header = array_map(fn ($h) => strtolower(trim($h)), $header);

        $columnSynonyms = [
            'email' => ['email', 'e-mail', 'investor email', 'email address'],
            'full_name' => ['full_name', 'name', 'full name'],
            'first_name' => ['first_name', 'firstname', 'first name', 'given name'],
            'last_name' => ['last_name', 'lastname', 'last name', 'surname', 'family name'],
            'dob' => ['dob', 'date of birth', 'birthdate'],
            'phone' => ['phone', 'contact', 'contact number', 'mobile', 'telephone', 'phone number', 'contact no'],
            'address' => ['address', 'home address', 'residential address'],
            'next_of_kin_name' => ['next_of_kin_name', 'nok_name', 'next of kin name'],
            'next_of_kin_email' => ['next_of_kin_email', 'nok_email', 'next of kin email', 'next of kin email address', 'nok email address'],
            'next_of_kin_relationship' => ['next_of_kin_relationship', 'nok_relationship', 'next of kin relationship'],
            'next_of_kin_phone' => ['next_of_kin_phone', 'nok_phone', 'next of kin phone', 'next of kin contact no', 'nok contact no'],
            'moa_signed' => ['moa_signed', 'moa status', 'moa signed'],
            'moa_signed_date' => ['moa_signed_date', 'moa date', 'moa signed date'],
            'investment_year' => ['investment_year', 'year'],
            'investment_month' => ['investment_month', 'month'],
            'investment_date' => ['investment_date', 'date', 'investment datetime'],
            'land_name' => ['land_name', 'land', 'project', 'offering', 'property'],
            'block_name' => ['block_name', 'block'],
            'unit_number' => ['unit_number', 'unit', 'plot', 'apartment'],
            'investment_amount' => ['investment_amount', 'amount invested', 'investment amount'],
            'total_paid' => ['total_paid', 'amount paid', 'paid total', 'total payment'],
            'roi_percentage' => ['roi_percentage', 'roi', 'roi rate', 'roi%'],
            'affiliate' => ['affiliate', 'referrer', 'agent'],
            'affiliate_commission' => ['affiliate_commission', 'commission', 'agent commission'],
        ];

        $headerMap = [];
        foreach ($header as $idx => $col) {
            $resolved = null;
            if (preg_match('/^y(?:ear)?\\s*(\\d+)$/i', $col, $m)) {
                $resolved = 'year_'.intval($m[1]);
            }
            if (! $resolved) {
                foreach ($columnSynonyms as $logical => $syns) {
                    if (in_array($col, $syns, true)) {
                        $resolved = $logical;
                        break;
                    }
                }
            }
            $headerMap[$idx] = $resolved ?? $col;
        }

        return [$header, $headerMap];
    }

    public function readFile(string $path): array
    {
        if (! file_exists($path)) {
            throw new \RuntimeException('Import file not found. Please upload it again.');
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($ext, ['csv', 'txt'])) {
            $data = array_map('str_getcsv', file($path));
            $header = array_shift($data);

            return [$header, $data];
        }
        $spreadsheet = IOFactory::load($path);

        // Use standard toArray
        $data = $spreadsheet->getActiveSheet()->toArray();
        if (empty($data)) {
            return [[], []];
        }

        $header = array_shift($data);

        return [$header, $data];
    }

    public function mapAndValidateRows(array $header, array $headerMap, array $rows, array &$errors): array
    {
        $processed = [];
        foreach ($rows as $i => $row) {
            // Check if row is empty
            if (empty(array_filter($row, function ($v) {
                return $v !== null && trim((string) $v) !== '';
            }))) {
                continue;
            }
            // if (count($row) !== count($header)) {
            //     $errors[] = ['row' => $i + 2, 'reason' => 'Column count mismatch', 'data' => $row];
            //     continue;
            // }
            $mapped = [];
            foreach ($row as $colIdx => $value) {
                // Skip if column index is beyond header count
                if (! isset($header[$colIdx])) {
                    continue;
                }

                $key = $headerMap[$colIdx] ?? $header[$colIdx];
                $cleanValue = is_string($value) ? trim($value) : $value;

                // If key already exists and has value, don't overwrite with empty
                if (isset($mapped[$key]) && $mapped[$key] !== '' && $mapped[$key] !== null) {
                    if ($cleanValue === '' || $cleanValue === null) {
                        continue;
                    }
                }

                $mapped[$key] = $cleanValue;
            }

            if (isset($mapped['email'])) {
                if (is_array($mapped['email'])) {
                    $mapped['email'] = $mapped['email'][0] ?? '';
                }
                $mapped['email'] = strtolower(trim((string) $mapped['email']));

                // If email is empty but we have a name, generate placeholder
                if (empty($mapped['email']) || $mapped['email'] === 'nil' || $mapped['email'] === 'n/a') {
                    if (! empty($mapped['name'])) {
                        $cleanName = preg_replace('/[^a-z0-9]/', '', strtolower($mapped['name']));
                        $cleanName = substr($cleanName, 0, 15); // limit length
                        $mapped['email'] = $cleanName.($i + 2).'@placeholder.com'; // Adding row number for uniqueness
                    }
                }

                // Handle placeholder emails or valid emails
                if (! filter_var($mapped['email'], FILTER_VALIDATE_EMAIL)) {
                    // One last check: if name is ALSO missing, then this row is garbage. Skip it.
                    if (empty($mapped['name']) && empty($mapped['full_name']) && empty($mapped['first_name'])) {
                        continue;
                    }

                    $errors[] = ['row' => $i + 2, 'reason' => 'Invalid email', 'data' => $row];

                    continue;
                }
            } else {
                // If email mapping is missing entirely, try to generate from name if available
                if (! empty($mapped['name']) || ! empty($mapped['full_name'])) {
                    $name = $mapped['name'] ?? $mapped['full_name'];
                    $cleanName = preg_replace('/[^a-z0-9]/', '', strtolower($name));
                    $cleanName = substr($cleanName, 0, 15);
                    $mapped['email'] = $cleanName.($i + 2).'@placeholder.com';
                } else {
                    // Check if name is also missing. If so, skip.
                    if (empty($mapped['name']) && empty($mapped['full_name']) && empty($mapped['first_name'])) {
                        continue;
                    }

                    $errors[] = ['row' => $i + 2, 'reason' => 'Missing email', 'data' => $row];

                    continue;
                }
            }

            if (! empty($mapped['full_name'])) {
                $mapped['name'] = $mapped['full_name'];
            } elseif (! empty($mapped['first_name']) && ! empty($mapped['last_name'])) {
                $mapped['name'] = trim($mapped['first_name'].' '.$mapped['last_name']);
            } elseif (! empty($mapped['name'])) {
            } else {
                $errors[] = ['row' => $i + 2, 'reason' => 'Missing full name or first/last name', 'data' => $row];

                continue;
            }

            if (isset($mapped['land_name'])) {
                $mapped['land_name'] = trim($mapped['land_name']);
            }

            foreach (['investment_amount', 'total_paid', 'roi_percentage'] as $numKey) {
                if (isset($mapped[$numKey]) && $mapped[$numKey] !== '') {
                    // Sanitize numeric value: remove currency symbols, commas, etc.
                    $sanitized = preg_replace('/[^\d.-]/', '', (string) $mapped[$numKey]);

                    if (! is_numeric($sanitized)) {
                        // If it's some text like "UNTIL 4TH YEAR", treat as 0 or error?
                        // For total_paid, let's treat invalid as 0 to be lenient
                        if ($numKey === 'total_paid' || $numKey === 'investment_amount') {
                            $mapped[$numKey] = 0.0;
                        } else {
                            $errors[] = ['row' => $i + 2, 'reason' => "Invalid numeric {$numKey}", 'data' => $row];

                            continue 2;
                        }
                    } else {
                        $mapped[$numKey] = (float) $sanitized;
                    }
                }
            }
            foreach ($mapped as $k => $v) {
                if (preg_match('/^year_(\d+)$/', $k)) {
                    if ($v !== '') {
                        $sanitized = preg_replace('/[^\d.-]/', '', (string) $v);
                        if (! is_numeric($sanitized)) {
                            $mapped[$k] = 0.0; // Be lenient with year payments too
                        } else {
                            $mapped[$k] = (float) $sanitized;
                        }
                    } else {
                        $mapped[$k] = null;
                    }
                }
            }

            $investmentDate = null;
            if (! empty($mapped['investment_date'])) {
                try {
                    $investmentDate = Carbon::parse($mapped['investment_date']);
                } catch (\Exception $e) {
                    // Try to recover if it's Excel serial date
                    if (is_numeric($mapped['investment_date'])) {
                        try {
                            $investmentDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($mapped['investment_date']);
                            $investmentDate = Carbon::instance($investmentDate);
                        } catch (\Exception $ex) {
                        }
                    }

                    if (! $investmentDate) {
                        $errors[] = ['row' => $i + 2, 'reason' => 'Invalid investment_date', 'data' => $row];

                        continue;
                    }
                }
            } elseif (! empty($mapped['investment_year']) || ! empty($mapped['investment_month'])) {
                $year = (int) ($mapped['investment_year'] ?? date('Y'));
                $month = (int) ($mapped['investment_month'] ?? 1);
                // Handle Month names if passed as string
                if (is_string($mapped['investment_month']) && ! is_numeric($mapped['investment_month'])) {
                    try {
                        $month = Carbon::parse($mapped['investment_month'])->month;
                    } catch (\Exception $e) {
                        $month = 1;
                    }
                }

                try {
                    $investmentDate = Carbon::createFromDate($year, max(1, min(12, $month)), 1);
                } catch (\Exception $e) {
                    $errors[] = ['row' => $i + 2, 'reason' => 'Invalid investment year/month', 'data' => $row];

                    continue;
                }
            }
            $mapped['investment_date'] = $investmentDate ? $investmentDate : Carbon::now();

            $processed[] = $mapped;
        }

        return $processed;
    }

    public function chunkRows(array $rows, int $size = 500): array
    {
        return array_chunk($rows, $size);
    }

    public function processChunk(ImportSession $session, array $rows, array &$errors, int &$successCount): void
    {
        DB::beginTransaction();
        try {
            $emails = collect($rows)->pluck('email')->filter()->unique()->toArray();
            $existingUsers = User::whereIn('email', $emails)->get()->mapWithKeys(fn ($u) => [strtolower($u->email) => $u]);
            $now = now();
            $usersToInsert = [];
            foreach ($emails as $email) {
                if (! $existingUsers->has($email)) {
                    $row = collect($rows)->firstWhere('email', $email);
                    $customFields = $this->extractCustomFields($row);
                    $usersToInsert[] = [
                        'name' => $row['name'] ?? 'Unknown Investor',
                        'email' => $email,
                        'phone' => (string) ($row['phone'] ?? ''),
                        'password' => Hash::make('password123'),
                        'role' => 'investor',
                        'email_verified_at' => $now,
                        'must_reset_password' => true,
                        'dob' => $row['dob'] ?? null,
                        'address' => $row['address'] ?? null,
                        'next_of_kin_name' => $row['next_of_kin_name'] ?? null,
                        'next_of_kin_email' => $row['next_of_kin_email'] ?? null,
                        'next_of_kin_relationship' => $row['next_of_kin_relationship'] ?? null,
                        'next_of_kin_phone' => $row['next_of_kin_phone'] ?? null,
                        'custom_fields' => empty($customFields) ? null : json_encode($customFields),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                } else {
                    // Update existing user if fields are empty
                    $user = $existingUsers->get($email);
                    $row = collect($rows)->firstWhere('email', $email);
                    $updates = [];
                    $fields = [
                        'phone', 'dob', 'address',
                        'next_of_kin_name', 'next_of_kin_email',
                        'next_of_kin_relationship', 'next_of_kin_phone',
                    ];

                    foreach ($fields as $field) {
                        if (empty($user->$field) && ! empty($row[$field])) {
                            $updates[$field] = $row[$field];
                        }
                    }

                    if (! empty($updates)) {
                        $user->update($updates);
                    }
                }
            }
            foreach (array_chunk($usersToInsert, 500) as $chunk) {
                if (! empty($chunk)) {
                    User::insert($chunk);
                }
            }
            $allUsers = User::whereIn('email', $emails)->get()->mapWithKeys(fn ($u) => [strtolower($u->email) => $u]);

            $landNames = collect($rows)->pluck('land_name')->filter()->unique()->toArray();
            $existingOfferings = Offering::whereIn('name', $landNames)->get()->mapWithKeys(fn ($o) => [strtolower($o->name) => $o]);
            $offeringsToInsert = [];
            foreach ($landNames as $name) {
                $key = strtolower($name);
                if (! $existingOfferings->has($key)) {
                    $sample = collect($rows)->firstWhere('land_name', $name);
                    $offeringsToInsert[] = [
                        'name' => $name,
                        'price' => 0,
                        'total_units' => 100,
                        'available_units' => 100,
                        'status' => 'closed',
                        'location' => 'Imported Location',
                        'roi_percentage' => $sample['roi_percentage'] ?? null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            foreach (array_chunk($offeringsToInsert, 500) as $chunk) {
                if (! empty($chunk)) {
                    Offering::insert($chunk);
                }
            }
            $allOfferings = Offering::whereIn('name', $landNames)->get()->mapWithKeys(fn ($o) => [strtolower($o->name) => $o]);

            $allocationsUpserts = [];
            $transactionsBatch = [];

            foreach ($rows as $idx => $row) {
                $email = $row['email'] ?? null;
                $landName = $row['land_name'] ?? null;
                if (! $email || ! $landName) {
                    $errors[] = ['row' => 'chunk:'.$idx, 'reason' => 'Missing email or land_name', 'data' => $row];

                    continue;
                }
                $user = $allUsers->get(strtolower($email));
                $offering = $allOfferings->get(strtolower($landName));
                if (! $user || ! $offering) {
                    $errors[] = ['row' => 'chunk:'.$idx, 'reason' => 'User or Offering not found', 'data' => $row];

                    continue;
                }

                $investmentDate = $row['investment_date'] ?? $now;

                $allocationsUpserts[] = [
                    'user_id' => $user->id,
                    'offering_id' => $offering->id,
                    'block_name' => $row['block_name'] ?? null,
                    'unit_number' => $row['unit_number'] ?? null,
                    'units' => 1,
                    'amount' => $row['investment_amount'] ?? 0,
                    'status' => 'active',
                    'moa_signed' => isset($row['moa_signed']) ? (bool) $row['moa_signed'] : false,
                    'moa_signed_date' => $row['moa_signed_date'] ?? null,
                    'created_at' => $investmentDate,
                    'updated_at' => $now,
                ];
            }

            if (! empty($allocationsUpserts)) {
                Allocation::upsert(
                    $allocationsUpserts,
                    ['user_id', 'offering_id', 'block_name', 'unit_number'],
                    ['units', 'amount', 'status', 'moa_signed', 'moa_signed_date', 'updated_at']
                );
            }

            $keys = collect($allocationsUpserts)->map(function ($a) {
                return [
                    'user_id' => $a['user_id'],
                    'offering_id' => $a['offering_id'],
                    'block_name' => $a['block_name'],
                    'unit_number' => $a['unit_number'],
                ];
            });

            $allocationsMap = Allocation::whereIn('user_id', $keys->pluck('user_id'))
                ->whereIn('offering_id', $keys->pluck('offering_id'))
                ->get()
                ->mapWithKeys(function ($a) {
                    $k = $a->user_id.'|'.$a->offering_id.'|'.($a->block_name ?? '').'|'.($a->unit_number ?? '');

                    return [$k => $a];
                });

            foreach ($rows as $idx => $row) {
                $email = $row['email'] ?? null;
                $landName = $row['land_name'] ?? null;
                if (! $email || ! $landName) {
                    continue;
                }
                $user = $allUsers->get(strtolower($email));
                $offering = $allOfferings->get(strtolower($landName));
                if (! $user || ! $offering) {
                    continue;
                }

                $customFields = $this->extractCustomFields($row);
                if (! empty($customFields)) {
                    $existingCustom = $user->custom_fields ?? [];
                    if (! is_array($existingCustom)) {
                        $existingCustom = [];
                    }
                    $user->custom_fields = array_merge($existingCustom, $customFields);
                    $user->save();
                }

                $investmentDate = $row['investment_date'] ?? $now;
                $key = $user->id.'|'.$offering->id.'|'.($row['block_name'] ?? '').'|'.($row['unit_number'] ?? '');
                $allocation = $allocationsMap->get($key);
                if (! $allocation) {
                    continue;
                }

                if (isset($row['total_paid']) && $row['total_paid'] > 0) {
                    $transactionsBatch[] = [
                        'allocation_id' => $allocation->id,
                        'user_id' => $user->id,
                        'amount' => $row['total_paid'],
                        'type' => 'payment',
                        'status' => 'approved',
                        'description' => 'Imported Payment for '.$landName,
                        'reference' => 'IMP-'.Str::random(8).'-'.$idx,
                        'created_at' => $investmentDate,
                        'updated_at' => $now,
                    ];
                }
                foreach ($row as $k => $v) {
                    if ($v && preg_match('/^year_(\\d+)$/', $k, $m)) {
                        $yearNumber = intval($m[1]);
                        $txDate = (clone $investmentDate)->addYears(max(0, $yearNumber - 1));
                        $transactionsBatch[] = [
                            'allocation_id' => $allocation->id,
                            'user_id' => $user->id,
                            'amount' => (float) $v,
                            'type' => 'payment',
                            'status' => 'approved',
                            'description' => 'Imported Payment Year '.$yearNumber.' for '.$landName,
                            'reference' => 'IMP-Y'.$yearNumber.'-'.Str::random(8).'-'.$idx,
                            'created_at' => $txDate,
                            'updated_at' => $now,
                        ];
                    }
                }
                $successCount++;
            }

            foreach (array_chunk($transactionsBatch, 500) as $chunk) {
                if (! empty($chunk)) {
                    Transaction::insert($chunk);
                }
            }

            DB::commit();

            // Password::sendResetLink(['email' => $email]);
        } catch (\Throwable $e) {
            DB::rollBack();
            $errors[] = ['row' => 'chunk', 'reason' => 'Exception: '.$e->getMessage(), 'data' => []];
        }
    }

    public function writeErrorReport(ImportSession $session, array $errors): ?string
    {
        if (empty($errors)) {
            return null;
        }

        // Use DIRECTORY_SEPARATOR for cross-platform compatibility
        $path = 'import_reports'.DIRECTORY_SEPARATOR.'session_'.$session->id.'.csv';
        $fullPath = storage_path('app'.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $path));
        $dir = dirname($fullPath);

        // Ensure directory exists
        if (! is_dir($dir)) {
            if (! mkdir($dir, 0755, true) && ! is_dir($dir)) {
                throw new \RuntimeException('Failed to create directory: '.$dir);
            }
        }

        // Open file for writing
        $fh = @fopen($fullPath, 'w');
        if ($fh === false) {
            throw new \RuntimeException('Failed to open file for writing: '.$fullPath);
        }

        // Write CSV content
        fputcsv($fh, ['row', 'reason', 'data']);
        foreach ($errors as $err) {
            fputcsv($fh, [$err['row'] ?? '', $err['reason'] ?? '', json_encode($err['data'] ?? [])]);
        }
        fclose($fh);

        // Return path with forward slashes for storage (Laravel convention)
        return str_replace(DIRECTORY_SEPARATOR, '/', $path);
    }
}
