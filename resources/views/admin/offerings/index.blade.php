@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-skin-text">Offerings</h1>
        <a href="{{ route('admin.offerings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Offering
        </a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-fill">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Investment</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Units</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($offerings as $offering)
                    <tr class="hover:bg-skin-fill transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-skin-fill rounded-md flex items-center justify-center">
                                    <svg class="h-6 w-6 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-skin-text">{{ $offering->name }}</div>
                                    <div class="text-xs text-skin-text-muted">{{ $offering->location ?? 'No location' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">{{ $offering->type ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">₦{{ number_format($offering->target_amount) }}</div>
                            <div class="text-xs text-skin-text-muted">Min: ₦{{ number_format($offering->min_investment) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">{{ $offering->available_units }} / {{ $offering->total_units }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $offering->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : ($offering->status === 'coming_soon' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300') }} capitalize">
                                {{ str_replace('_', ' ', $offering->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.offerings.edit', $offering) }}" class="text-umera-600 hover:text-umera-700 dark:text-umera-400 dark:hover:text-umera-300 mr-3">Edit</a>
                            <form action="{{ route('admin.offerings.destroy', $offering) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this offering?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-skin-text-muted">
                            No offerings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($offerings->hasPages())
        <div class="bg-skin-base px-4 py-3 border-t border-skin-border sm:px-6">
            {{ $offerings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
