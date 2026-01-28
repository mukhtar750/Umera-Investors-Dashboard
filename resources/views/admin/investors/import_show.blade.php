@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Import Session #{{ $session->id }}</h1>
        <a href="{{ route('admin.imports.index') }}" class="text-sm text-umera-600 hover:text-umera-700">Back to History</a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <dt class="text-xs text-skin-text-muted uppercase">File</dt>
                <dd class="text-sm text-skin-text">{{ $session->file_name }}</dd>
            </div>
            <div>
                <dt class="text-xs text-skin-text-muted uppercase">Status</dt>
                <dd>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $session->status === 'completed' ? 'bg-green-100 text-green-800' : ($session->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : ($session->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ ucfirst($session->status) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-xs text-skin-text-muted uppercase">Progress</dt>
                <dd class="text-sm text-skin-text">{{ $session->processed_rows }}/{{ $session->total_rows }}</dd>
            </div>
            <div>
                <dt class="text-xs text-skin-text-muted uppercase">Success / Failed</dt>
                <dd class="text-sm"><span class="text-green-600">{{ $session->successful_rows }}</span> / <span class="text-red-600">{{ $session->failed_rows }}</span></dd>
            </div>
            <div>
                <dt class="text-xs text-skin-text-muted uppercase">Started</dt>
                <dd class="text-sm text-skin-text">{{ optional($session->started_at)->format('M d, Y H:i') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-skin-text-muted uppercase">Completed</dt>
                <dd class="text-sm text-skin-text">{{ optional($session->completed_at)->format('M d, Y H:i') }}</dd>
            </div>
        </dl>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
        <h3 class="text-lg font-medium text-skin-text mb-3">Progress</h3>
        <div class="w-full bg-skin-base-ter rounded h-3 overflow-hidden">
            <div id="progress-bar" class="bg-umera-600 h-3" style="width: 0%"></div>
        </div>
        <div class="mt-2 text-sm text-skin-text-muted">
            <span id="progress-text">{{ $session->processed_rows }}/{{ $session->total_rows }}</span>
            <span class="ml-2">
                Success: <span id="success-count">{{ $session->successful_rows }}</span> •
                Failed: <span id="failed-count">{{ $session->failed_rows }}</span>
            </span>
            <span class="ml-2">
                Status: <span id="status-badge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">{{ ucfirst($session->status) }}</span>
            </span>
        </div>
    </div>

    @if($session->error_report_path)
    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
        <h3 class="text-lg font-medium text-skin-text mb-2">Error Report</h3>
        <a href="{{ route('admin.imports.error-report', $session) }}" class="text-sm text-umera-600 hover:text-umera-700">Download CSV</a>
    </div>
    @endif
</div>

<script>
    const sessionId = {{ $session->id }};
    function updateProgress(data) {
        const total = data.total_rows || 0;
        const processed = data.processed_rows || 0;
        const percent = total > 0 ? Math.round((processed / total) * 100) : 0;
        document.getElementById('progress-bar').style.width = percent + '%';
        document.getElementById('progress-text').textContent = processed + '/' + total;
        document.getElementById('success-count').textContent = data.successful_rows || 0;
        document.getElementById('failed-count').textContent = data.failed_rows || 0;
        const statusEl = document.getElementById('status-badge');
        statusEl.textContent = (data.status || 'pending').charAt(0).toUpperCase() + (data.status || 'pending').slice(1);
        statusEl.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' + (
            data.status === 'completed' ? 'bg-green-100 text-green-800' :
            data.status === 'processing' ? 'bg-yellow-100 text-yellow-800' :
            data.status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'
        );
    }
    async function poll() {
        try {
            const res = await fetch('{{ route('admin.imports.progress', $session) }}');
            const data = await res.json();
            updateProgress(data);
            if (data.status === 'completed' || data.status === 'failed') return;
        } catch (e) {}
        setTimeout(poll, 2000);
    }
    poll();
</script>
@endsection
