@extends('public.layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: false }">
    <!-- Mobile navbar (visible only on mobile) -->
    <div class="md:hidden fixed top-0 left-0 right-0 z-40 h-14 bg-gray-800 text-white flex items-center justify-between px-4 shadow-lg">
        <button type="button" @click="sidebarOpen = true" class="p-2 -ml-2 text-gray-300 hover:text-white" aria-label="Open menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <h2 class="text-lg font-bold">Seller Panel</h2>
        <div class="w-10"></div>
    </div>

    <!-- Backdrop (mobile only, when sidebar open) -->
    <div x-show="sidebarOpen" x-transition.opacity
         @click="sidebarOpen = false"
         class="md:hidden fixed inset-0 bg-black/50 z-40"
         x-cloak></div>

    <!-- Sidebar: drawer on mobile, fixed left on desktop -->
    <aside class="fixed md:relative inset-y-0 left-0 z-50 w-64 bg-gray-800 text-white flex-shrink-0 flex flex-col border-r border-gray-700 transform transition-transform duration-200 ease-out -translate-x-full md:translate-x-0"
           :class="{ 'translate-x-0': sidebarOpen }">
        <div class="p-4 border-b border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-bold text-white">Seller Panel</h2>
            <button type="button" @click="sidebarOpen = false" class="md:hidden p-2 -mr-2 text-gray-300 hover:text-white" aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <a href="{{ route('seller.index') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('seller.index') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('seller.categories') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('seller.categories') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span>Categories</span>
            </a>
            <a href="{{ route('seller.products') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('seller.products') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span>Products</span>
            </a>
            <a href="{{ route('seller.attributes') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('seller.attributes') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                <span>Attributes</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <a href="{{ route('seller.shop-profile') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('seller.shop-profile') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700/50 hover:text-white' }} transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Shop Profile</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 bg-white pt-14 md:pt-0">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex-shrink-0">
            <h2 class="text-xl font-semibold text-gray-800">@yield('seller-page-title', 'Seller Dashboard')</h2>
        </div>
        <div class="flex-1 overflow-y-auto p-4 sm:p-6">
            @yield('seller-content')
        </div>
    </div>
</div>
@endsection
