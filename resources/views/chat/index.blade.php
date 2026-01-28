@extends('layouts.app')

@section('content')
<div class="h-[calc(100vh-8rem)] flex flex-col">
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-skin-text">Messages</h1>
        <p class="text-sm text-skin-text-muted">Chat with your team and investors</p>
    </div>

    <div class="flex-1 bg-skin-base rounded-xl shadow-sm border border-skin-border overflow-hidden">
        @if($contacts->count() > 0)
            <div class="overflow-y-auto h-full divide-y divide-skin-border">
                @foreach($contacts as $contact)
                    <a href="{{ route('chat.show', $contact->id) }}" class="block p-4 hover:bg-skin-base-ter transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-umera-100 flex items-center justify-center text-umera-700 font-bold text-lg group-hover:bg-umera-200 transition-colors">
                                {{ substr($contact->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h2 class="text-base font-semibold text-skin-text truncate">{{ $contact->name }}</h2>
                                    <span class="text-xs px-2 py-1 rounded-full bg-skin-base-sec text-skin-text-muted capitalize">
                                        {{ $contact->role }}
                                    </span>
                                </div>
                                <p class="text-sm text-skin-text-muted truncate">
                                    Click to start chatting
                                </p>
                            </div>
                            <svg class="h-5 w-5 text-skin-text-muted group-hover:text-umera-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="h-full flex flex-col items-center justify-center text-skin-text-muted">
                <svg class="h-16 w-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-lg font-medium">No contacts found</p>
                <p class="text-sm">You don't have any available contacts to chat with.</p>
            </div>
        @endif
    </div>
</div>
@endsection
