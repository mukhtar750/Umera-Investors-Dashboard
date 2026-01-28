<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Uméra Investors') }}</title>

        <link rel="icon" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|cormorant-garamond:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-skin-base-sec text-skin-text transition-colors duration-200"
          x-data="{ 
              sidebarOpen: false,
              darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
              toggleTheme() {
                  this.darkMode = !this.darkMode;
                  if (this.darkMode) {
                      document.documentElement.classList.add('dark');
                      localStorage.setItem('theme', 'dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                      localStorage.setItem('theme', 'light');
                  }
              }
          }"
    >
        <div class="min-h-screen flex bg-skin-base-sec">
            
            <!-- Mobile Sidebar Overlay -->
            <div 
                x-show="sidebarOpen" 
                @click="sidebarOpen = false"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-neutral-900/80 z-40 lg:hidden"
            ></div>

            <!-- Sidebar -->
            <div 
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 w-64 lg:static lg:translate-x-0 transition-transform duration-300 ease-in-out"
            >
                @include('layouts.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                @include('layouts.topbar')

                <main class="flex-1 overflow-y-auto p-6 lg:p-8"
                      x-data="{ show: false }"
                      x-init="setTimeout(() => show = true, 50)"
                      x-show="show"
                      x-transition:enter="transition ease-out duration-300"
                      x-transition:enter-start="opacity-0 translate-y-4"
                      x-transition:enter-end="opacity-100 translate-y-0">
                    
                    @if (session('warning'))
                        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        {{ session('warning') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-md shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>