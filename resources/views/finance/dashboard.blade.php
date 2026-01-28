@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Finance Overview</h1>
            <p class="text-sm text-skin-text-muted mt-1">Manage ROI payments, transactions, and financial health.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
             <a href="{{ route('finance.roi.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Process ROI
            </a>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Capital Raised -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Total Capital Raised</h3>
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-skin-text">₦{{ number_format($totalCapitalRaised, 2) }}</div>
                <p class="text-xs text-skin-text-muted mt-1">Active investments</p>
            </div>
        </div>

        <!-- Total ROI Paid -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Total ROI Paid</h3>
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-full">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-skin-text">₦{{ number_format($totalRoiPaid, 2) }}</div>
                <p class="text-xs text-skin-text-muted mt-1">Lifetime distributions</p>
            </div>
        </div>

        <!-- Pending Withdrawals -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Pending Withdrawals</h3>
                <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-full">
                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-bold text-skin-text">{{ $pendingWithdrawals }}</div>
                <p class="text-xs text-skin-text-muted mt-1">Total: ₦{{ number_format($pendingWithdrawalAmount, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Upcoming Maturities -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-skin-border flex justify-between items-center bg-skin-base-ter/50">
                    <h3 class="text-base font-medium text-skin-text">Upcoming Maturities</h3>
                    <a href="{{ route('finance.roi.index') }}" class="text-sm text-umera-600 dark:text-umera-400 hover:text-umera-700 dark:hover:text-umera-300 font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-skin-border">
                        <thead class="bg-skin-base-ter">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Offering</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Maturity Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-skin-base divide-y divide-skin-border">
                            @forelse($upcomingMaturities as $offering)
                            <tr class="hover:bg-skin-base-ter transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-umera-100 dark:bg-umera-900/30 flex items-center justify-center text-xs font-bold text-umera-700 dark:text-umera-300">
                                            {{ substr($offering->name, 0, 2) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-skin-text">{{ $offering->name }}</div>
                                            <div class="text-xs text-skin-text-muted">{{ $offering->type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                                    {{ \Carbon\Carbon::parse($offering->end_date)->format('M d, Y') }}
                                    <span class="text-xs text-skin-text-muted block">({{ \Carbon\Carbon::parse($offering->end_date)->diffForHumans() }})</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('finance.roi.show', $offering) }}" class="text-umera-600 hover:text-umera-900 dark:text-umera-400 dark:hover:text-umera-300">Calculate ROI</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-skin-text-muted">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-skin-border mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        No upcoming maturities found.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column (Quick Actions/Info) -->
        <div class="space-y-6">
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
                <h3 class="text-base font-medium text-skin-text mb-4">Quick Links</h3>
                <div class="space-y-3">
                    <a href="{{ route('finance.transactions.index') }}" class="w-full flex items-center justify-between p-3 border border-skin-border rounded-md hover:bg-skin-base-ter hover:border-umera-200 dark:hover:border-umera-700 transition-all group">
                        <span class="text-sm font-medium text-skin-text-muted group-hover:text-umera-700 dark:group-hover:text-umera-400">View All Transactions</span>
                        <svg class="w-5 h-5 text-skin-text-muted group-hover:text-umera-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
