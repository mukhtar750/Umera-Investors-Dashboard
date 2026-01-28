@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Documents</h1>
            <p class="text-sm text-skin-text-muted">Access your legal agreements, reports, and investment documents</p>
        </div>
    </div>

    <!-- Documents Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $document)
        <div class="bg-skin-base rounded-xl shadow-sm border border-skin-border p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 bg-skin-bg-alt rounded-lg flex items-center justify-center text-skin-text-muted">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-skin-text line-clamp-2">{{ $document->title }}</h3>
                    <p class="mt-1 text-xs text-skin-text-muted">{{ $document->created_at->format('M d, Y') }}</p>
                    <span class="mt-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-skin-bg-alt text-skin-text capitalize">
                        {{ $document->type }}
                    </span>
                    @if($document->offering)
                    <p class="mt-2 text-xs text-skin-text-muted">Re: {{ $document->offering->name }}</p>
                    @endif
                </div>
            </div>
            
            @if($document->status === 'pending_signature')
            <div class="mt-4 pt-4 border-t border-skin-border">
                <p class="text-xs text-yellow-600 font-semibold mb-2">Action Required: Please sign and upload.</p>
                <form action="{{ route('investor.documents.upload-signed', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <input type="file" name="file" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                        Upload Signed Copy
                    </button>
                </form>
            </div>
            @endif

            @if($document->status === 'signed')
             <div class="mt-4 pt-4 border-t border-skin-border">
                <span class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-100">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Signed & Uploaded
                </span>
            </div>
            @endif

            <div class="mt-4 pt-4 border-t border-skin-border">
                <a href="{{ route('investor.documents.download', $document) }}" class="flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 dark:hover:bg-umera-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-skin-base rounded-xl border border-skin-border border-dashed">
            <svg class="mx-auto h-12 w-12 text-skin-text-muted opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-skin-text">No documents</h3>
            <p class="mt-1 text-sm text-skin-text-muted">You don't have any documents yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
