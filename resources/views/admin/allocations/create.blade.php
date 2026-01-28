@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Assign Allocation</h1>
        <a href="{{ route('admin.allocations.index') }}" class="text-umera-600 hover:text-umera-700 dark:text-umera-400 dark:hover:text-umera-300 font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Allocations
        </a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border">
        <form action="{{ route('admin.allocations.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Investor -->
                <div class="col-span-1 sm:col-span-2">
                    <label for="user_id" class="block text-sm font-medium text-skin-text">Investor</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm" required>
                        <option value="">Select Investor</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Offering -->
                <div class="col-span-1 sm:col-span-2">
                    <label for="offering_id" class="block text-sm font-medium text-skin-text">Offering</label>
                    <select name="offering_id" id="offering_id" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm" required>
                        <option value="">Select Offering</option>
                        @foreach($offerings as $offering)
                            <option value="{{ $offering->id }}">{{ $offering->name }} - ₦{{ number_format($offering->price, 2) }}/unit</option>
                        @endforeach
                    </select>
                    @error('offering_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-skin-text">Amount Invested (₦)</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm" required>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Units -->
                <div>
                    <label for="units" class="block text-sm font-medium text-skin-text">Units</label>
                    <input type="number" step="0.01" name="units" id="units" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm" required>
                    @error('units')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Allocation Date -->
                <div class="col-span-1 sm:col-span-2">
                    <label for="allocation_date" class="block text-sm font-medium text-skin-text">Allocation Date</label>
                    <input type="date" name="allocation_date" id="allocation_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm" required>
                    @error('allocation_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-skin-border">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                    Assign Allocation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
