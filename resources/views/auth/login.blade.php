<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Uméra') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white" x-data="{ showPassword: false, isLoading: false }">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Left Side - Sign In Form -->
        <div class="flex flex-col justify-center px-8 sm:px-12 lg:px-20 xl:px-32 py-12 bg-white relative">
            <!-- Back Button -->
            <a href="/"
               class="absolute top-8 left-8 flex items-center gap-2 text-neutral-600 hover:text-umera transition-colors group">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:-translate-x-1 transition-transform">
                    <path d="M19 12H5m7 7l-7-7 7-7"/>
                </svg>
                <span class="font-light">Back to home</span>
            </a>

            <!-- Logo -->
            <div class="mb-12">
                <img
                    src="https://umera.ng/wp-content/uploads/2020/11/umera-logo.png"
                    alt="Uméra Logo"
                    class="h-16 w-auto object-contain mb-4"
                />
            </div>

            <!-- Form Header -->
            <div class="mb-10">
                <h1 class="text-4xl lg:text-5xl mb-4 text-neutral-900 font-serif font-light">
                    Welcome Back
                </h1>
                <p class="text-neutral-600 text-lg font-light">
                    Access your investment portfolio
                </p>
                <div class="w-16 h-px bg-gradient-to-r from-umera to-transparent mt-4"></div>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5">
                        <circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <div>
                        <ul class="text-red-800 text-sm list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Sign In Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6" @submit="isLoading = true">
                @csrf

                <!-- Email Field -->
                <div class="group">
                    <label for="email" class="block mb-2 text-neutral-700 font-normal">
                        Email Address
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="investor@example.com"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-5 py-4 bg-neutral-50 border border-neutral-300 focus:border-umera focus:ring-0 focus:bg-white transition-all duration-300 outline-none text-neutral-900 font-light"
                    />
                </div>

                <!-- Password Field -->
                <div class="group">
                    <label for="password" class="block mb-2 text-neutral-700 font-normal">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                            class="w-full px-5 py-4 pr-12 bg-neutral-50 border border-neutral-300 focus:border-umera focus:ring-0 focus:bg-white transition-all duration-300 outline-none text-neutral-900 font-light"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-neutral-500 hover:text-umera transition-colors"
                        >
                            <template x-if="showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </template>
                            <template x-if="!showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center gap-2 cursor-pointer group">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 text-umera border-gray-300 rounded focus:ring-umera cursor-pointer"
                        />
                        <span class="text-neutral-600 text-sm group-hover:text-neutral-900 transition-colors font-light">
                            Remember me
                        </span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-umera hover:text-umera-600 transition-colors font-normal">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="isLoading"
                    class="w-full bg-gradient-to-r from-umera to-umera-600 text-white px-8 py-5 hover:shadow-2xl hover:shadow-umera/30 transition-all duration-500 flex items-center justify-center gap-3 group relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <template x-if="isLoading">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            <span class="tracking-wide font-medium">Signing in...</span>
                        </div>
                    </template>
                    <template x-if="!isLoading">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span class="tracking-wide font-medium">Access Dashboard</span>
                        </div>
                    </template>
                    <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </button>

                <!-- Security Badge -->
                <div class="pt-6 border-t border-neutral-200">
                    <div class="flex items-center gap-3 text-neutral-500 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gold">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span class="font-light">
                            Your connection is encrypted with 256-bit SSL
                        </span>
                    </div>
                </div>
            </form>

            <!-- Additional Info -->
            <div class="mt-12 pt-8 border-t border-neutral-200">
                <p class="text-neutral-600 text-sm mb-4 font-light">
                    Don't have access yet?
                </p>
                <a
                    href="#"
                    class="inline-flex items-center gap-2 text-umera hover:text-umera-600 transition-colors group font-normal"
                >
                    Contact your account manager
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>

            <!-- Footer Note -->
            <div class="mt-12 text-center">
                <p class="text-neutral-400 text-xs tracking-wider">
                    FOR VERIFIED INVESTORS ONLY
                </p>
            </div>
        </div>

        <!-- Right Side - Visual -->
        <div class="hidden lg:block relative bg-neutral-900 overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img
                    src="https://images.unsplash.com/photo-1736939675530-d50e0a11b6f6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBjb3Jwb3JhdGUlMjBidWlsZGluZ3xlbnwxfHx8fDE3Njc1NjAwNTB8MA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                    alt="Luxury building"
                    class="w-full h-full object-cover scale-110"
                />
                <div class="absolute inset-0 bg-gradient-to-br from-umera/90 via-neutral-900/80 to-black/90"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,transparent_0%,rgba(0,0,0,0.5)_100%)]"></div>
            </div>

            <!-- Content Overlay -->
            <div class="relative z-10 h-full flex flex-col justify-center px-12 xl:px-20">
                <div class="mb-8">
                    <div class="inline-block px-4 py-2 bg-white/10 border border-white/20 backdrop-blur-sm mb-6">
                        <span class="text-gold tracking-widest text-sm">SECURE ACCESS</span>
                    </div>
                </div>

                <h2 class="text-5xl xl:text-6xl mb-8 text-white leading-tight font-serif font-light">
                    Your Portfolio,<br />
                    <span class="italic font-normal">Always Accessible</span>
                </h2>

                <div class="w-24 h-px bg-gradient-to-r from-gold to-transparent mb-8"></div>

                <p class="text-white/80 text-xl mb-12 max-w-md leading-relaxed font-light">
                    Access real-time analytics, exclusive opportunities, and comprehensive reports from anywhere in the world.
                </p>

                <!-- Feature List -->
                <div class="space-y-6">
                    @foreach (['Real-time portfolio monitoring', 'Secure document access', 'Direct team communication', 'Exclusive investment insights'] as $feature)
                        <div class="flex items-center gap-4 group">
                            <div class="w-1.5 h-1.5 bg-gold group-hover:scale-150 transition-transform duration-300"></div>
                            <span class="text-white/90 group-hover:text-white transition-colors font-light">
                                {{ $feature }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 mt-16 pt-12 border-t border-white/10">
                    @foreach ([['value' => '256-bit', 'label' => 'Encryption'], ['value' => '24/7', 'label' => 'Access'], ['value' => '100%', 'label' => 'Secure']] as $stat)
                        <div>
                            <div class="text-3xl mb-2 text-gold font-serif">
                                {{ $stat['value'] }}
                            </div>
                            <div class="text-white/60 text-sm tracking-wider">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-20 right-20 w-64 h-64 border border-white/10 rotate-45"></div>
            <div class="absolute bottom-20 left-20 w-32 h-32 bg-gradient-to-br from-gold/20 to-transparent"></div>
        </div>
    </div>
</body>
</html>
