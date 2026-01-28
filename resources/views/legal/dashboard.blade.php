@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Legal Dashboard</h1>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Pending Documents -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Total Documents</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                    <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div class="text-2xl font-semibold text-skin-text">{{ $pendingDocuments }}</div>
                <div class="text-xs font-medium text-skin-text-muted">Uploaded</div>
            </div>
        </div>

        <!-- Verified Investors -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Verified Investors</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                    <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div class="text-2xl font-semibold text-skin-text">{{ $verifiedInvestors }}</div>
                <div class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded-full">KYC Complete</div>
            </div>
        </div>
        
        <!-- Pending Reviews -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32">
             <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Pending Reviews</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                    <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div class="text-2xl font-semibold text-skin-text">0</div>
                <div class="text-xs font-medium text-skin-text-muted">Action Required</div>
            </div>
        </div>
        <!-- Bank Transfer Payments -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Bank Transfer Payments</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                    <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 6h14M6 14h12M7 18h10" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <div class="text-2xl font-semibold text-skin-text">{{ $pendingBankTransfersCount }}</div>
                    <div class="text-xs font-medium text-skin-text-muted mt-1">Pending Verifications</div>
                </div>
                <div class="text-right">
                    <div class="text-xs font-medium text-skin-text-muted">Total Pending</div>
                    <div class="text-sm font-semibold text-skin-text">
                        ₦{{ number_format($pendingBankTransfersTotal, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Documents Table -->
    <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-skin-border flex justify-between items-center bg-skin-base-ter/50">
            <h3 class="text-base font-medium text-skin-text">Recent Documents</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Document Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($recentDocuments as $document)
                    <tr class="hover:bg-skin-base-ter transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-skin-text">{{ $document->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ $document->user->name ?? 'N/A' }}
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            {{ $document->type ?? 'General' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            {{ $document->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-umera-600 hover:text-umera-900 dark:hover:text-umera-400">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-skin-text-muted">
                            No recent documents found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Bank Transfer Investments -->
    <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-skin-border flex justify-between items-center bg-skin-base-ter/50">
            <h3 class="text-base font-medium text-skin-text">Recent Bank Transfer Investments</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Investor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Offering</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Proof</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($recentBankTransfers as $transaction)
                    <tr class="hover:bg-skin-base-ter transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ $transaction->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-skin-text">{{ $transaction->user->name }}</div>
                            <div class="text-xs text-skin-text-muted">{{ $transaction->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            {{ optional(optional($transaction->allocation)->offering)->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-skin-text">
                            ₦{{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    Approved
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">
                            @if($transaction->proof_of_payment)
                                <a href="{{ Storage::url($transaction->proof_of_payment) }}" target="_blank" class="text-umera-600 hover:text-umera-900 underline">
                                    View Proof
                                </a>
                            @else
                                <span class="text-skin-text-muted">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.transactions.index') }}" class="text-umera-600 hover:text-umera-900 dark:hover:text-umera-400">
                                View in Admin
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-skin-text-muted">
                            No bank transfer investments found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
