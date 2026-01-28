@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">{{ $campaign->subject }}</h1>
            <p class="text-sm text-skin-text-muted mt-1">
                Status: <span class="capitalize font-medium">{{ $campaign->status }}</span> | 
                Template: <span class="capitalize font-medium">{{ $campaign->template }}</span> |
                Sent: {{ $campaign->sent_at ? $campaign->sent_at->format('M d, Y H:i') : 'Not sent yet' }}
            </p>
        </div>
        <div class="flex space-x-3">
            @if($campaign->status === 'draft')
            <form action="{{ route('admin.campaigns.test', $campaign) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-skin-base border border-skin-border text-skin-text rounded-lg hover:bg-skin-base-ter transition-colors">
                    Send Test Email
                </button>
            </form>
            <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="px-4 py-2 bg-skin-base border border-skin-border text-skin-text rounded-lg hover:bg-skin-base-ter transition-colors">
                Edit
            </a>
            <form action="{{ route('admin.campaigns.send', $campaign) }}" method="POST" onsubmit="return confirm('Are you sure you want to send this campaign to all recipients?');">
                @csrf
                <button type="submit" class="px-4 py-2 bg-umera-600 text-white rounded-lg hover:bg-umera-700 transition-colors">
                    Send Campaign
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Campaign Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
                <h3 class="text-lg font-medium text-skin-text mb-4">Content Preview</h3>
                <div class="prose max-w-none p-4 border border-gray-200 rounded-lg bg-gray-50">
                    {!! $campaign->content !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
                <h3 class="text-lg font-medium text-skin-text mb-4">Target Audiences</h3>
                <ul class="divide-y divide-skin-border">
                    @forelse($campaign->audiences as $audience)
                    <li class="py-3 flex justify-between items-center">
                        <span class="text-sm text-skin-text">{{ $audience->name }}</span>
                        <span class="text-xs text-skin-text-muted bg-skin-base-ter px-2 py-1 rounded-full">{{ $audience->contacts()->count() }} contacts</span>
                    </li>
                    @empty
                    <li class="py-3 text-sm text-skin-text-muted">No audiences selected.</li>
                    @endforelse
                </ul>
                <div class="mt-4 pt-4 border-t border-skin-border">
                    <div class="flex justify-between items-center font-medium">
                        <span class="text-skin-text">Total Recipients</span>
                        <span class="text-umera-600">
                            {{ $campaign->audiences->flatMap->contacts->unique('id')->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
