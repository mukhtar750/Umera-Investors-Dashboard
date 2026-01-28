<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TranscodeVoiceNote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $messageId;

    protected string $disk;

    public function __construct(int $messageId, string $disk = 'public')
    {
        $this->messageId = $messageId;
        $this->disk = $disk;
    }

    public function handle(): void
    {
        $message = Message::find($this->messageId);
        if (! $message || $message->attachment_type !== 'voice' || empty($message->attachment_path)) {
            return;
        }

        $sourceRel = $message->attachment_path;
        $sourceAbs = Storage::disk($this->disk)->path($sourceRel);
        if (! is_file($sourceAbs)) {
            return;
        }

        $targetRel = preg_replace('/\.[^\.]+$/', '.mp3', $sourceRel);
        $targetAbs = Storage::disk($this->disk)->path($targetRel);

        if (is_file($targetAbs)) {
            return;
        }

        $ffmpeg = 'ffmpeg';
        $check = $this->runCommand($ffmpeg.' -version');
        if ($check['exit'] !== 0) {
            return;
        }

        $cmd = $ffmpeg
            .' -y -i '.$this->q($sourceAbs)
            .' -vn -acodec libmp3lame -b:a 128k '.$this->q($targetAbs);

        $res = $this->runCommand($cmd);
        if ($res['exit'] !== 0) {
            Log::warning('ffmpeg transcode failed', [
                'message_id' => $this->messageId,
                'cmd' => $cmd,
                'exit' => $res['exit'],
            ]);

            return;
        }
    }

    protected function q(string $path): string
    {
        return '"'.str_replace('"', '\"', $path).'"';
    }

    protected function runCommand(string $cmd): array
    {
        $descriptors = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $proc = proc_open($cmd, $descriptors, $pipes);
        if (! is_resource($proc)) {
            return ['exit' => 1, 'out' => '', 'err' => ''];
        }
        $out = stream_get_contents($pipes[1] ?? null);
        $err = stream_get_contents($pipes[2] ?? null);
        if (isset($pipes[1])) {
            fclose($pipes[1]);
        }
        if (isset($pipes[2])) {
            fclose($pipes[2]);
        }
        $exit = proc_close($proc);

        return ['exit' => $exit, 'out' => $out, 'err' => $err];
    }
}
