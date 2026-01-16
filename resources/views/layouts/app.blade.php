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
    <header class="bg-white shadow-md" x-data="{ open: false }">
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

            <!-- Desktop Nav -->
            <nav class="hidden md:flex space-x-6">
                <a href="/dashboard" class="hover:text-blue-600">Dashboard</a>
                <a href="/products" class="hover:text-blue-600">Products</a>
                <a href="/orders" class="hover:text-blue-600">Orders</a>
                <a href="/settings" class="hover:text-blue-600">Settings</a>
            </nav>

            <!-- Icons -->
            <div class="hidden md:flex space-x-4">
                <a href="/cart" class="hover:text-blue-600">🛒</a>
                <a href="/profile" class="hover:text-blue-600">👤</a>
            </div>

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
                <nav class="flex flex-col items-center space-y-2">
                    <a href="/dashboard" class="hover:text-blue-600">Dashboard</a>
                    <a href="/products" class="hover:text-blue-600">Products</a>
                    <a href="/orders" class="hover:text-blue-600">Orders</a>
                    <a href="/settings" class="hover:text-blue-600">Settings</a>
                    <div class="flex space-x-4 mt-2 justify-center">
                        <a href="/cart" class="hover:text-blue-600">🛒</a>
                        <a href="/profile" class="hover:text-blue-600">👤</a>
                    </div>
                </nav>
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
