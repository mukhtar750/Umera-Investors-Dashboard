@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Audiences</h1>
        <a href="{{ route('admin.audiences.create') }}" class="px-4 py-2 bg-umera-600 text-white rounded-lg hover:bg-umera-700 transition-colors">
            Create Audience
        </a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border overflow-hidden">
        <table class="min-w-full divide-y divide-skin-border">
            <thead class="bg-skin-base-ter">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Contacts</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-skin-base divide-y divide-skin-border">
                @forelse($audiences as $audience)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-skin-text">
                        <a href="{{ route('admin.audiences.show', $audience) }}" class="text-umera-600 hover:text-umera-900">{{ $audience->name }}</a>
                    </td>
                    <td class="px-6 py-4 text-sm text-skin-text-muted">{{ Str::limit($audience->description, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">{{ $audience->contacts_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">{{ $audience->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.audiences.show', $audience) }}" class="text-umera-600 hover:text-umera-900 mr-3">Manage</a>
                        <form action="{{ route('admin.audiences.destroy', $audience) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-skin-text-muted">No audiences found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-skin-border">
            {{ $audiences->links() }}
        </div>
    </div>
</div>
@endsection
