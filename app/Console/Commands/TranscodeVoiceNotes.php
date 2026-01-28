<?php

namespace App\Console\Commands;

use App\Jobs\TranscodeVoiceNote;
use App\Models\Message;
use Illuminate\Console\Command;

class TranscodeVoiceNotes extends Command
{
    protected $signature = 'voice:transcode {--sync : Run synchronously}';

    protected $description = 'Transcode existing voice notes to MP3 for broader browser support';

    public function handle(): int
    {
        $count = 0;
        Message::where('attachment_type', 'voice')
            ->whereNotNull('attachment_path')
            ->chunk(100, function ($chunk) use (&$count) {
                foreach ($chunk as $message) {
                    $count++;
                    if ($this->option('sync')) {
                        TranscodeVoiceNote::dispatchSync($message->id, 'public');
                    } else {
                        TranscodeVoiceNote::dispatch($message->id, 'public');
                    }
                }
            });

        $this->info("Queued {$count} voice notes for transcoding.");
        $this->info('Use --sync to process immediately without a worker.');

        return Command::SUCCESS;
    }
}
