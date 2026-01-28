@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Transactions</h1>
            <p class="text-sm text-skin-text-muted mt-1">Manage and monitor all system transactions.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.transactions.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors w-full sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Record Transaction
            </a>
        </div>
    </div>

    <!-- Filters could go here -->

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-fill">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Investor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-skin-fill transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ $transaction->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-umera-100 dark:bg-umera-900/50 flex items-center justify-center text-umera-700 dark:text-umera-400 font-bold text-xs border border-umera-200 dark:border-umera-800">
                                    {{ substr($transaction->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-skin-text">{{ $transaction->user->name }}</div>
                                    <div class="text-xs text-skin-text-muted">{{ $transaction->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->type === 'deposit' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }} capitalize">
                                {{ $transaction->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text capitalize">
                            {{ str_replace('_', ' ', $transaction->payment_method ?? '-') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            @if($transaction->proof_of_payment)
                                <a href="{{ Storage::url($transaction->proof_of_payment) }}" target="_blank" class="text-umera-600 hover:text-umera-900 underline flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                    View
                                </a>
                            @else
                                <span class="text-skin-text-muted">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-skin-text">
                            ₦{{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Completed
                                </span>
                            @elseif($transaction->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($transaction->status === 'pending')
                                <div class="flex justify-end space-x-2">
                                    <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition-colors" title="Approve">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to reject this transaction?');">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors" title="Reject">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-skin-text-muted text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-skin-text-muted">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-skin-border mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-base font-medium">No transactions found</p>
                                <p class="text-sm mt-1">Get started by recording a new transaction.</p>
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
