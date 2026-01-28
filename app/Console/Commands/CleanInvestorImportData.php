<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CleanInvestorImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investors:clean-import {input_file} {output_file?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean investor import data by fixing common validation issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inputFile = $this->argument('input_file');
        $outputFile = $this->argument('output_file') ?? $this->generateOutputFilename($inputFile);

        if (! file_exists($inputFile)) {
            $this->error("Input file not found: {$inputFile}");

            return 1;
        }

        $this->info("Loading file: {$inputFile}");

        try {
            $spreadsheet = IOFactory::load($inputFile);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $this->info("Found {$highestRow} rows");

            // Get header row
            $headers = [];
            $headerRow = 1;
            foreach ($sheet->getRowIterator($headerRow, $headerRow) as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headers[] = strtolower(trim($cell->getValue()));
                }
            }

            $this->info('Processing data...');
            $bar = $this->output->createProgressBar($highestRow - 1);

            $stats = [
                'total_rows' => $highestRow - 1,
                'fixed_emails' => 0,
                'fixed_numeric' => 0,
                'fixed_formulas' => 0,
                'rows_with_issues' => 0,
            ];

            // Find column indices
            $emailCol = $this->findColumnIndex($headers, ['email', 'e-mail', 'investor email']);
            $nameCol = $this->findColumnIndex($headers, ['full_name', 'name', 'full name']);
            $numericCols = $this->findNumericColumns($headers);

            // Process each data row
            for ($rowNum = 2; $rowNum <= $highestRow; $rowNum++) {
                $rowHadIssues = false;

                // Fix email column
                if ($emailCol !== null) {
                    $emailCellCoord = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($emailCol + 1).$rowNum;
                    $emailCell = $sheet->getCell($emailCellCoord);
                    $email = trim($emailCell->getValue());

                    if (empty($email) || $email === 'NIL' || $email === 'N/A') {
                        // Try to generate email from name
                        if ($nameCol !== null) {
                            $nameCellCoord = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($nameCol + 1).$rowNum;
                            $nameCell = $sheet->getCell($nameCellCoord);
                            $name = trim($nameCell->getValue());
                            if (! empty($name)) {
                                $generatedEmail = $this->generateEmailFromName($name, $rowNum);
                                $emailCell->setValue($generatedEmail);
                                $stats['fixed_emails']++;
                                $rowHadIssues = true;
                            }
                        }
                    } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        // Try to fix common email issues
                        $fixedEmail = $this->fixEmail($email);
                        if ($fixedEmail !== $email) {
                            $emailCell->setValue($fixedEmail);
                            $stats['fixed_emails']++;
                            $rowHadIssues = true;
                        }
                    }
                }

                // Fix numeric columns
                foreach ($numericCols as $colIdx) {
                    $cellCoord = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1).$rowNum;
                    $cell = $sheet->getCell($cellCoord);
                    $value = $cell->getValue();

                    // Check for formula errors
                    if (is_string($value) && (strpos($value, '#REF!') !== false || strpos($value, '#VALUE!') !== false || strpos($value, '#N/A') !== false)) {
                        $cell->setValue(0);
                        $stats['fixed_formulas']++;
                        $rowHadIssues = true;

                        continue;
                    }

                    // Check for text in numeric fields
                    if (is_string($value)) {
                        $cleaned = $this->cleanNumericValue($value);
                        if ($cleaned !== $value) {
                            $cell->setValue($cleaned);
                            $stats['fixed_numeric']++;
                            $rowHadIssues = true;
                        }
                    }
                }

                if ($rowHadIssues) {
                    $stats['rows_with_issues']++;
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);

            // Save cleaned file
            $this->info("Saving cleaned data to: {$outputFile}");
            $writer = new Xlsx($spreadsheet);
            $writer->save($outputFile);

            // Display statistics
            $this->newLine();
            $this->info('Cleaning completed!');
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Total rows processed', $stats['total_rows']],
                    ['Rows with issues fixed', $stats['rows_with_issues']],
                    ['Email fixes', $stats['fixed_emails']],
                    ['Numeric value fixes', $stats['fixed_numeric']],
                    ['Formula error fixes', $stats['fixed_formulas']],
                ]
            );

            $this->newLine();
            $this->info("✓ Cleaned file saved to: {$outputFile}");
            $this->info('You can now import this file through the admin panel.');

            return 0;

        } catch (\Exception $e) {
            $this->error('Error processing file: '.$e->getMessage());

            return 1;
        }
    }

    /**
     * Find column index by matching header names
     */
    private function findColumnIndex(array $headers, array $possibleNames): ?int
    {
        foreach ($headers as $idx => $header) {
            if (in_array($header, $possibleNames, true)) {
                return $idx;
            }
        }

        return null;
    }

    /**
     * Find all numeric columns
     */
    private function findNumericColumns(array $headers): array
    {
        $numericKeywords = [
            'amount', 'paid', 'total', 'investment', 'roi', 'percentage',
            'commission', 'year_', 'price', 'balance',
        ];

        $numericCols = [];
        foreach ($headers as $idx => $header) {
            foreach ($numericKeywords as $keyword) {
                if (stripos($header, $keyword) !== false) {
                    $numericCols[] = $idx;
                    break;
                }
            }
        }

        return $numericCols;
    }

    /**
     * Generate email from name
     */
    private function generateEmailFromName(string $name, int $rowNum): string
    {
        // Remove special characters and convert to lowercase
        $name = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
        $name = strtolower(trim($name));

        // Take first two words
        $parts = explode(' ', $name);
        $emailName = implode('.', array_slice($parts, 0, 2));

        // Add row number to make it unique
        return $emailName.$rowNum.'@placeholder.com';
    }

    /**
     * Fix common email issues
     */
    private function fixEmail(string $email): string
    {
        // Remove spaces
        $email = str_replace(' ', '', $email);

        // Fix common typos
        $email = str_replace(['@gmail.con', '@yahoo.con'], ['@gmail.com', '@yahoo.com'], $email);

        // Ensure lowercase
        $email = strtolower($email);

        return $email;
    }

    /**
     * Clean numeric value
     */
    private function cleanNumericValue(string $value): float|int|string
    {
        $original = $value;

        // Common text values that should be 0
        $zeroValues = [
            'UNTIL THE 4TH YEAR',
            'NIL',
            'N/A',
            'PAID',
            'PENDING',
            'NOT PAID',
            'NOT YET PAID',
            'NO ROI',
            'INCOMPLETE PAY',
            'DEED PAYMENT',
            'RE-INVESTED',
            'DEPOSITED',
            'LOAN RE-PAYMENT',
            'PAYPAL',
            'HSBC Bank',
            'UMERA COOPERATIVE',
            'UMERA CO-OPERATIVE',
            'UMERA FCMB',
        ];

        foreach ($zeroValues as $zeroValue) {
            if (stripos($value, $zeroValue) !== false) {
                return 0;
            }
        }

        // Remove currency symbols and commas
        $value = preg_replace('/[₦$,\s]/', '', $value);

        // If it's now numeric, return it
        if (is_numeric($value)) {
            return (float) $value;
        }

        // If it still contains letters, return 0
        if (preg_match('/[a-zA-Z]/', $value)) {
            return 0;
        }

        // Try to extract first number
        if (preg_match('/(\d+\.?\d*)/', $value, $matches)) {
            return (float) $matches[1];
        }

        return 0;
    }

    /**
     * Generate output filename
     */
    private function generateOutputFilename(string $inputFile): string
    {
        $pathInfo = pathinfo($inputFile);

        return $pathInfo['dirname'].DIRECTORY_SEPARATOR.
               $pathInfo['filename'].'_cleaned.'.
               $pathInfo['extension'];
    }
}
