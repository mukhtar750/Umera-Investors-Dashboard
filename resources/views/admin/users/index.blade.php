@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Investors</h1>
            <p class="text-sm text-skin-text-muted mt-1">Manage and monitor all registered investors.</p>
        </div>
        <div class="mt-4 sm:mt-0">
             <!-- Search or Filter could go here -->
        </div>
    </div>

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Joined Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Wallet Balance</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($users as $user)
                    <tr class="hover:bg-skin-fill transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <span class="h-10 w-10 rounded-full bg-umera-100 dark:bg-umera-900/30 flex items-center justify-center text-umera-700 dark:text-umera-400 font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-skin-text">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">{{ $user->created_at->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-skin-text">₦{{ number_format($user->wallet_balance, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-umera-600 hover:text-umera-900 dark:hover:text-umera-400 mr-3">View</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 mr-3">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:hover:text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-skin-text-muted">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-skin-border mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-base font-medium">No investors found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($users->hasPages())
            <div class="bg-skin-base px-4 py-3 border-t border-skin-border sm:px-6">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
