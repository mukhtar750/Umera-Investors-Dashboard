<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-skin-text">Documents</h2>
            <a href="{{ route('admin.documents.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Document
            </a>
        </div>

        <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-skin-border">
                    <thead class="bg-skin-base-ter">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Document</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Associated With</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Uploaded At</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-skin-base divide-y divide-skin-border">
                        @foreach($documents as $document)
                        <tr class="hover:bg-skin-base-ter transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 text-skin-text-muted">
                                        <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-skin-text">{{ $document->title }}</div>
                                        <div class="text-sm text-skin-text-muted">{{ Str::upper(pathinfo($document->file_path, PATHINFO_EXTENSION)) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ ucfirst($document->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                                @if($document->offering)
                                    Offering: {{ $document->offering->name }}
                                @elseif($document->user)
                                    User: {{ $document->user->name }}
                                @else
                                    <span class="text-skin-text-muted italic">General</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                                {{ $document->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.documents.download', $document) }}" class="text-umera-600 hover:text-umera-900 mr-3">Download</a>
                                @if($document->status === 'signed' && $document->signed_file_path)
                                     <a href="{{ Storage::disk('public')->url($document->signed_file_path) }}" target="_blank" class="text-green-600 hover:text-green-900 mr-3">View Signed</a>
                                @endif
                                <form action="{{ route('admin.documents.destroy', $document) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-skin-border">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>