@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Investor Profile</h1>
        <a href="{{ route('admin.users.index') }}" class="mt-4 sm:mt-0 text-sm text-umera-600 hover:text-umera-700 dark:hover:text-umera-400 font-medium inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Investors
        </a>
    </div>

    <!-- User Info Card -->
    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border p-6">
        <div class="flex flex-col sm:flex-row items-center sm:space-x-4">
            <div class="h-16 w-16 rounded-full bg-umera-100 dark:bg-umera-900/30 flex items-center justify-center text-2xl text-umera-600 dark:text-umera-400 font-bold mb-4 sm:mb-0">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="text-center sm:text-left">
                <h2 class="text-xl font-bold text-skin-text">{{ $user->name }}</h2>
                <p class="text-sm text-skin-text-muted">{{ $user->email }}</p>
                <p class="text-sm text-skin-text-muted">Joined {{ $user->created_at->format('M d, Y') }}</p>
                @if($user->phone)
                <p class="text-sm text-skin-text-muted">{{ $user->phone }}</p>
                @endif
            </div>
            <div class="sm:ml-auto text-center sm:text-right mt-4 sm:mt-0 w-full sm:w-auto border-t sm:border-t-0 border-skin-border pt-4 sm:pt-0">
                <p class="text-sm text-skin-text-muted">Wallet Balance</p>
                <p class="text-2xl font-bold text-umera-600 dark:text-umera-400">₦{{ number_format($user->wallet_balance, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Profile Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
            <div class="px-6 py-4 border-b border-skin-border bg-skin-base-ter/50">
                <h3 class="text-lg font-medium text-skin-text">Personal Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-medium text-skin-text-muted uppercase">Phone</p>
                        <p class="text-sm text-skin-text">{{ $user->phone ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-skin-text-muted uppercase">Date of Birth</p>
                        <p class="text-sm text-skin-text">{{ $user->dob ?: 'N/A' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-medium text-skin-text-muted uppercase">Address</p>
                    <p class="text-sm text-skin-text">{{ $user->address ?: 'N/A' }}</p>
                </div>
                @if($user->custom_fields)
                <div>
                    <p class="text-xs font-medium text-skin-text-muted uppercase">Other Import Data</p>
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($user->custom_fields as $key => $value)
                            @if(!empty($value) && $value !== 'N/A' && $value !== 'nil')
                            <div class="bg-skin-base-ter p-2 rounded border border-skin-border">
                                <p class="text-[10px] font-bold text-skin-text-muted uppercase">{{ str_replace('_', ' ', $key) }}</p>
                                <p class="text-xs text-skin-text">{{ $value }}</p>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Next of Kin Information -->
        <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
            <div class="px-6 py-4 border-b border-skin-border bg-skin-base-ter/50">
                <h3 class="text-lg font-medium text-skin-text">Next of Kin</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-medium text-skin-text-muted uppercase">Name</p>
                        <p class="text-sm text-skin-text">{{ $user->next_of_kin_name ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-skin-text-muted uppercase">Relationship</p>
                        <p class="text-sm text-skin-text">{{ $user->next_of_kin_relationship ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-skin-text-muted uppercase">Email</p>
                        <p class="text-sm text-skin-text">{{ $user->next_of_kin_email ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-skin-text-muted uppercase">Phone</p>
                        <p class="text-sm text-skin-text">{{ $user->next_of_kin_phone ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Allocations -->
        <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
            <div class="px-6 py-4 border-b border-skin-border bg-skin-base-ter/50">
                <h3 class="text-lg font-medium text-skin-text">Investments</h3>
            </div>
            <ul class="divide-y divide-skin-border">
                @forelse($user->allocations as $allocation)
                <li class="px-6 py-4 hover:bg-skin-base-ter transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-skin-text">{{ $allocation->offering->name }}</p>
                            <p class="text-xs text-skin-text-muted">{{ $allocation->units }} units • {{ $allocation->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-skin-text">₦{{ number_format($allocation->amount, 2) }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                {{ $allocation->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                                   ($allocation->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-400') }} capitalize">
                                {{ $allocation->status }}
                            </span>
                        </div>
                    </div>
                </li>
                @empty
                <li class="px-6 py-4 text-center text-sm text-skin-text-muted">No investments yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
            <div class="px-6 py-4 border-b border-skin-border bg-skin-base-ter/50">
                <h3 class="text-lg font-medium text-skin-text">Recent Transactions</h3>
            </div>
            <ul class="divide-y divide-skin-border">
                @forelse($user->transactions()->latest()->take(5)->get() as $transaction)
                <li class="px-6 py-4 hover:bg-skin-base-ter transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-skin-text">{{ $transaction->description }}</p>
                            <p class="text-xs text-skin-text-muted">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold {{ $transaction->type == 'deposit' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $transaction->type == 'deposit' ? '+' : '-' }}₦{{ number_format($transaction->amount, 2) }}
                            </p>
                            <span class="text-xs text-skin-text-muted capitalize">{{ $transaction->status }}</span>
                        </div>
                    </div>
                </li>
                @empty
                <li class="px-6 py-4 text-center text-sm text-skin-text-muted">No transactions yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-skin-border bg-skin-base-ter/50 flex justify-between items-center">
            <h3 class="text-lg font-medium text-skin-text">Documents</h3>
            <!-- Optional: Add Upload Button here if needed -->
        </div>
        <ul class="divide-y divide-skin-border">
            @forelse($user->documents as $document)
            <li class="px-6 py-4 hover:bg-skin-base-ter transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-skin-text-muted mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-skin-text">{{ $document->name }}</p>
                            <p class="text-xs text-skin-text-muted">Uploaded {{ $document->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($document->status) }}
                        </span>
                        <a href="{{ route('admin.documents.download', $document) }}" class="text-umera-600 hover:text-umera-900 p-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-4 text-center text-sm text-skin-text-muted">No documents uploaded.</li>
            @endforelse
        </ul>
    </div>

</div>
@endsection
