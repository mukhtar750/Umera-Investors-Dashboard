<header class="h-20 bg-skin-base border-b border-skin-border flex items-center justify-between px-6 lg:px-8 transition-colors duration-200">
    <div class="flex items-center gap-4">
        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-skin-text-muted hover:text-skin-text transition-colors">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <div>
            <h1 class="text-xl font-semibold text-skin-text tracking-tight">
                {{ $pageTitle ?? (is_array($header ?? null) ? 'Dashboard' : ($header ?? 'Dashboard')) }}
            </h1>
            @if(isset($breadcrumbs))
                <div class="text-sm text-skin-text-muted mt-0.5">{{ $breadcrumbs }}</div>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-6">
        <!-- Theme Toggle -->
        <button @click="toggleTheme()" class="text-skin-text-muted hover:text-skin-text transition-colors focus:outline-none">
            <svg x-show="!darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <svg x-show="darkMode" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </button>

        <!-- Notifications -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="relative text-skin-text-muted hover:text-skin-text transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-skin-base"></span>
                @endif
            </button>

            <div x-show="open" 
                 @click.away="open = false"
                 class="absolute right-0 mt-2 w-80 bg-skin-base rounded-xl shadow-lg border border-skin-border py-1 z-50"
                 style="display: none;">
                <div class="px-4 py-2 border-b border-skin-border flex justify-between items-center">
                    <span class="text-sm font-semibold text-skin-text">Notifications</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('notifications.read-all') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-umera-600 hover:text-umera-800">Mark all as read</button>
                        </form>
                    @endif
                </div>
                
                <div class="max-h-64 overflow-y-auto">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <div class="px-4 py-3 hover:bg-skin-base-ter border-b border-skin-border transition-colors">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex-1">
                                    <p class="text-sm text-skin-text">{{ $notification->data['message'] ?? 'New Notification' }}</p>
                                    <p class="text-xs text-skin-text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-skin-text-muted hover:text-skin-text">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center text-sm text-skin-text-muted">
                            No new notifications
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="h-8 w-px bg-skin-border"></div>

        <!-- User Dropdown -->
        <div class="flex items-center gap-3">
            <div class="text-right hidden md:block">
                <div class="text-sm font-medium text-skin-text">{{ Auth::user()->name }}</div>
                <div class="text-xs text-skin-text-muted capitalize">{{ Auth::user()->role ?? 'Investor' }}</div>
            </div>
            <div class="h-10 w-10 rounded-full bg-umera-100 flex items-center justify-center text-umera-700 font-bold border border-umera-200">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </div>
</header>
