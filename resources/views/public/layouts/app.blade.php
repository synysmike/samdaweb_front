<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="min-h-screen bg-white overflow-x-hidden flex flex-col">

    <!-- Header -->
    <header class="shadow-md theme-navbar" x-data="{ open: false, userDropdownOpen: false }" style="background-color: #8b5cf6;">
        @php
            // Force session to start and read
            if (!session()->isStarted()) {
                session()->start();
            }
            
            // Check session with more explicit check
            $sanctumToken = session('sanctum_token', null);
            $isLoggedIn = !empty($sanctumToken);
            
            $userData = session('user_data', null);
            $userName = $userData['name'] ?? 'User';
            $userEmail = $userData['email'] ?? '';
            $userImage = $userData['profile_picture'] ?? $userData['image'] ?? $userData['avatar'] ?? null;
        @endphp
        
        <div class="container mx-auto flex justify-between items-center py-4 px-6 gap-4">
            <!-- Logo and Search -->
            <div class="flex items-center gap-4 flex-1 md:flex-initial">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold whitespace-nowrap" id="app-logo" style="color: #3b82f6;">MyShop</a>

                <!-- Search Field -->
                <form action="/products" method="GET" class="hidden md:flex flex-1 max-w-md">
                    <div class="relative w-full">
                        <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}"
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--primary-color)] focus:border-transparent">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:[style-color:var(--primary-color)]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            @if($isLoggedIn)
                <!-- Desktop Nav - Logged In -->
                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="hover:[style-color:var(--primary-color)]">Home</a>
                    <a href="/products" class="hover:[style-color:var(--primary-color)]">Products</a>
                    <a href="/cart" class="hover:[style-color:var(--primary-color)]">🛒 Cart</a>
                </nav>

                <!-- User Dropdown - Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden border-2 [border-color:var(--primary-color)]">
                                @if($userImage)
                                    <img src="{{ $userImage }}" alt="{{ $userName }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[var(--primary-color)] to-[var(--secondary-color)] text-white font-semibold">
                                        {{ strtoupper(substr($userName, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-900">{{ $userName }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $userEmail }}</p>
                            </div>
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="/orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                            <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Desktop Nav - Not Logged In -->
                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="hover:[style-color:var(--primary-color)]">Home</a>
                    <a href="/products" class="hover:[style-color:var(--primary-color)]">Products</a>
                </nav>

                <!-- Login/Register Buttons - Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:[style-color:var(--primary-color)] font-medium">Login</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 text-white rounded-lg transition-colors font-medium theme-primary-btn">Register</a>
                </div>
            @endif

            <!-- Mobile Hamburger -->
            <button @click="open = !open" class="md:hidden text-2xl focus:outline-none">
                ☰
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-cloak class="md:hidden bg-gray-100 border-t">
            <div class="p-4">
                <!-- Mobile Search -->
                <form action="/products" method="GET" class="mb-4">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}"
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[color:var(--primary-color)] focus:border-transparent">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:[style-color:var(--primary-color)]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
                
                @if($isLoggedIn)
                    <!-- Mobile Menu - Logged In -->
                    <div class="flex flex-col items-center space-y-4">
                        <!-- User Info -->
                        <div class="flex items-center space-x-3 w-full justify-center pb-4 border-b border-gray-300">
                            <div class="w-12 h-12 rounded-full bg-gray-300 overflow-hidden border-2 [border-color:var(--primary-color)]">
                                @if($userImage)
                                    <img src="{{ $userImage }}" alt="{{ $userName }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[var(--primary-color)] to-[var(--secondary-color)] text-white font-semibold text-lg">
                                        {{ strtoupper(substr($userName, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-900">{{ $userName }}</p>
                                <p class="text-xs text-gray-500">{{ $userEmail }}</p>
                            </div>
                        </div>
                        
                        <nav class="flex flex-col items-center space-y-2 w-full">
                            <a href="/" class="w-full text-center py-2 hover:[style-color:var(--primary-color)]">Home</a>
                            <a href="/products" class="w-full text-center py-2 hover:[style-color:var(--primary-color)]">Products</a>
                            <a href="/cart" class="w-full text-center py-2 hover:[style-color:var(--primary-color)]">🛒 Cart</a>
                            <a href="/profile" class="w-full text-center py-2 hover:[style-color:var(--primary-color)]">Profile</a>
                            <a href="/orders" class="w-full text-center py-2 hover:[style-color:var(--primary-color)]">My Orders</a>
                            <a href="/settings" class="w-full text-center py-2 hover:[style-color:var(--primary-color)]">Settings</a>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full py-2 text-red-600 hover:text-red-700 font-medium">
                                    Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                @else
                    <!-- Mobile Menu - Not Logged In -->
                    <nav class="flex flex-col items-center space-y-2">
                        <a href="/" class="hover:[style-color:var(--primary-color)]">Home</a>
                        <a href="/products" class="hover:[style-color:var(--primary-color)]">Products</a>
                        <div class="flex flex-col space-y-2 w-full mt-4 pt-4 border-t border-gray-300">
                            <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 text-gray-700 hover:[style-color:var(--primary-color)] font-medium border border-gray-300 rounded-lg">Login</a>
                            <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Register</a>
                        </div>
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-1 container mx-auto py-8 px-6">
        @yield('content')
    </main>
    @stack('js')
    
    <style>
        .wishlist-icon {
            transition: all 0.3s ease;
        }
        .wishlist-icon.active {
            fill: currentColor;
        }
    </style>
    <script>
        // Wishlist functionality
        window.toggleWishlist = function(productId) {
            const btn = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
            if (!btn) return;
            
            const icon = btn.querySelector('.wishlist-icon');
            const path = icon.querySelector('path');
            
            // Toggle wishlist state
            const isActive = icon.classList.contains('active');
            
            if (isActive) {
                // Remove from wishlist
                icon.classList.remove('active', 'text-red-500');
                icon.classList.add('text-gray-400');
                icon.setAttribute('fill', 'none');
                path.setAttribute('stroke', 'currentColor');
                btn.classList.remove('bg-red-50');
                // Store in localStorage
                let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
                wishlist = wishlist.filter(id => id !== productId);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
            } else {
                // Add to wishlist
                icon.classList.remove('text-gray-400');
                icon.classList.add('active', 'text-red-500');
                icon.setAttribute('fill', 'currentColor');
                path.setAttribute('stroke', 'none');
                btn.classList.add('bg-red-50');
                // Store in localStorage
                let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
                if (!wishlist.includes(productId)) {
                    wishlist.push(productId);
                }
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
            }
        };
        
        // Initialize wishlist state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            wishlist.forEach(productId => {
                const btn = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
                if (btn) {
                    const icon = btn.querySelector('.wishlist-icon');
                    const path = icon.querySelector('path');
                    icon.classList.remove('text-gray-400');
                    icon.classList.add('active', 'text-red-500');
                    icon.setAttribute('fill', 'currentColor');
                    path.setAttribute('stroke', 'none');
                    btn.classList.add('bg-red-50');
                }
            });
        });
    </script>
    
    <!-- Theme Color Configuration -->
    <script>
        // Simulasi data tema dari API (array sederhana)
        const themeConfig = {
            primaryColor: '#3b82f6',    // Warna untuk buttons
            secondaryColor: '#8b5cf6',  // Warna untuk navbar
            appName: 'MyShop',
            logo: null // URL logo jika ada
        };
        
        // Apply theme colors saat DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            // Apply secondary color ke navbar
            const navbar = document.querySelector('.theme-navbar');
            if (navbar) {
                navbar.style.backgroundColor = themeConfig.secondaryColor;
            }
            
            // Apply primary color ke semua buttons dengan class theme-primary-btn
            const primaryButtons = document.querySelectorAll('.theme-primary-btn');
            primaryButtons.forEach(btn => {
                btn.style.backgroundColor = themeConfig.primaryColor;
                btn.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = themeConfig.secondaryColor;
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = themeConfig.primaryColor;
                });
            });
            
            // Apply primary color ke logo/app name
            const appLogo = document.getElementById('app-logo');
            if (appLogo) {
                if (themeConfig.logo) {
                    appLogo.innerHTML = `<img src="${themeConfig.logo}" alt="${themeConfig.appName}" class="h-8 object-contain">`;
                } else {
                    appLogo.style.color = themeConfig.primaryColor;
                    appLogo.textContent = themeConfig.appName;
                }
            }
            
            // Apply primary color ke hover states pada links
            const navLinks = document.querySelectorAll('nav a, header a:not(.theme-primary-btn)');
            navLinks.forEach(link => {
                const originalColor = window.getComputedStyle(link).color;
                link.addEventListener('mouseenter', function() {
                    this.style.color = themeConfig.primaryColor;
                });
                link.addEventListener('mouseleave', function() {
                    this.style.color = originalColor;
                });
            });
        });
    </script>
    
    <!-- Company Information Handler -->
    <script>
        // Simulasi data company dari API (array sederhana)
        const companyData = {
            name: 'MyShop',
            phone: '+1 (555) 123-4567',
            email: 'support@myshop.com',
            address: '123 Main Street, Suite 100, New York, NY 10001, United States',
            socialMedia: {
                x: '#', // X (Twitter)
                whatsapp: '#', // WhatsApp
                instagram: '#', // Instagram
                youtube: '#', // YouTube
                linkedin: '#', // LinkedIn
                other: '#' // Other social media
            }
        };
        
        /**
         * Fetch company data from API
         * Untuk sementara return data dari array, nanti bisa diganti dengan fetch API
         */
        async function fetchCompanyData() {
            // TODO: Replace with actual API call
            // return await fetch('/api/company/info').then(res => res.json());
            
            // Simulasi delay API (opsional)
            // await new Promise(resolve => setTimeout(resolve, 100));
            
            return Promise.resolve(companyData);
        }
        
        /**
         * Render company contact information
         */
        function renderCompanyContactInfo(data) {
            const container = document.getElementById('company-contact-info');
            if (!container) return;
            
            let html = '';
            
            // Website/Company Name
            if (data.name) {
                html += `
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <span>${data.name}</span>
                    </div>
                `;
            }
            
            // Phone Number
            if (data.phone) {
                html += `
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>${data.phone}</span>
                    </div>
                `;
            }
            
            // Email Address
            if (data.email) {
                html += `
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>${data.email}</span>
                    </div>
                `;
            }
            
            // Physical Address
            if (data.address) {
                html += `
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-xs">${data.address}</span>
                    </div>
                `;
            }
            
            container.innerHTML = html;
        }
        
        /**
         * Render social media icons
         */
        function renderSocialMedia(data) {
            const container = document.getElementById('company-social-media');
            if (!container || !data.socialMedia) return;
            
            const social = data.socialMedia;
            let html = '';
            
            // Social media icons mapping
            const socialIcons = [
                { key: 'x', url: social.x, icon: '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>', hoverColor: 'group-hover:text-black' },
                { key: 'whatsapp', url: social.whatsapp, icon: '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>', hoverColor: 'group-hover:text-green-600' },
                { key: 'instagram', url: social.instagram, icon: '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>', hoverColor: 'group-hover:text-pink-600' },
                { key: 'youtube', url: social.youtube, icon: '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>', hoverColor: 'group-hover:text-red-600' },
                { key: 'linkedin', url: social.linkedin, icon: '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>', hoverColor: 'group-hover:text-blue-600' }
            ];
            
            socialIcons.forEach(item => {
                // Tampilkan semua icon, gunakan '#' jika URL kosong
                const url = item.url || '#';
                html += `
                    <a href="${url}" ${url !== '#' ? 'target="_blank" rel="noopener noreferrer"' : ''} class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors group">
                        <svg class="w-4 h-4 text-gray-700 ${item.hoverColor} transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            ${item.icon}
                        </svg>
                    </a>
                `;
            });
            
            container.innerHTML = html;
        }
        
        /**
         * Initialize company information
         */
        async function initCompanyInfo() {
            try {
                const data = await fetchCompanyData();
                renderCompanyContactInfo(data);
                renderSocialMedia(data);
            } catch (error) {
                console.error('Error loading company information:', error);
            }
        }
        
        // Initialize on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            initCompanyInfo();
        });
    </script>
    
    <!-- Footer -->
    @include('public.layouts.footer')
    
    <!-- Scroll to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="fixed bottom-4 right-4 bg-gray-800 text-white p-3 rounded-full shadow-lg hover:bg-gray-700 transition-colors z-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

</body>

</html>
