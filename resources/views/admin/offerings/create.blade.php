@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Create New Offering</h1>
        <a href="{{ route('admin.offerings.index') }}" class="text-umera-600 hover:text-umera-700 dark:text-umera-400 dark:hover:text-umera-300 font-medium flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Offerings
        </a>
    </div>

    <div class="bg-skin-base border border-skin-border rounded-lg shadow-sm">
        <form action="{{ route('admin.offerings.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-skin-text">Offering Name</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-skin-text">Type</label>
                    <select name="type" id="type"
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        <option value="Land Banking">Land Banking</option>
                        <option value="Rental">Rental</option>
                        <option value="Flip">Flip</option>
                        <option value="Construction">Construction</option>
                    </select>
                </div>

                <!-- Min Investment -->
                <div>
                    <label for="min_investment" class="block text-sm font-medium text-skin-text">Min. Investment (₦)</label>
                    <input type="number" name="min_investment" id="min_investment" required min="0" step="0.01"
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                </div>

                <!-- Price per Unit -->
                <div>
                    <label for="price" class="block text-sm font-medium text-skin-text">Price per Unit (₦)</label>
                    <input type="number" name="price" id="price" min="0" step="0.01"
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                </div>

                 <!-- Total Units -->
                 <div>
                    <label for="total_units" class="block text-sm font-medium text-skin-text">Total Units</label>
                    <input type="number" name="total_units" id="total_units" min="0" step="1"
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-skin-text">Status</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        <option value="coming_soon">Coming Soon</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                 <!-- Location -->
                 <div>
                    <label for="location" class="block text-sm font-medium text-skin-text">Location</label>
                    <input type="text" name="location" id="location"
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                </div>
            </div>

             <!-- Description -->
             <div>
                <label for="description" class="block text-sm font-medium text-skin-text">Description</label>
                <textarea name="description" id="description" rows="4" required
                    class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm"></textarea>
            </div>

            <!-- Start/End Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div>
                    <label for="start_date" class="block text-sm font-medium text-skin-text">Start Date</label>
                    <input type="date" name="start_date" id="start_date"
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                </div>
                 <div>
                    <label for="end_date" class="block text-sm font-medium text-skin-text">End Date</label>
                    <input type="date" name="end_date" id="end_date"
                        class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-skin-border">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                    Create Offering
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
