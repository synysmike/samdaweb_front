<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="min-h-screen bg-white overflow-x-hidden flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md" x-data="{ open: false, userDropdownOpen: false }">
        @php
            $isLoggedIn = session()->has('sanctum_token');
            $userData = session('user_data', null);
            $userName = $userData['name'] ?? ($userData['name'] ?? 'User');
            $userEmail = $userData['email'] ?? ($userData['email'] ?? '');
            $userImage = $userData['image'] ?? ($userData['avatar'] ?? null);
        @endphp
        
        <div class="container mx-auto flex justify-between items-center py-4 px-6 gap-4">
            <!-- Logo and Search -->
            <div class="flex items-center gap-4 flex-1 md:flex-initial">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold text-blue-600 whitespace-nowrap">MyShop</a>

                <!-- Search Field -->
                <form action="/products" method="GET" class="hidden md:flex flex-1 max-w-md">
                    <div class="relative w-full">
                        <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}"
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
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
                    <a href="/" class="hover:text-blue-600">Home</a>
                    <a href="/products" class="hover:text-blue-600">Products</a>
                    <a href="/cart" class="hover:text-blue-600">🛒 Cart</a>
                </nav>

                <!-- User Dropdown - Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden border-2 border-blue-500">
                                @if($userImage)
                                    <img src="{{ $userImage }}" alt="{{ $userName }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold">
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
                    <a href="/" class="hover:text-blue-600">Home</a>
                    <a href="/products" class="hover:text-blue-600">Products</a>
                </nav>

                <!-- Login/Register Buttons - Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium">Login</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Register</a>
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
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600">
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
                            <div class="w-12 h-12 rounded-full bg-gray-300 overflow-hidden border-2 border-blue-500">
                                @if($userImage)
                                    <img src="{{ $userImage }}" alt="{{ $userName }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold text-lg">
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
                            <a href="/" class="w-full text-center py-2 hover:text-blue-600">Home</a>
                            <a href="/products" class="w-full text-center py-2 hover:text-blue-600">Products</a>
                            <a href="/cart" class="w-full text-center py-2 hover:text-blue-600">🛒 Cart</a>
                            <a href="/profile" class="w-full text-center py-2 hover:text-blue-600">Profile</a>
                            <a href="/orders" class="w-full text-center py-2 hover:text-blue-600">My Orders</a>
                            <a href="/settings" class="w-full text-center py-2 hover:text-blue-600">Settings</a>
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
                        <a href="/" class="hover:text-blue-600">Home</a>
                        <a href="/products" class="hover:text-blue-600">Products</a>
                        <div class="flex flex-col space-y-2 w-full mt-4 pt-4 border-t border-gray-300">
                            <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 text-gray-700 hover:text-blue-600 font-medium border border-gray-300 rounded-lg">Login</a>
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
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 text-center py-4">
        © {{ date('Y') }} MyShop Dashboard. All rights reserved.
    </footer>

</body>

</html>
