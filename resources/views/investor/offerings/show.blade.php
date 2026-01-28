@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumbs & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center space-x-2 text-sm text-skin-text-muted mb-2">
                <a href="{{ route('investor.dashboard') }}" class="hover:text-skin-text">Dashboard</a>
                <span>/</span>
                <span class="text-skin-text">Offerings</span>
            </div>
            <h1 class="text-2xl font-bold text-skin-text">{{ $offering->name }}</h1>
        </div>
        <div class="mt-4 sm:mt-0">
             <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ $offering->status === 'open' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                   ($offering->status === 'coming_soon' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                {{ ucfirst(str_replace('_', ' ', $offering->status)) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image / Gallery (Placeholder) -->
            <div class="bg-skin-bg-alt rounded-xl aspect-video flex items-center justify-center text-skin-text-muted">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="ml-2">Offering Image</span>
            </div>

            <!-- Description -->
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-skin-text mb-4">About this Opportunity</h3>
                <div class="prose prose-sm max-w-none text-skin-text-muted dark:prose-invert">
                    {{ $offering->description ?? 'No description available.' }}
                </div>
            </div>

            <!-- Location -->
            @if($offering->location)
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-skin-text mb-4">Location</h3>
                <p class="text-skin-text-muted flex items-center">
                    <svg class="w-5 h-5 mr-2 text-skin-text-muted opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $offering->location }}
                </p>
            </div>
            @endif
        </div>

        <!-- Sidebar / Investment Card -->
        <div class="space-y-6">
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-medium text-skin-text mb-6">Investment Details</h3>

                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-skin-border">
                        <span class="text-skin-text-muted">Price per Unit</span>
                        <span class="font-medium text-skin-text">₦{{ number_format($offering->price) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-skin-border">
                        <span class="text-skin-text-muted">Min. Investment</span>
                        <span class="font-medium text-skin-text">₦{{ number_format($offering->min_investment) }}</span>
                    </div>
                     <div class="flex justify-between py-2 border-b border-skin-border">
                        <span class="text-skin-text-muted">Available Units</span>
                        <span class="font-medium text-skin-text">{{ number_format($offering->available_units) }}</span>
                    </div>
                     <div class="flex justify-between py-2 border-b border-skin-border">
                        <span class="text-skin-text-muted">Project Type</span>
                        <span class="font-medium text-skin-text">{{ $offering->type }}</span>
                    </div>
                     @if($offering->start_date)
                     <div class="flex justify-between py-2 border-b border-skin-border">
                        <span class="text-skin-text-muted">Start Date</span>
                        <span class="font-medium text-skin-text">{{ \Carbon\Carbon::parse($offering->start_date)->format('M d, Y') }}</span>
                    </div>
                    @endif
                </div>

                <div class="mt-8">
                    @if($offering->status === 'open')
                        <div x-data="{ units: 1, price: {{ $offering->price }}, paymentMethod: 'wallet' }">
                            <form action="{{ route('investor.offerings.invest', $offering) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label for="units" class="block text-sm font-medium text-skin-text-muted">Number of Units</label>
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <input type="number" name="units" id="units" x-model="units" min="1" required
                                            class="focus:ring-umera-500 focus:border-umera-500 block w-full sm:text-sm border-skin-border bg-skin-base text-skin-text rounded-lg">
                                    </div>
                                    <p class="mt-2 text-sm text-skin-text-muted">
                                        Total Investment: <span class="font-bold text-skin-text">₦<span x-text="(units * price).toLocaleString()"></span></span>
                                    </p>
                                    @error('units')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Method Selection -->
                                <div class="mb-4">
                                    <label for="payment_method" class="block text-sm font-medium text-skin-text-muted">Payment Method</label>
                                    <select name="payment_method" id="payment_method" x-model="paymentMethod"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-skin-border bg-skin-base text-skin-text focus:outline-none focus:ring-umera-500 focus:border-umera-500 sm:text-sm rounded-md">
                                        <option value="wallet">Pay via Wallet</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <!-- Bank Transfer Details -->
                                <div x-show="paymentMethod === 'bank_transfer'" class="mb-4 p-4 bg-skin-bg-alt rounded-lg border border-skin-border">
                                    <h4 class="font-medium text-skin-text mb-2">Bank Account Details</h4>
                                    <p class="text-sm text-skin-text-muted">Please transfer the total amount to:</p>
                                    <div class="mt-2 text-sm space-y-1">
                                        <p><span class="font-medium">Bank Name:</span> Umera Microfinance Bank</p>
                                        <p><span class="font-medium">Account Name:</span> Umera Business Account</p>
                                        <p><span class="font-medium">Account Number:</span> 1234567890</p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label for="proof_of_payment" class="block text-sm font-medium text-skin-text-muted">Upload Proof of Payment</label>
                                        <input type="file" name="proof_of_payment" id="proof_of_payment" accept="image/*,.pdf"
                                            class="mt-1 block w-full text-sm text-skin-text-muted
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-umera-50 text-umera-700
                                            hover:file:bg-umera-100">
                                        <p class="mt-1 text-xs text-skin-text-muted">Accepted formats: JPG, PNG, PDF</p>
                                    </div>
                                </div>

                                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 dark:hover:bg-umera-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                                    Invest Now
                                </button>
                            </form>
                             <p class="mt-2 text-xs text-center text-skin-text-muted">
                                By clicking Invest Now, you agree to our terms.
                            </p>
                        </div>
                    @elseif($offering->status === 'coming_soon')
                         <button disabled class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-neutral-400 dark:bg-neutral-600 cursor-not-allowed">
                            Coming Soon
                        </button>
                    @else
                        <button disabled class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-neutral-400 dark:bg-neutral-600 cursor-not-allowed">
                            Closed
                        </button>
                    @endif
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
                <h3 class="text-base font-medium text-skin-text mb-4">Documents</h3>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-skin-bg-alt rounded-lg">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-skin-text truncate">Investment Prospectus</p>
                            <p class="text-xs text-skin-text-muted">PDF • 2.4 MB</p>
                        </div>
                        <a href="#" class="text-skin-text-muted hover:text-skin-text">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
