<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Uméra') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white font-sans antialiased" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">
    
    <!-- Premium Navigation -->
    <nav 
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
        :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg py-4' : 'bg-transparent py-6'"
    >
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img
                    src="https://umera.ng/wp-content/uploads/2020/11/umera-logo.png"
                    alt="Uméra Logo"
                    class="h-12 w-auto object-contain"
                />
            </div>
            <a 
                href="{{ route('login') }}"
                class="px-8 py-3 transition-all duration-300 border rounded-none"
                :class="scrolled 
                    ? 'border-umera text-umera hover:bg-umera hover:text-white' 
                    : 'border-white text-white hover:bg-white hover:text-umera'"
            >
                Investor Login
            </a>
        </div>
    </nav>

    <!-- Hero Section - Premium -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img
                src="https://images.unsplash.com/photo-1568115286680-d203e08a8be6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjBwZW50aG91c2UlMjBza3lsaW5lfGVufDF8fHx8MTc2NzYyNTY0OHww&ixlib=rb-4.1.0&q=80&w=1080"
                alt="Luxury skyline"
                class="w-full h-full object-cover scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-black/70 to-umera/30"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,transparent_0%,rgba(137,7,6,0.3)_100%)]"></div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-1/4 right-10 w-64 h-64 border border-gold/20 rotate-45 opacity-30"></div>
        <div class="absolute bottom-1/4 left-10 w-48 h-48 border border-white/10 rotate-12"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-6 text-center">
            <div class="mb-8 inline-block">
                <div class="px-6 py-2 bg-gold/10 border border-gold/30 backdrop-blur-sm">
                    <span class="text-gold tracking-widest text-sm">PRIVATE INVESTMENT PORTAL</span>
                </div>
            </div>

            <h1 
                class="text-white mb-8 leading-tight tracking-tight font-serif font-light"
                style="font-size: clamp(3rem, 8vw, 7rem);"
            >
                Where Wealth<br />Meets <span class="italic font-normal">Transparency</span>
            </h1>

            <div class="w-24 h-px bg-gradient-to-r from-transparent via-gold to-transparent mx-auto mb-8"></div>

            <p class="text-white/90 mb-14 text-xl lg:text-2xl max-w-3xl mx-auto leading-relaxed font-light">
                Your exclusive gateway to real estate portfolio management, performance analytics, 
                and investment opportunities—crafted for discerning partners.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a 
                    href="{{ route('login') }}"
                    class="group bg-gradient-to-r from-umera to-red-900 text-white px-12 py-5 hover:shadow-2xl hover:shadow-umera/50 transition-all duration-500 flex items-center gap-3 relative overflow-hidden"
                >
                    <span class="relative z-10 tracking-wide">Access Dashboard</span>
                    <!-- ArrowRight Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 group-hover:translate-x-2 transition-transform duration-300 relative z-10"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </a>
                <button class="bg-transparent text-white px-12 py-5 border border-white/30 hover:border-gold hover:bg-white/5 backdrop-blur-sm transition-all duration-300">
                    <span class="tracking-wide">Request Access</span>
                </button>
            </div>

            <p class="text-white/40 mt-12 text-sm tracking-widest">
                FOR VERIFIED INVESTORS ONLY
            </p>
        </div>

        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 z-10 animate-bounce cursor-pointer">
            <!-- ChevronDown Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white/50"><path d="m6 9 6 6 6-6"/></svg>
        </div>
    </section>

    <!-- Stats Section - Premium Addition -->
    <section class="py-20 bg-neutral-900 border-y border-gold/20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="text-center group">
                    <div class="text-5xl lg:text-6xl mb-3 bg-gradient-to-br from-gold to-[#8d7555] bg-clip-text text-transparent font-serif font-light">
                        $2.4B
                    </div>
                    <div class="text-neutral-400 tracking-widest text-sm">Assets Under Management</div>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-gold/50 to-transparent mx-auto mt-4 group-hover:w-24 transition-all duration-500"></div>
                </div>
                <div class="text-center group">
                    <div class="text-5xl lg:text-6xl mb-3 bg-gradient-to-br from-gold to-[#8d7555] bg-clip-text text-transparent font-serif font-light">
                        500+
                    </div>
                    <div class="text-neutral-400 tracking-widest text-sm">Premium Properties</div>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-gold/50 to-transparent mx-auto mt-4 group-hover:w-24 transition-all duration-500"></div>
                </div>
                <div class="text-center group">
                    <div class="text-5xl lg:text-6xl mb-3 bg-gradient-to-br from-gold to-[#8d7555] bg-clip-text text-transparent font-serif font-light">
                        15+
                    </div>
                    <div class="text-neutral-400 tracking-widest text-sm">Years of Excellence</div>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-gold/50 to-transparent mx-auto mt-4 group-hover:w-24 transition-all duration-500"></div>
                </div>
                <div class="text-center group">
                    <div class="text-5xl lg:text-6xl mb-3 bg-gradient-to-br from-gold to-[#8d7555] bg-clip-text text-transparent font-serif font-light">
                        98%
                    </div>
                    <div class="text-neutral-400 tracking-widest text-sm">Investor Satisfaction</div>
                    <div class="w-12 h-px bg-gradient-to-r from-transparent via-gold/50 to-transparent mx-auto mt-4 group-hover:w-24 transition-all duration-500"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Indicators - Enhanced -->
    <section class="py-28 bg-white relative">
        <div class="absolute top-0 left-1/2 w-px h-full bg-gradient-to-b from-transparent via-neutral-200 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-5xl lg:text-6xl mb-4 text-neutral-900 font-serif font-light">
                    Built on <span class="italic">Trust</span>
                </h2>
                <div class="w-24 h-px bg-gradient-to-r from-transparent via-umera to-transparent mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-16 lg:gap-20">
                <!-- Secure -->
                <div class="text-center group relative">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-umera to-red-900 mb-8 relative group-hover:scale-110 transition-transform duration-500">
                        <!-- Shield Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-white"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                        <div class="absolute -inset-2 border border-umera/20 group-hover:border-gold/40 transition-colors duration-500"></div>
                    </div>
                    <h3 class="mb-4 text-neutral-900 text-3xl font-serif font-normal">
                        Secure
                    </h3>
                    <p class="text-neutral-600 leading-relaxed text-lg font-light">
                        Bank-grade encryption and multi-factor authentication protecting every transaction and interaction.
                    </p>
                </div>

                <!-- Transparent -->
                <div class="text-center group relative">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-umera to-red-900 mb-8 relative group-hover:scale-110 transition-transform duration-500">
                        <!-- Eye Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-white"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <div class="absolute -inset-2 border border-umera/20 group-hover:border-gold/40 transition-colors duration-500"></div>
                    </div>
                    <h3 class="mb-4 text-neutral-900 text-3xl font-serif font-normal">
                        Transparent
                    </h3>
                    <p class="text-neutral-600 leading-relaxed text-lg font-light">
                        Real-time access to complete portfolio data, performance metrics, and comprehensive reporting.
                    </p>
                </div>

                <!-- Exclusive -->
                <div class="text-center group relative">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-umera to-red-900 mb-8 relative group-hover:scale-110 transition-transform duration-500">
                        <!-- TrendingUp Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-white"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                        <div class="absolute -inset-2 border border-umera/20 group-hover:border-gold/40 transition-colors duration-500"></div>
                    </div>
                    <h3 class="mb-4 text-neutral-900 text-3xl font-serif font-normal">
                        Exclusive
                    </h3>
                    <p class="text-neutral-600 leading-relaxed text-lg font-light">
                        Purpose-built for high-net-worth individuals with dedicated support and premium features.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features - Premium Grid -->
    <section class="py-28 bg-neutral-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gold/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-umera/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-5xl lg:text-6xl mb-6 text-neutral-900 font-serif font-light">
                    Your Investment <span class="italic">Command Center</span>
                </h2>
                <p class="text-neutral-600 text-xl max-w-3xl mx-auto font-light">
                    Every tool you need to monitor, manage, and maximize your real estate portfolio.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Portfolio Analytics -->
                <div class="group bg-white p-10 hover:shadow-2xl transition-all duration-500 border border-neutral-200 hover:border-umera/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-umera/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-full"></div>
                    
                    <div class="w-16 h-16 bg-neutral-50 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center mb-8 transition-all duration-500 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-umera group-hover:text-white transition-colors duration-500"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    </div>
                    
                    <h3 class="mb-4 text-neutral-900 text-2xl relative z-10 font-serif font-normal">
                        Portfolio Analytics
                    </h3>
                    
                    <p class="text-neutral-600 leading-relaxed relative z-10 font-light">
                        Comprehensive dashboards with real-time performance tracking, asset allocation insights, and predictive analytics powered by market intelligence.
                    </p>
                </div>

                <!-- Exclusive Opportunities -->
                <div class="group bg-white p-10 hover:shadow-2xl transition-all duration-500 border border-neutral-200 hover:border-umera/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-umera/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-full"></div>
                    
                    <div class="w-16 h-16 bg-neutral-50 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center mb-8 transition-all duration-500 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-umera group-hover:text-white transition-colors duration-500"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    
                    <h3 class="mb-4 text-neutral-900 text-2xl relative z-10 font-serif font-normal">
                        Exclusive Opportunities
                    </h3>
                    
                    <p class="text-neutral-600 leading-relaxed relative z-10 font-light">
                        First access to pre-market listings, off-market deals, and carefully vetted investment opportunities with detailed prospectus documentation.
                    </p>
                </div>

                <!-- Document Vault -->
                <div class="group bg-white p-10 hover:shadow-2xl transition-all duration-500 border border-neutral-200 hover:border-umera/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-umera/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-full"></div>
                    
                    <div class="w-16 h-16 bg-neutral-50 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center mb-8 transition-all duration-500 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-umera group-hover:text-white transition-colors duration-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                    </div>
                    
                    <h3 class="mb-4 text-neutral-900 text-2xl relative z-10 font-serif font-normal">
                        Document Vault
                    </h3>
                    
                    <p class="text-neutral-600 leading-relaxed relative z-10 font-light">
                        Secure, encrypted repository for all contracts, reports, tax documents, and legal agreements—accessible anytime, anywhere.
                    </p>
                </div>

                <!-- Private Messaging -->
                <div class="group bg-white p-10 hover:shadow-2xl transition-all duration-500 border border-neutral-200 hover:border-umera/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-umera/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-full"></div>
                    
                    <div class="w-16 h-16 bg-neutral-50 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center mb-8 transition-all duration-500 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-umera group-hover:text-white transition-colors duration-500"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                    </div>
                    
                    <h3 class="mb-4 text-neutral-900 text-2xl relative z-10 font-serif font-normal">
                        Private Messaging
                    </h3>
                    
                    <p class="text-neutral-600 leading-relaxed relative z-10 font-light">
                        End-to-end encrypted communication with your dedicated account manager and our executive investment team.
                    </p>
                </div>

                <!-- Performance Reports -->
                <div class="group bg-white p-10 hover:shadow-2xl transition-all duration-500 border border-neutral-200 hover:border-umera/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-umera/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-full"></div>
                    
                    <div class="w-16 h-16 bg-neutral-50 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center mb-8 transition-all duration-500 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-umera group-hover:text-white transition-colors duration-500"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    
                    <h3 class="mb-4 text-neutral-900 text-2xl relative z-10 font-serif font-normal">
                        Performance Reports
                    </h3>
                    
                    <p class="text-neutral-600 leading-relaxed relative z-10 font-light">
                        Quarterly earnings statements, ROI calculations, cash flow projections, and comparative market analysis delivered on schedule.
                    </p>
                </div>

                <!-- Market Intelligence -->
                <div class="group bg-white p-10 hover:shadow-2xl transition-all duration-500 border border-neutral-200 hover:border-umera/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-umera/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-full"></div>
                    
                    <div class="w-16 h-16 bg-neutral-50 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center mb-8 transition-all duration-500 relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-umera group-hover:text-white transition-colors duration-500"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    </div>
                    
                    <h3 class="mb-4 text-neutral-900 text-2xl relative z-10 font-serif font-normal">
                        Market Intelligence
                    </h3>
                    
                    <p class="text-neutral-600 leading-relaxed relative z-10 font-light">
                        Proprietary research, trend analysis, and market forecasts from our in-house team of real estate experts and economists.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works - Elegant Timeline -->
    <section class="py-28 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-5xl lg:text-6xl mb-6 text-neutral-900 font-serif font-light">
                    Your Journey <span class="italic">Begins Here</span>
                </h2>
                <div class="w-24 h-px bg-gradient-to-r from-transparent via-umera to-transparent mx-auto"></div>
            </div>

            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-gold via-umera to-gold hidden lg:block"></div>

                <div class="space-y-24">
                    <!-- Step 1 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 lg:flex-row-reverse">
                        <div class="flex-1 text-center lg:text-left">
                            <div class="text-8xl mb-4 bg-gradient-to-br from-gold to-[#8d7555] bg-clip-text text-transparent opacity-50 font-serif font-light">
                                01
                            </div>
                            <h3 class="text-3xl mb-4 text-neutral-900 font-serif font-normal">
                                Investor Verification
                            </h3>
                            <p class="text-neutral-600 leading-relaxed text-lg max-w-md font-light lg:mr-auto">
                                Our team conducts a thorough verification process and creates your personalized account with role-specific permissions tailored to your investment portfolio.
                            </p>
                        </div>

                        <div class="relative flex-shrink-0">
                            <div class="w-6 h-6 bg-gradient-to-br from-umera to-red-900 rounded-full border-4 border-white shadow-xl"></div>
                            <div class="absolute inset-0 w-6 h-6 bg-umera rounded-full animate-ping opacity-20"></div>
                        </div>

                        <div class="flex-1"></div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8">
                        <div class="flex-1 text-center lg:text-right">
                            <div class="text-8xl mb-4 bg-gradient-to-br from-gold to-[#8d7555] bg-clip-text text-transparent opacity-50 font-serif font-light">
                                02
                            </div>
                            <h3 class="text-3xl mb-4 text-neutral-900 font-serif font-normal">
                                Secure Access
                            </h3>
                            <p class="text-neutral-600 leading-relaxed text-lg max-w-md font-light lg:ml-auto">
                                Receive your credentials and access the platform using enterprise-grade multi-factor authentication designed specifically for high-value accounts.
                            </p>
                        </div>

                        <div class="relative flex-shrink-0">
                            <div class="w-6 h-6 bg-gradient-to-br from-umera to-red-900 rounded-full border-4 border-white shadow-xl"></div>
                            <div class="absolute inset-0 w-6 h-6 bg-umera rounded-full animate-ping opacity-20"></div>
                        </div>

                        <div class="flex-1"></div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 lg:flex-row-reverse">
                        <div class="flex-1 text-center lg:text-left">
                            <div class="text-8xl mb-4 bg-gradient-to-br from-gold to-[#8d7555] bg-clip-text text-transparent opacity-50 font-serif font-light">
                                03
                            </div>
                            <h3 class="text-3xl mb-4 text-neutral-900 font-serif font-normal">
                                Portfolio Command
                            </h3>
                            <p class="text-neutral-600 leading-relaxed text-lg max-w-md font-light lg:mr-auto">
                                Monitor investments in real-time, access exclusive opportunities, review detailed reports, and communicate directly with our executive team.
                            </p>
                        </div>

                        <div class="relative flex-shrink-0">
                            <div class="w-6 h-6 bg-gradient-to-br from-umera to-red-900 rounded-full border-4 border-white shadow-xl"></div>
                            <div class="absolute inset-0 w-6 h-6 bg-umera rounded-full animate-ping opacity-20"></div>
                        </div>

                        <div class="flex-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Security - Luxury Split -->
    <section class="py-28 bg-neutral-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-bl from-gold to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-5xl lg:text-6xl mb-8 text-white font-serif font-light">
                        Fortress-Grade <span class="italic">Security</span>
                    </h2>
                    
                    <div class="w-24 h-px bg-gradient-to-r from-gold to-transparent mb-12"></div>

                    <p class="text-neutral-300 text-xl mb-12 leading-relaxed font-light">
                        Your investment data deserves military-grade protection. Our infrastructure implements the highest security standards in the financial industry.
                    </p>

                    <div class="space-y-8">
                        <div class="flex gap-6 group">
                            <div class="flex-shrink-0 w-14 h-14 bg-neutral-800 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center transition-all duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-gold group-hover:text-white transition-colors duration-500"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </div>
                            <div>
                                <h4 class="mb-2 text-white text-xl font-serif font-normal">
                                    256-Bit Encryption
                                </h4>
                                <p class="text-neutral-400 leading-relaxed font-light">
                                    All data encrypted in transit and at rest using AES-256, the same standard used by global financial institutions.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-6 group">
                            <div class="flex-shrink-0 w-14 h-14 bg-neutral-800 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center transition-all duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-gold group-hover:text-white transition-colors duration-500"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                            </div>
                            <div>
                                <h4 class="mb-2 text-white text-xl font-serif font-normal">
                                    Zero-Trust Architecture
                                </h4>
                                <p class="text-neutral-400 leading-relaxed font-light">
                                    Role-based permissions ensure each investor accesses only their portfolio data with multi-layered verification.
                                </p>
                            </div>
                        </div>
                        
                         <div class="flex gap-6 group">
                            <div class="flex-shrink-0 w-14 h-14 bg-neutral-800 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center transition-all duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-gold group-hover:text-white transition-colors duration-500"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </div>
                            <div>
                                <h4 class="mb-2 text-white text-xl font-serif font-normal">
                                    Complete Audit Trails
                                </h4>
                                <p class="text-neutral-400 leading-relaxed font-light">
                                    Every action logged and monitored with real-time threat detection and automated response systems.
                                </p>
                            </div>
                        </div>
                        
                         <div class="flex gap-6 group">
                            <div class="flex-shrink-0 w-14 h-14 bg-neutral-800 group-hover:bg-gradient-to-br group-hover:from-umera group-hover:to-red-900 flex items-center justify-center transition-all duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-gold group-hover:text-white transition-colors duration-500"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                            </div>
                            <div>
                                <h4 class="mb-2 text-white text-xl font-serif font-normal">
                                    Privacy Guarantee
                                </h4>
                                <p class="text-neutral-400 leading-relaxed font-light">
                                    Your data never leaves our secure servers and is protected under strict confidentiality agreements.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="aspect-[3/4] overflow-hidden shadow-2xl relative">
                        <img
                            src="https://images.unsplash.com/photo-1765371513492-264506c3ad09?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxleGVjdXRpdmUlMjBvZmZpY2UlMjBpbnRlcmlvcnxlbnwxfHx8fDE3Njc2MjI4Njl8MA&ixlib=rb-4.1.0&q=80&w=1080"
                            alt="Executive office"
                            class="w-full h-full object-cover"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-transparent to-transparent"></div>
                    </div>
                    <div class="absolute -bottom-8 -right-8 w-64 h-64 border border-gold/20"></div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>