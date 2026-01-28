@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Email Campaigns</h1>
        <a href="{{ route('admin.campaigns.create') }}" class="px-4 py-2 bg-umera-600 text-white rounded-lg hover:bg-umera-700 transition-colors">
            Create Campaign
        </a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border overflow-hidden">
        <table class="min-w-full divide-y divide-skin-border">
            <thead class="bg-skin-base-ter">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Template</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Sent At</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-skin-base divide-y divide-skin-border">
                @forelse($campaigns as $campaign)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-skin-text">
                        <a href="{{ route('admin.campaigns.show', $campaign) }}" class="text-umera-600 hover:text-umera-900">{{ $campaign->subject }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $campaign->status === 'sent' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $campaign->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $campaign->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $campaign->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted capitalize">{{ $campaign->template }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                        {{ $campaign->sent_at ? $campaign->sent_at->format('M d, Y H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.campaigns.show', $campaign) }}" class="text-umera-600 hover:text-umera-900 mr-3">Manage</a>
                        @if($campaign->status === 'draft')
                        <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="text-umera-600 hover:text-umera-900 mr-3">Edit</a>
                        @endif
                        <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-skin-text-muted">No campaigns found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-skin-border">
            {{ $campaigns->links() }}
        </div>
    </div>
</div>
@endsection
