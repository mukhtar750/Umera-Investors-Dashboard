@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Announcements</h1>
    </div>

    <div class="space-y-4">
        @forelse($announcements as $announcement)
        <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 space-y-2 sm:space-y-0">
                <h3 class="text-lg font-medium text-skin-text">{{ $announcement->title }}</h3>
                <span class="text-xs text-skin-text-muted bg-skin-bg-alt px-2 py-1 rounded-full w-fit">
                    {{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : $announcement->created_at->format('M d, Y') }}
                </span>
            </div>
            <div class="prose prose-sm max-w-none text-skin-text-muted dark:prose-invert">
                {{ $announcement->content }}
            </div>
        </div>
        @empty
        <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-skin-text-muted opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-skin-text">No announcements</h3>
            <p class="mt-1 text-sm text-skin-text-muted">Check back later for news and updates.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
