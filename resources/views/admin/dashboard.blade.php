@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Dashboard Overview</h1>
            <p class="text-sm text-skin-text-muted mt-1">Welcome back, Admin. Here's what's happening today.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
             <a href="{{ route('admin.offerings.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Create Offering
            </a>
        </div>
    </div>

    <!-- Top Row: Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Investors -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32 relative overflow-hidden group hover:border-umera-300 dark:hover:border-umera-700 transition-colors">
            <div class="flex items-center justify-between relative z-10">
                <h3 class="text-sm font-medium text-skin-text-muted">Total Investors</h3>
                <div class="p-2 bg-skin-base-ter rounded-full group-hover:bg-umera-50 dark:group-hover:bg-umera-900/20 transition-colors">
                    <svg class="w-4 h-4 text-skin-text-muted group-hover:text-umera-600 dark:group-hover:text-umera-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between relative z-10">
                <div class="text-3xl font-bold text-skin-text">{{ $stats['total_investors'] }}</div>
            </div>
            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-skin-base-ter rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        </div>
        
        <!-- Total Offerings -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32 relative overflow-hidden group hover:border-umera-300 dark:hover:border-umera-700 transition-colors">
            <div class="flex items-center justify-between relative z-10">
                <h3 class="text-sm font-medium text-skin-text-muted">Total Offerings</h3>
                <div class="p-2 bg-skin-base-ter rounded-full group-hover:bg-umera-50 dark:group-hover:bg-umera-900/20 transition-colors">
                     <svg class="w-4 h-4 text-skin-text-muted group-hover:text-umera-600 dark:group-hover:text-umera-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between relative z-10">
                <div class="text-3xl font-bold text-skin-text">{{ $stats['total_offerings'] }}</div>
            </div>
             <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-skin-base-ter rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        </div>

        <!-- Pending Allocations -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm flex flex-col justify-between h-32 relative overflow-hidden group hover:border-umera-300 dark:hover:border-umera-700 transition-colors">
             <div class="flex items-center justify-between relative z-10">
                <h3 class="text-sm font-medium text-skin-text-muted">Pending Allocations</h3>
                <div class="p-2 bg-skin-base-ter rounded-full group-hover:bg-umera-50 dark:group-hover:bg-umera-900/20 transition-colors">
                     <svg class="w-4 h-4 text-skin-text-muted group-hover:text-umera-600 dark:group-hover:text-umera-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end justify-between relative z-10">
                <div class="text-3xl font-bold text-skin-text">{{ $stats['pending_allocations'] }}</div>
                @if($stats['pending_allocations'] > 0)
                <div class="text-xs font-medium text-umera-600 dark:text-umera-400 bg-umera-50 dark:bg-umera-900/20 px-2 py-1 rounded-full animate-pulse">Action Req.</div>
                @endif
            </div>
             <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-skin-base-ter rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        </div>
    </div>

    <!-- Analytics Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Monthly Signups Chart -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm">
            <h3 class="text-base font-medium text-skin-text mb-4">Investor Growth</h3>
            <div class="relative h-64 w-full">
                <canvas id="signupsChart"></canvas>
            </div>
        </div>

        <!-- Allocation Status Chart -->
        <div class="bg-skin-base p-6 rounded-xl border border-skin-border shadow-sm">
            <h3 class="text-base font-medium text-skin-text mb-4">Investment Distribution</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (Content) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Recent Signups -->
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-skin-border flex justify-between items-center bg-skin-base-ter/50">
                    <h3 class="text-base font-medium text-skin-text">Recent Investor Signups</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-umera-600 dark:text-umera-400 hover:text-umera-700 dark:hover:text-umera-300 font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-skin-border">
                        <thead class="bg-skin-base-ter">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Investor</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-skin-base divide-y divide-skin-border">
                            @forelse($recent_signups as $user)
                            <tr class="hover:bg-skin-base-ter transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-umera-100 dark:bg-umera-900/30 flex items-center justify-center text-xs font-bold text-umera-700 dark:text-umera-300">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-skin-text">{{ $user->name }}</div>
                                            <div class="text-xs text-skin-text-muted">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->email_verified_at)
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800">Verified</span>
                                    @else
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-skin-text-muted hover:text-umera-600 dark:hover:text-umera-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-skin-text-muted">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-skin-border mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        No recent signups found.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Offerings -->
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-skin-border flex justify-between items-center bg-skin-base-ter/50">
                    <h3 class="text-base font-medium text-skin-text">Active Offerings</h3>
                    <a href="{{ route('admin.offerings.index') }}" class="text-sm text-umera-600 dark:text-umera-400 hover:text-umera-700 dark:hover:text-umera-300 font-medium">Manage All</a>
                </div>
                 <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-skin-border">
                        <thead class="bg-skin-base-ter">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Target</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-skin-base divide-y divide-skin-border">
                            @forelse($offerings as $offering)
                            <tr class="hover:bg-skin-base-ter transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-skin-text">
                                    {{ $offering->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                                    {{ $offering->type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">
                                    ₦{{ number_format($offering->target_amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $offering->status === 'open' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' :
                                           ($offering->status === 'coming_soon' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300') }}">
                                        {{ ucfirst(str_replace('_', ' ', $offering->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-skin-text-muted">
                                     <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-skin-border mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                        No offerings created yet.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column (Sidebar Widgets) -->
        <div class="space-y-8">
            
            <!-- Quick Actions -->
            <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm p-6">
                <h3 class="text-base font-medium text-skin-text mb-4">Quick Actions</h3>
                <div class="space-y-3">
                     <button class="w-full flex items-center justify-between p-3 border border-skin-border rounded-md hover:bg-skin-base-ter hover:border-umera-200 dark:hover:border-umera-700 transition-all group">
                        <span class="text-sm font-medium text-skin-text-muted group-hover:text-umera-700 dark:group-hover:text-umera-400">Invite Investor</span>
                        <svg class="w-5 h-5 text-skin-text-muted group-hover:text-umera-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    </button>
                     <a href="{{ route('admin.documents.index') }}" class="w-full flex items-center justify-between p-3 border border-skin-border rounded-md hover:bg-skin-base-ter hover:border-umera-200 dark:hover:border-umera-700 transition-all group">
                        <span class="text-sm font-medium text-skin-text-muted group-hover:text-umera-700 dark:group-hover:text-umera-400">Manage Documents</span>
                        <svg class="w-5 h-5 text-skin-text-muted group-hover:text-umera-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </a>
                     <a href="{{ route('admin.announcements.index') }}" class="w-full flex items-center justify-between p-3 border border-skin-border rounded-md hover:bg-skin-base-ter hover:border-umera-200 dark:hover:border-umera-700 transition-all group">
                        <span class="text-sm font-medium text-skin-text-muted group-hover:text-umera-700 dark:group-hover:text-umera-400">Post Announcement</span>
                        <svg class="w-5 h-5 text-skin-text-muted group-hover:text-umera-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                    </a>
                </div>
            </div>

             <!-- System Status -->
             <div class="bg-neutral-900 dark:bg-black rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-neutral-200">System Health</h3>
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-neutral-400">Server Status</span>
                        <span class="text-green-400 font-medium">Online</span>
                    </div>
                     <div class="flex justify-between items-center text-sm">
                        <span class="text-neutral-400">Last Backup</span>
                        <span class="text-neutral-200">2 hours ago</span>
                    </div>
                     <div class="flex justify-between items-center text-sm">
                        <span class="text-neutral-400">Database</span>
                        <span class="text-green-400 font-medium">Healthy</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const getThemeColors = () => {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                text: isDark ? '#9CA3AF' : '#6B7280', // gray-400 : gray-500
                grid: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                primary: '#C5A065', // umera-600
                primaryBg: 'rgba(197, 160, 101, 0.1)',
                success: '#10B981',
                warning: '#F59E0B',
                danger: '#EF4444',
                info: '#3B82F6'
            };
        };

        let colors = getThemeColors();
        let signupsChart = null;
        let statusChart = null;

        const initCharts = () => {
            // Destroy existing charts if any
            if (signupsChart) signupsChart.destroy();
            if (statusChart) statusChart.destroy();

            colors = getThemeColors();

            // Signups Chart
            const signupsCtx = document.getElementById('signupsChart').getContext('2d');
            
            // Create gradient
            let gradient = signupsCtx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(197, 160, 101, 0.5)');   
            gradient.addColorStop(1, 'rgba(197, 160, 101, 0.0)');

            signupsChart = new Chart(signupsCtx, {
                type: 'line',
                data: {
                    labels: @json($chart_data['labels']),
                    datasets: [{
                        label: 'New Investors',
                        data: @json($chart_data['data']),
                        borderColor: colors.primary,
                        backgroundColor: gradient,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: colors.primary,
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: colors.primary
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                            titleColor: document.documentElement.classList.contains('dark') ? '#F3F4F6' : '#111827',
                            bodyColor: document.documentElement.classList.contains('dark') ? '#D1D5DB' : '#4B5563',
                            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' New Investors';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: colors.grid,
                                drawBorder: false
                            },
                            ticks: {
                                color: colors.text,
                                padding: 10,
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: colors.text,
                                padding: 10
                            }
                        }
                    }
                }
            });

            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($status_data['labels']),
                    datasets: [{
                        data: @json($status_data['data']),
                        backgroundColor: [
                            colors.primary,
                            colors.success,
                            colors.danger,
                            colors.text
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: colors.text,
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: document.documentElement.classList.contains('dark') ? '#1F2937' : '#FFFFFF',
                            titleColor: document.documentElement.classList.contains('dark') ? '#F3F4F6' : '#111827',
                            bodyColor: document.documentElement.classList.contains('dark') ? '#D1D5DB' : '#4B5563',
                            borderColor: document.documentElement.classList.contains('dark') ? '#374151' : '#E5E7EB',
                            borderWidth: 1,
                            padding: 10
                        }
                    },
                    cutout: '70%'
                }
            });
        };

        // Initialize charts
        if (typeof Chart !== 'undefined') {
            initCharts();
        } else {
            console.error('Chart.js is not loaded');
        }

        // Listen for theme changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    initCharts();
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true
        });
    });
</script>
@endpush
