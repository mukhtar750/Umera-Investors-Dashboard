@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-skin-text">Announcements</h1>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors w-full sm:w-auto">
            Create Announcement
        </a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($announcements as $announcement)
                    <tr class="hover:bg-skin-base-ter transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-skin-text">{{ $announcement->title }}</div>
                            <div class="text-xs text-skin-text-muted line-clamp-1">{{ Str::limit($announcement->content, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $announcement->is_published ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400' }}">
                                {{ $announcement->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">{{ $announcement->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-umera-600 hover:text-umera-900 dark:hover:text-umera-400">Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:hover:text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-skin-text-muted">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-skin-border mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                                <p class="text-base font-medium">No announcements found</p>
                                <p class="text-sm mt-1">Create a new announcement to keep investors informed.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
