<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvestorImportController extends Controller
{
    public function create()
    {
        return view('admin.investors.import', [
            'pageTitle' => 'Import Investors',
        ]);
    }

    public function store(Request $request)
    {
        set_time_limit(0);
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:10240',
            ]);
            $uploaded = $request->file('file');
            $storedPath = $uploaded->storeAs('imports', time().'_'.$uploaded->getClientOriginalName());
            $checksum = hash_file('sha256', $uploaded->getRealPath());
        } else {
            $request->validate([
                'file' => 'required|string',
            ]);
            $storedPath = $request->input('file');
            $absolute = Storage::disk('local')->path($storedPath);
            if (! file_exists($absolute)) {
                return redirect()->route('admin.investors.import')->with('error', 'Stored file not found.');
            }
            $checksum = hash_file('sha256', $absolute);
        }

        $existing = \App\Models\ImportSession::where('admin_id', $request->user()->id)
            ->where('checksum', $checksum)
            ->first();

        if ($existing) {
            if (in_array($existing->status, ['pending', 'processing'])) {
                return redirect()->route('admin.investors.import')
                    ->with('error', 'This file is already being imported (session #'.$existing->id.').');
            }

            if ($existing->status === 'completed') {
                return redirect()->route('admin.investors.import')
                    ->with('error', 'This file was already imported successfully (session #'.$existing->id.').');
            }

            $existing->file_name = $storedPath;
            $existing->status = 'pending';
            $existing->total_rows = 0;
            $existing->processed_rows = 0;
            $existing->successful_rows = 0;
            $existing->failed_rows = 0;
            $existing->error_report_path = null;
            $existing->started_at = null;
            $existing->completed_at = null;
            $existing->save();

            \App\Jobs\ImportInvestorsJob::dispatch($existing->id);

            return redirect()->route('admin.investors.import')
                ->with('success', 'Import retry started. Session ID: '.$existing->id);
        }

        $session = \App\Models\ImportSession::create([
            'admin_id' => $request->user()->id,
            'file_name' => $storedPath,
            'checksum' => $checksum,
            'status' => 'pending',
        ]);

        \App\Jobs\ImportInvestorsJob::dispatch($session->id);

        return redirect()->route('admin.investors.import')
            ->with('success', 'Import started. Session ID: '.$session->id);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:10240',
        ]);
        $uploaded = $request->file('file');
        $storedPath = $uploaded->storeAs('imports', time().'_'.$uploaded->getClientOriginalName());

        try {
            $absolute = Storage::disk('local')->path($storedPath);
            [$header, $rows] = app(\App\Services\InvestorImportService::class)->readFile($absolute);
            [$normalizedHeader, $headerMap] = app(\App\Services\InvestorImportService::class)->resolveHeaderMap($header);

            $errors = [];
            $firstRows = array_slice($rows, 0, 10);
            $mapped = app(\App\Services\InvestorImportService::class)->mapAndValidateRows($normalizedHeader, $headerMap, $firstRows, $errors);

            $optionalKeys = [
                'dob', 'phone', 'address',
                'next_of_kin_name', 'next_of_kin_email', 'next_of_kin_relationship', 'next_of_kin_phone',
                'moa_signed', 'moa_signed_date', 'investment_year', 'investment_month',
                'block_name', 'unit_number', 'roi_percentage', 'affiliate', 'affiliate_commission',
            ];
            $present = collect($normalizedHeader)->map(function ($h, $i) use ($headerMap) {
                return $headerMap[$i] ?? $h;
            })->all();
            $missingOptional = array_values(array_diff($optionalKeys, array_unique($present)));

            return view('admin.investors.preview', [
                'pageTitle' => 'Import Preview',
                'stored_path' => $storedPath,
                'header' => $normalizedHeader,
                'header_map' => $headerMap,
                'rows' => $mapped,
                'errors' => $errors,
                'missing_optional' => $missingOptional,
            ]);
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.investors.import')
                ->with('error', 'The import file could not be read. Reason: '.$e->getMessage());
        }
    }
}
