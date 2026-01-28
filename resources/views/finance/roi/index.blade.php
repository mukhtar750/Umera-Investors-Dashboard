@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">ROI Management</h1>
            <p class="text-sm text-skin-text-muted mt-1">Select an offering to calculate and process ROI payments.</p>
        </div>
    </div>

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Offering</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">ROI %</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Total Invested</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Investors</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Maturity Date</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($offerings as $offering)
                    <tr class="hover:bg-skin-base-ter transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-umera-100 dark:bg-umera-900/30 flex items-center justify-center text-xs font-bold text-umera-700 dark:text-umera-300">
                                    {{ substr($offering->name, 0, 2) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-skin-text">{{ $offering->name }}</div>
                                    <div class="text-xs text-skin-text-muted">{{ $offering->status }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ $offering->type }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ $offering->roi_percentage ?? '0' }}%
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            ₦{{ number_format($offering->total_invested ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ $offering->investor_count ?? 0 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ $offering->end_date ? \Carbon\Carbon::parse($offering->end_date)->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('finance.roi.show', $offering) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-umera-700 bg-umera-100 hover:bg-umera-200 dark:bg-umera-900/30 dark:text-umera-300 dark:hover:bg-umera-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                                Manage ROI
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-skin-text-muted">
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
