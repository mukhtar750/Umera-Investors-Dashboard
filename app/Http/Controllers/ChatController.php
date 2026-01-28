<?php

namespace App\Http\Controllers;

use App\Jobs\TranscodeVoiceNote;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contacts = collect();

        if ($user->role === 'investor') {
            $contacts = User::whereIn('role', ['admin', 'legal', 'finance'])->get();
        } elseif ($user->role === 'admin') {
            $contacts = User::where('id', '!=', $user->id)->get();
        } elseif ($user->role === 'legal') {
            $contacts = User::where('id', '!=', $user->id)->get();
        } elseif ($user->role === 'finance') {
            $contacts = User::where('id', '!=', $user->id)->get();
        }

        return view('chat.index', compact('contacts'));
    }

    public function show(User $receiver)
    {
        $user = Auth::user();

        // Mark messages as read
        Message::where('sender_id', $receiver->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where(function ($q) use ($user, $receiver) {
            $q->where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id);
        })->orWhere(function ($q) use ($user, $receiver) {
            $q->where('sender_id', $receiver->id)
                ->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        return view('chat.show', compact('receiver', 'messages'));
    }

    public function store(Request $request, User $receiver)
    {
        // Prevent investor-to-investor chat
        if (Auth::user()->role === 'investor' && $receiver->role === 'investor') {
            abort(403, 'Investors cannot chat with other investors.');
        }

        $request->validate([
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240', // 10MB
            'voice_note' => 'nullable|file|max:10240',
        ]);

        if (! $request->message && ! $request->hasFile('attachment') && ! $request->hasFile('voice_note')) {
            return back()->withErrors(['message' => 'Message or attachment is required.']);
        }

        $data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'message' => $request->message,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat_attachments', 'public');
            $data['attachment_path'] = $path;
            $data['original_filename'] = $file->getClientOriginalName();

            $mime = $file->getMimeType();
            if (str_starts_with($mime, 'image/')) {
                $data['attachment_type'] = 'image';
            } else {
                $data['attachment_type'] = 'file';
            }
        }

        if ($request->hasFile('voice_note')) {
            $file = $request->file('voice_note');
            $path = $file->store('chat_voice_notes', 'public');
            $data['attachment_path'] = $path;
            $data['attachment_type'] = 'voice';
            $data['original_filename'] = $file->getClientOriginalName();
        }

        $message = Message::create($data);
        if (! empty($data['attachment_path']) && ($data['attachment_type'] ?? null) === 'voice') {
            TranscodeVoiceNote::dispatchSync($message->id, 'public');
        }

        return redirect()->route('chat.show', $receiver->id);
    }
}
