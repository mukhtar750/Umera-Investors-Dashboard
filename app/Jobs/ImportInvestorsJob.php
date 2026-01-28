<?php

namespace App\Jobs;

use App\Models\ImportSession;
use App\Services\InvestorImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportInvestorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1200; // 20 minutes

    protected int $chunkSize = 500;

    public function __construct(public int $sessionId) {}

    public function handle(InvestorImportService $service): void
    {
        set_time_limit(0); // Allow unlimited execution time effectively
        $session = ImportSession::findOrFail($this->sessionId);
        $session->status = 'processing';
        $session->started_at = now();
        $session->save();

        try {
            $absolute = Storage::disk('local')->path($session->file_name);
            [$header, $rows] = $service->readFile($absolute);
            [$normalizedHeader, $headerMap] = $service->resolveHeaderMap($header);
            $errors = [];
            $processedRows = $service->mapAndValidateRows($normalizedHeader, $headerMap, $rows, $errors);

            $session->total_rows = count($rows);
            $session->processed_rows = 0;
            $session->successful_rows = 0;
            $session->failed_rows = count($errors);
            $session->save();

            $successCount = 0;
            $processedCount = 0;
            foreach ($service->chunkRows($processedRows, $this->chunkSize) as $chunk) {
                $service->processChunk($session, $chunk, $errors, $successCount);
                $processedCount += count($chunk);
                $session->processed_rows = $processedCount;
                $session->successful_rows = $successCount;
                $session->failed_rows = count($errors);
                $session->save();
            }

            $reportPath = $service->writeErrorReport($session, $errors);
            if ($reportPath) {
                $session->error_report_path = $reportPath;
            }

            $session->status = 'completed';
            $session->completed_at = now();
            $session->save();
        } catch (\Throwable $e) {
            Log::error(
                'ImportInvestorsJob failed for session '.$session->id.': '.$e->getMessage(),
                [
                    'session_id' => $session->id,
                    'trace' => $e->getTraceAsString(),
                ]
            );
            $session->status = 'failed';
            $session->failed_rows = 0;
            $session->completed_at = now();
            $session->save();
        }
    }
}
