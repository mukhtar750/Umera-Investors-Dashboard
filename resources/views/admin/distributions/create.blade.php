@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Create Distribution</h1>
        <a href="{{ route('admin.distributions.index') }}" class="text-sm text-skin-text-muted hover:text-skin-text">Back to Distributions</a>
    </div>

    <div class="bg-skin-base border border-skin-border rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.distributions.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Offering -->
            <div>
                <label for="offering_id" class="block text-sm font-medium text-skin-text-muted">Offering</label>
                <select name="offering_id" id="offering_id" required
                    class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                    <option value="">Select Offering</option>
                    @foreach($offerings as $offering)
                        <option value="{{ $offering->id }}">{{ $offering->name }} ({{ $offering->status }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-skin-text-muted">Distribution Title</label>
                <input type="text" name="title" id="title" placeholder="e.g. Q1 2026 ROI" required
                    class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
            </div>

            <!-- Amount Per Unit -->
            <div>
                <label for="amount_per_unit" class="block text-sm font-medium text-skin-text-muted">Amount Per Unit (₦)</label>
                <input type="number" name="amount_per_unit" id="amount_per_unit" min="0" step="0.01" required
                    class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                <p class="mt-1 text-sm text-skin-text-muted">Each investor will receive this amount multiplied by their number of units.</p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                    Create Distribution
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
