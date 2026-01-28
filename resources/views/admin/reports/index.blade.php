@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">System Reports</h1>
            <p class="mt-1 text-sm text-skin-text-muted">Overview of system performance and statistics.</p>
        </div>
        <div>
            <a href="{{ route('admin.reports.export') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors w-full sm:w-auto justify-center">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export Transaction Report
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Investors -->
        <div class="bg-skin-base rounded-xl border border-skin-border p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-skin-text-muted">Total Investors</p>
                    <p class="text-2xl font-semibold text-skin-text">{{ number_format($totalInvestors) }}</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">+{{ $newInvestorsThisMonth }} this month</p>
                </div>
            </div>
        </div>

        <!-- Total Invested -->
        <div class="bg-skin-base rounded-xl border border-skin-border p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-skin-text-muted">Total Invested</p>
                    <p class="text-2xl font-semibold text-skin-text">₦{{ number_format($totalInvestedAmount, 2) }}</p>
                    <p class="text-xs text-skin-text-muted mt-1">{{ number_format($totalAllocations) }} allocations</p>
                </div>
            </div>
        </div>

        <!-- Wallet Balances -->
        <div class="bg-skin-base rounded-xl border border-skin-border p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-skin-text-muted">Wallet Holdings</p>
                    <p class="text-2xl font-semibold text-skin-text">₦{{ number_format($totalWalletBalance, 2) }}</p>
                    <p class="text-xs text-skin-text-muted mt-1">Total user balance</p>
                </div>
            </div>
        </div>

        <!-- Offerings -->
        <div class="bg-skin-base rounded-xl border border-skin-border p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-skin-text-muted">Offerings</p>
                    <p class="text-2xl font-semibold text-skin-text">{{ $totalOfferings }}</p>
                    <p class="text-xs text-skin-text-muted mt-1">{{ $activeOfferings }} active, {{ $completedOfferings }} closed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Financial Summary -->
        <div class="bg-skin-base rounded-xl border border-skin-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-skin-border bg-skin-fill">
                <h3 class="text-lg font-medium text-skin-text">Financial Summary</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-skin-fill rounded-xl">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                            </div>

                            <span class="text-skin-text-muted font-medium">Total Deposits</span>
                        </div>
                        <span class="text-lg font-bold text-skin-text">₦{{ number_format($totalDeposits, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-skin-fill rounded-xl">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                            </div>
                            <span class="text-skin-text-muted font-medium">Total Withdrawals</span>
                        </div>
                        <span class="text-lg font-bold text-skin-text">₦{{ number_format($totalWithdrawals, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-skin-fill rounded-xl">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-skin-text-muted font-medium">Total ROI Distributed</span>
                        </div>
                        <span class="text-lg font-bold text-skin-text">₦{{ number_format($totalDistributions, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-skin-base rounded-xl border border-skin-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-skin-border bg-skin-fill flex justify-between items-center">
                <h3 class="text-lg font-medium text-skin-text">Recent Transactions</h3>
                <a href="{{ route('admin.transactions.index') }}" class="text-sm text-umera-600 hover:text-umera-700 font-medium">View All</a>
            </div>
            <div class="divide-y divide-skin-border">
                @forelse($recentTransactions as $transaction)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-skin-fill/50 transition-colors">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-skin-fill flex items-center justify-center mr-3">
                                @if($transaction->type == 'deposit')
                                    <span class="text-green-600 dark:text-green-400">↓</span>
                                @elseif($transaction->type == 'withdrawal')
                                    <span class="text-red-600 dark:text-red-400">↑</span>
                                @else
                                    <span class="text-blue-600 dark:text-blue-400">↔</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-skin-text">{{ $transaction->user->name ?? 'Unknown User' }}</p>
                                <p class="text-xs text-skin-text-muted">{{ ucfirst($transaction->type) }} • {{ $transaction->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium {{ $transaction->type == 'deposit' ? 'text-green-600 dark:text-green-400' : ($transaction->type == 'withdrawal' ? 'text-red-600 dark:text-red-400' : 'text-skin-text') }}">
                                {{ $transaction->type == 'withdrawal' ? '-' : '+' }}₦{{ number_format($transaction->amount, 2) }}
                            </p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400') }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-skin-text-muted">
                        No recent transactions found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection