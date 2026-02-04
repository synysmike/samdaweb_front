<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<body class="bg-gray-100 min-h-screen flex flex-col" x-data="{ userDropdownOpen: false }">
    <!-- Top Header Bar - merged with main layout -->
    <header class="bg-gray-800 text-white shadow-md flex-shrink-0">
        <div class="flex items-center justify-between h-16 px-6">
            <div class="flex items-center gap-6">
                <a href="/" class="text-xl font-bold text-white hover:text-gray-200 transition-colors">MyShop</a>
                <span class="text-gray-400">/</span>
                <span class="font-semibold text-gray-200">Admin</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="/" class="text-sm text-gray-300 hover:text-white transition-colors">View site</a>
                @php
                    $userData = session('user_data', null);
                    $userName = $userData['name'] ?? 'Admin';
                    $userEmail = $userData['email'] ?? 'admin@myshop.com';
                    $userImage = $userData['image'] ?? ($userData['avatar'] ?? null);
                @endphp
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-gray-600 overflow-hidden border border-gray-500">
                            @if($userImage)
                                <img src="{{ $userImage }}" alt="{{ $userName }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-sm font-semibold">
                                    {{ strtoupper(substr($userName, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak x-transition
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50 text-gray-800">
                        <div class="px-4 py-2 border-b border-gray-200">
                            <p class="text-sm font-semibold">{{ $userName }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $userEmail }}</p>
                        </div>
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main layout: sidebar + content in one flex row (no floating) -->
    <div class="flex flex-1 min-h-0">
        <!-- Sidebar - inline, part of layout flow -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0 flex flex-col border-r border-gray-700">
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-lg font-bold">Admin Panel</h2>
            </div>
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.themes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.themes.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    <span>Themes</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>Products</span>
                </a>
                <div class="pt-4 mt-4 border-t border-gray-700">
                    <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Page Content</div>
                    <a href="{{ route('admin.page-content.terms-conditions.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.page-content.terms-conditions.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Terms & Conditions</span>
                    </a>
                    <a href="{{ route('admin.page-content.seller-agreement.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.page-content.seller-agreement.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Seller Agreement</span>
                    </a>
                </div>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-600 overflow-hidden flex-shrink-0">
                        @if(!empty($userImage))
                            <img src="{{ $userImage }}" alt="{{ $userName }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-sm font-semibold">{{ strtoupper(substr($userName, 0, 1)) }}</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium truncate">{{ $userName }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $userEmail }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content - inline, part of layout flow -->
        <main class="flex-1 flex flex-col min-w-0 bg-white">
            <div class="px-6 py-4 border-b border-gray-200 flex-shrink-0">
                <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
            </div>
            <div class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    @stack('styles')
    @stack('scripts')
</body>
</html>
