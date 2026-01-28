@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-skin-text">Distributions</h1>
        <a href="{{ route('admin.distributions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
            Create Distribution
        </a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-fill">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Offering</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Amount Per Unit</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Total Distributed</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($distributions as $distribution)
                    <tr class="hover:bg-skin-fill transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-skin-text">{{ $distribution->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">{{ $distribution->offering->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-skin-text">₦{{ number_format($distribution->amount_per_unit, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($distribution->total_amount)
                            <div class="text-sm text-skin-text">₦{{ number_format($distribution->total_amount, 2) }}</div>
                            <div class="text-xs text-skin-text-muted">{{ $distribution->processed_at->format('M d, Y') }}</div>
                            @else
                            <span class="text-sm text-skin-text-muted">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $distribution->status === 'processed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }} capitalize">
                                {{ $distribution->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($distribution->status !== 'processed')
                            <form action="{{ route('admin.distributions.process', $distribution) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to process this distribution? This will credit all investor wallets immediately.');">
                                @csrf
                                <button type="submit" class="text-umera-600 hover:text-umera-900 dark:hover:text-umera-400">Process</button>
                            </form>
                            @else
                            <span class="text-skin-text-muted cursor-default">Processed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-skin-text-muted">
                            No distributions found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($distributions->hasPages())
        <div class="bg-skin-base px-4 py-3 border-t border-skin-border sm:px-6">
            {{ $distributions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
