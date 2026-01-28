@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Import History</h1>
        <a href="{{ route('admin.investors.import') }}" class="text-sm text-umera-600 hover:text-umera-700">Start New Import</a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border">
        <table class="min-w-full divide-y divide-skin-border">
            <thead class="bg-skin-base-ter/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Session</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">File</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Processed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Success</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Failed</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Started</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Completed</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-skin-border">
                @foreach($sessions as $s)
                <tr>
                    <td class="px-6 py-4 text-sm text-skin-text">#{{ $s->id }}</td>
                    <td class="px-6 py-4 text-sm text-skin-text-muted">{{ $s->file_name }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $s->status === 'completed' ? 'bg-green-100 text-green-800' : ($s->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-skin-text">{{ $s->processed_rows }}/{{ $s->total_rows }}</td>
                    <td class="px-6 py-4 text-sm text-green-600">{{ $s->successful_rows }}</td>
                    <td class="px-6 py-4 text-sm text-red-600">{{ $s->failed_rows }}</td>
                    <td class="px-6 py-4 text-sm text-skin-text-muted">{{ optional($s->started_at)->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 text-sm text-skin-text-muted">{{ optional($s->completed_at)->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.imports.show', $s) }}" class="text-umera-600 hover:text-umera-700">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $sessions->links() }}
    </div>
</div>
@endsection
