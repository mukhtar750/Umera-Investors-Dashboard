@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-skin-text">My Wallet</h1>
        <div class="text-sm text-skin-text-muted">Manage your funds and transactions</div>
    </div>

    <!-- Balance Card & Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Balance -->
        <div class="bg-skin-base rounded-xl shadow-sm border border-skin-border p-6 md:col-span-1">
            <h3 class="text-sm font-medium text-skin-text-muted mb-1">Available Balance</h3>
            <div class="text-3xl font-bold text-skin-text">₦{{ number_format(auth()->user()->wallet_balance, 2) }}</div>
            <div class="mt-4 flex space-x-3" x-data="{ depositOpen: false, withdrawOpen: false }">
                <button @click="depositOpen = true" class="flex-1 bg-umera-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-umera-700 transition-colors">
                    Deposit
                </button>
                <button @click="withdrawOpen = true" class="flex-1 bg-skin-base border border-skin-border text-skin-text px-4 py-2 rounded-lg text-sm font-medium hover:bg-skin-bg-alt transition-colors">
                    Withdraw
                </button>

                <!-- Deposit Modal -->
                <div x-show="depositOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="depositOpen = false">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-skin-base rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form action="{{ route('investor.wallet.deposit') }}" method="POST">
                                @csrf
                                <div class="bg-skin-base px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-skin-text mb-4">Deposit Funds</h3>
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-skin-text-muted">Amount (₦)</label>
                                        <input type="number" name="amount" id="amount" required min="1000" class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                                        <p class="mt-2 text-xs text-skin-text-muted">Min: ₦1,000</p>
                                    </div>
                                </div>
                                <div class="bg-skin-bg-alt px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-umera-600 text-base font-medium text-white hover:bg-umera-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                        Proceed
                                    </button>
                                    <button type="button" @click="depositOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-skin-border shadow-sm px-4 py-2 bg-skin-base text-base font-medium text-skin-text hover:bg-skin-bg-alt focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Withdraw Modal -->
                <div x-show="withdrawOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="withdrawOpen = false">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-skin-base rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form action="{{ route('investor.wallet.withdraw') }}" method="POST">
                                @csrf
                                <div class="bg-skin-base px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-skin-text mb-4">Withdraw Funds</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="w_amount" class="block text-sm font-medium text-skin-text-muted">Amount (₦)</label>
                                            <input type="number" name="amount" id="w_amount" required min="1000" class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                                        </div>
                                        <div>
                                            <label for="bank_name" class="block text-sm font-medium text-skin-text-muted">Bank Name</label>
                                            <input type="text" name="bank_name" id="bank_name" required class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                                        </div>
                                        <div>
                                            <label for="account_number" class="block text-sm font-medium text-skin-text-muted">Account Number</label>
                                            <input type="text" name="account_number" id="account_number" required class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-skin-bg-alt px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                        Withdraw
                                    </button>
                                    <button type="button" @click="withdrawOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-skin-border shadow-sm px-4 py-2 bg-skin-base text-base font-medium text-skin-text hover:bg-skin-bg-alt focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats (Placeholder for future) -->
        <div class="bg-skin-base rounded-xl shadow-sm border border-skin-border p-6 md:col-span-2">
            <h3 class="text-sm font-medium text-skin-text-muted mb-4">Monthly Overview</h3>
            <div class="h-32 bg-skin-base-ter rounded-lg flex items-center justify-center text-skin-text-muted">
                <span class="text-sm">Transaction analytics coming soon</span>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-skin-base rounded-xl shadow-sm border border-skin-border overflow-hidden">
        <div class="px-6 py-4 border-b border-skin-border">
            <h3 class="text-lg font-medium text-skin-text">Transaction History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            {{ $transaction->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-skin-text">
                            {{ $transaction->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            {{ $transaction->reference }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted capitalize">
                            {{ str_replace('_', ' ', $transaction->type) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium {{ $transaction->type == 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type == 'deposit' ? '+' : '-' }}₦{{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $transaction->status === 'completed' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : '' }}
                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' : '' }}
                                {{ $transaction->status === 'failed' ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' : '' }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('investor.transactions.receipt', $transaction) }}" target="_blank" class="text-umera-600 hover:text-umera-900 dark:hover:text-umera-400">Receipt</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-skin-text-muted">
                            No transactions found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-skin-border">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
