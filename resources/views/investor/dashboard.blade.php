@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Top Row: Portfolio Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Commitments -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32 hover:border-umera-300 dark:hover:border-umera-700 transition-colors">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Total Invested</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                    <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div class="text-2xl font-semibold text-skin-text">₦ {{ number_format($my_allocations->sum('amount')) }}</div>
                <div class="text-xs font-medium text-skin-text-muted">Lifetime Volume</div>
            </div>
        </div>
        
        <!-- Active Investments -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32 hover:border-umera-300 dark:hover:border-umera-700 transition-colors">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Active Investments</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                     <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div class="text-2xl font-semibold text-skin-text">{{ $my_allocations->where('status', 'active')->count() }}</div>
                <div class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded-full">Active Count</div>
            </div>
        </div>

        <!-- ROI Rate -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32 hover:border-umera-300 dark:hover:border-umera-700 transition-colors">
             <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Portfolio ROI</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                     <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div class="text-2xl font-semibold text-skin-text">{{ isset($roi_rate) && $roi_rate > 0 ? number_format($roi_rate, 2) . '%' : 'N/A' }}</div>
                <div class="text-xs font-medium text-skin-text-muted">Avg. Return</div>
            </div>
        </div>

        <!-- Last Payment Date -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32 hover:border-umera-300 dark:hover:border-umera-700 transition-colors">
             <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-skin-text-muted">Last Payment</h3>
                <div class="p-2 bg-skin-base-ter rounded-full">
                     <svg class="w-4 h-4 text-skin-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div class="text-lg font-semibold text-skin-text">{{ isset($last_payment_date) ? \Carbon\Carbon::parse($last_payment_date)->format('M d, Y') : '--' }}</div>
                <div class="text-xs font-medium text-skin-text-muted">Latest Activity</div>
            </div>
        </div>
    </div>

    <!-- Middle Section: My Investments -->
    <div id="my-investments" class="bg-skin-base border border-skin-border rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-skin-border flex justify-between items-center bg-skin-base-ter/50">
            <h3 class="text-base font-medium text-skin-text">My Investments</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Offering</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Commitment</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Funded</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($my_allocations as $allocation)
                    <tr class="hover:bg-skin-base-ter transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 bg-skin-base-ter rounded-md flex items-center justify-center text-xs font-bold text-skin-text-muted">
                                    {{ substr($allocation->offering->name, 0, 2) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-skin-text">{{ $allocation->offering->name }}</div>
                                    <div class="text-xs text-skin-text-muted">{{ $allocation->offering->type ?? 'Investment' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-skin-text">
                            ₦ {{ number_format($allocation->amount) }}
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            {{ $allocation->units }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                            {{ $allocation->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $allocation->status === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 
                                   ($allocation->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300') }}">
                                {{ ucfirst($allocation->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-skin-text-muted">You have no active investments.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Section: Opportunities & Announcements -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Available Opportunities -->
        <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
            <h3 class="text-base font-medium text-skin-text mb-4">Available Opportunities</h3>
            <div class="space-y-4">
                @forelse($offerings as $offering)
                <a href="{{ route('investor.offerings.show', $offering) }}" class="block hover:bg-skin-base-ter -mx-2 p-2 rounded-md transition-colors group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0 bg-umera-100 dark:bg-umera-900/30 rounded-md flex items-center justify-center text-umera-600 dark:text-umera-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-skin-text group-hover:text-umera-700 dark:group-hover:text-umera-400">{{ $offering->name }}</p>
                                <p class="text-xs text-skin-text-muted">{{ $offering->type ?? 'Investment' }} • Min: ₦{{ number_format($offering->min_investment) }}</p>
                            </div>
                        </div>
                        <div class="text-xs font-medium text-umera-600 dark:text-umera-400 bg-umera-50 dark:bg-umera-900/20 px-2 py-1 rounded-full">
                            {{ ucfirst(str_replace('_', ' ', $offering->status)) }}
                        </div>
                    </div>
                </a>
                @empty
                <p class="text-sm text-skin-text-muted text-center py-4">No new opportunities available at the moment.</p>
                @endforelse
            </div>
        </div>
        
        <!-- Announcements -->
         <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
            <h3 class="text-base font-medium text-skin-text mb-4">Latest Announcements</h3>
             <div class="space-y-4">
                @forelse($announcements as $announcement)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <div class="h-2 w-2 rounded-full bg-umera-500"></div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-skin-text">{{ $announcement->title }}</h4>
                        <p class="mt-1 text-xs text-skin-text-muted line-clamp-2">{{ Str::limit($announcement->content ?? '', 100) }}</p>
                        <div class="mt-1 text-[10px] text-skin-text-muted">{{ $announcement->published_at ? $announcement->published_at->diffForHumans() : $announcement->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-skin-text-muted text-center py-4">No recent announcements.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
