@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Transactions</h1>
            <p class="text-sm text-skin-text-muted mt-1">History of all financial transactions.</p>
        </div>
        <div class="mt-4 sm:mt-0">
             <!-- Export button could go here -->
        </div>
    </div>

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Reference</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-skin-base-ter transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text font-mono">
                            {{ $transaction->reference ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-skin-text">{{ $transaction->user->name }}</div>
                            <div class="text-xs text-skin-text-muted">{{ $transaction->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                {{ $transaction->type === 'deposit' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $transaction->type === 'withdrawal' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $transaction->type === 'investment_payment' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $transaction->type === 'roi_payment' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ str_replace('_', ' ', $transaction->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-skin-text">
                            ₦{{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $transaction->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $transaction->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            {{ $transaction->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('finance.transactions.receipt', $transaction) }}" target="_blank" class="text-umera-600 hover:text-umera-900 dark:text-umera-400 dark:hover:text-umera-300">
                                Receipt
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-skin-text-muted">
                            No transactions found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="bg-skin-base px-4 py-3 border-t border-skin-border sm:px-6">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
