<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - MyShop Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100" x-data="{ userDropdownOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-bold">MyShop Admin</h1>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }} transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('admin.themes.index') }}" class="block px-4 py-2 rounded {{ request()->routeIs('admin.themes.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} transition-colors">
                    Themes
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} transition-colors">
                    Users
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 rounded {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} transition-colors">
                    Products
                </a>
                <div class="mt-2">
                    <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Page Content</div>
                    <a href="{{ route('admin.page-content.terms-conditions.edit') }}" class="block px-4 py-2 ml-4 rounded {{ request()->routeIs('admin.page-content.terms-conditions.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} transition-colors">
                        Terms & Conditions
                    </a>
                    <a href="{{ route('admin.page-content.seller-agreement.edit') }}" class="block px-4 py-2 ml-4 rounded {{ request()->routeIs('admin.page-content.seller-agreement.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} transition-colors">
                        Seller Agreement
                    </a>
                </div>
                <!-- Add more navigation items here -->
            </nav>
            
            <!-- User Section -->
            <div class="p-4 border-t border-gray-700">
                @php
                    $sidebarUserName = session('user_data')['name'] ?? 'Admin';
                    $sidebarUserEmail = session('user_data')['email'] ?? 'admin@myshop.com';
                    $sidebarUserImage = session('user_data')['image'] ?? (session('user_data')['avatar'] ?? null);
                @endphp
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden border-2 border-blue-500">
                        @if($sidebarUserImage)
                            <img src="{{ $sidebarUserImage }}" alt="{{ $sidebarUserName }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold">
                                {{ strtoupper(substr($sidebarUserName, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">{{ $sidebarUserName }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $sidebarUserEmail }}</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center gap-4">
                        <!-- User Dropdown -->
                        @php
                            $isLoggedIn = session()->has('sanctum_token');
                            $userData = session('user_data', null);
                            $userName = $userData['name'] ?? 'Admin';
                            $userEmail = $userData['email'] ?? 'admin@myshop.com';
                            $userImage = $userData['image'] ?? ($userData['avatar'] ?? null);
                        @endphp
                        
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
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    @stack('styles')
    @stack('scripts')
</body>
</html>
