@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Transaction History</h1>
    </div>

    @forelse($allocations as $allocation)
    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border overflow-hidden">
        <div class="px-6 py-4 border-b border-skin-border bg-skin-base-ter/50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-skin-text">{{ $allocation->offering->name }}</h3>
                <p class="text-xs text-skin-text-muted">{{ $allocation->block_name }} • Unit {{ $allocation->unit_number }}</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $allocation->moa_signed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $allocation->moa_signed ? 'MOA Signed' : 'MOA Pending' }}
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Label</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($allocation->transactions as $transaction)
                    @php
                        $label = $transaction->description;
                        if (preg_match('/Year\\s*(\\d+)/i', $transaction->description, $m)) {
                            $label = 'ROI – Year ' . $m[1];
                        }
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-skin-text">{{ $transaction->reference ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">{{ $label }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">₦{{ number_format($transaction->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $transaction->status === 'completed' || $transaction->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                                   ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300') }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            <a href="{{ route('investor.transactions.receipt', $transaction) }}" target="_blank" class="text-umera-600 hover:text-umera-900 dark:hover:text-umera-400 font-medium">Receipt</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-skin-text-muted">No transactions for this allocation.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6 text-center text-sm text-skin-text-muted">
        No transactions found.
    </div>
    @endforelse
@endsection
