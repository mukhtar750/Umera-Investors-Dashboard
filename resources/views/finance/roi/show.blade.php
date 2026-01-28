@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('finance.roi.index') }}" class="text-skin-text-muted hover:text-skin-text">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-skin-text">ROI Payout: {{ $offering->name }}</h1>
            </div>
            <p class="text-sm text-skin-text-muted mt-1 ml-7">Review and process ROI payments for this offering.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $offering->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($offering->status) }}
            </span>
        </div>
    </div>

    <!-- Offering Summary -->
    <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-sm text-skin-text-muted">ROI Percentage</p>
                <p class="text-xl font-bold text-skin-text">{{ $offering->roi_percentage ?? 0 }}%</p>
            </div>
            <div>
                <p class="text-sm text-skin-text-muted">Total Capital</p>
                <p class="text-xl font-bold text-skin-text">₦{{ number_format($allocations->sum('amount'), 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-skin-text-muted">Total ROI Payable</p>
                <p class="text-xl font-bold text-skin-text text-umera-600">₦{{ number_format($allocations->sum('expected_roi'), 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-skin-text-muted">Total Payout</p>
                <p class="text-xl font-bold text-skin-text">₦{{ number_format($allocations->sum('total_payout'), 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Investors List -->
    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="px-6 py-5 border-b border-skin-border flex justify-between items-center bg-skin-base-ter/50">
            <h3 class="text-base font-medium text-skin-text">Investor Allocations</h3>
            <form action="{{ route('finance.roi.pay-all', $offering) }}" method="POST" onsubmit="return confirm('Are you sure you want to process ROI payments for ALL investors in this offering? This action cannot be undone.');">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 disabled:opacity-50">
                    Process All Payments
                </button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Investor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Invested Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">ROI ({{ $offering->roi_percentage }}%)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Total Payout</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($allocations as $allocation)
                    <tr class="hover:bg-skin-base-ter transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-400">
                                    {{ substr($allocation->user->name, 0, 2) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-skin-text">{{ $allocation->user->name }}</div>
                                    <div class="text-xs text-skin-text-muted">{{ $allocation->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            ₦{{ number_format($allocation->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                            +₦{{ number_format($allocation->expected_roi, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-skin-text">
                            ₦{{ number_format($allocation->total_payout, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('finance.roi.pay', $allocation) }}" method="POST" onsubmit="return confirm('Process ROI payment for {{ $allocation->user->name }}?');">
                                @csrf
                                <button type="submit" class="text-umera-600 hover:text-umera-900 dark:text-umera-400 dark:hover:text-umera-300">Pay Now</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-skin-text-muted">
                            No active allocations found for this offering.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
