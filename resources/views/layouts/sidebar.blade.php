<aside class="h-full w-full bg-skin-base border-r border-skin-border flex flex-col transition-colors duration-200">
    <!-- Logo Area -->
    <div class="flex items-center justify-center h-20 border-b border-skin-border">
        <img src="https://umera.ng/wp-content/uploads/2020/11/umera-logo.png" alt="Uméra" class="h-10 w-auto">
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">
        
        @if(auth()->user()->role === 'admin')
            <!-- ADMIN NAVIGATION -->
            
            <!-- Section: Overview -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Overview</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Section: Investors -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Investors</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.users.index') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.users.index') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        All Investors
                    </a>
                    <a href="{{ route('admin.investors.import') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.investors.import') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.investors.import') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Import Investors
                    </a>
                    <a href="{{ route('admin.imports.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.imports.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.imports.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Import History
                    </a>
                </div>
            </div>

            <!-- Section: Investments -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Investments</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.offerings.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.offerings.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.offerings.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Offerings
                    </a>
                    <a href="{{ route('admin.allocations.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.allocations.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.allocations.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Allocations
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.transactions.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Transactions
                    </a>
                </div>
            </div>

            <!-- Section: Documents & Comms -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Documents & Comms</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.documents.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.documents.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.documents.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Documents
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.announcements.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.announcements.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Announcements
                    </a>
                    <a href="{{ route('chat.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('chat.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('chat.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Messages
                    </a>
                </div>
            </div>

            <!-- Section: Marketing -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Marketing</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.audiences.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.audiences.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.audiences.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Audiences
                    </a>
                    <a href="{{ route('admin.campaigns.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.campaigns.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.campaigns.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Campaigns
                    </a>
                </div>
            </div>

            <!-- Section: System -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">System</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.reports.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.reports.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Reports
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.settings.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                </div>
            </div>

        @elseif(auth()->user()->role === 'legal')
            <!-- LEGAL NAVIGATION -->
            <!-- Section: Overview -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Overview</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('legal.dashboard') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('legal.dashboard') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('legal.dashboard') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
            <!-- Section: Compliance -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Compliance</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('legal.documents.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('legal.documents.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('legal.documents.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Documents
                    </a>
                    <a href="{{ route('legal.investors.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('legal.investors.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('legal.investors.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Investors
                    </a>
                    <a href="{{ route('legal.audit-logs.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('legal.audit-logs.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('legal.audit-logs.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Audit Logs
                    </a>
                </div>
            </div>

        @elseif(auth()->user()->role === 'finance')
            <!-- FINANCE NAVIGATION -->
            <!-- Section: Overview -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Overview</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('finance.dashboard') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('finance.dashboard') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('finance.dashboard') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Section: Payouts -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Payouts</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('finance.roi.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('finance.roi.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('finance.roi.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ROI Payments
                    </a>
                    <a href="{{ route('finance.transactions.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('finance.transactions.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('finance.transactions.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Transactions
                    </a>
                    <a href="{{ route('chat.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('chat.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('chat.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Messages
                    </a>
                </div>
            </div>

        @else
            <!-- INVESTOR NAVIGATION -->
            
            <!-- Section: Overview -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Overview</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('investor.dashboard') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('investor.dashboard') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('investor.dashboard') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Section: Portfolio -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Portfolio</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('investor.investments.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('investor.investments.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('investor.investments.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        My Investments
                    </a>
                    <a href="{{ route('investor.transactions.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('investor.transactions.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('investor.transactions.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Transactions
                    </a>
                </div>
            </div>

            <!-- Section: Resources -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Resources</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('investor.documents.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('investor.documents.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('investor.documents.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Documents
                    </a>
                    <a href="{{ route('investor.announcements.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('investor.announcements.*') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('investor.announcements.*') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Announcements
                    </a>
                </div>
            </div>

            <!-- Section: Account -->
            <div>
                <h3 class="px-3 text-xs font-semibold text-skin-text-muted uppercase tracking-wider">Account</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-colors duration-200 {{ request()->routeIs('profile.edit') ? 'bg-umera-50 dark:bg-umera-900/20 text-umera-800 dark:text-umera-300' : 'text-skin-text-muted hover:bg-skin-base-ter hover:text-skin-text' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('profile.edit') ? 'text-umera-600 dark:text-umera-400' : 'text-skin-text-muted group-hover:text-skin-text' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                </div>
            </div>

        @endif
    </nav>

    <!-- User Profile Strip (Bottom) -->
    <div class="border-t border-skin-border p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-umera-100 dark:bg-umera-900/30 flex items-center justify-center text-umera-600 dark:text-umera-400 font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-skin-text">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-skin-text-muted hover:text-skin-text">Sign out</button>
                </form>
            </div>
        </div>
    </div>
</aside>
