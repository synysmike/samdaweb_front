@extends('public.layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">
    <!-- Sidebar -->
    <aside 
        :class="sidebarOpen ? 'w-64' : 'w-16'"
        class="bg-white shadow-lg overflow-hidden transition-all duration-300 ease-in-out flex-shrink-0 flex flex-col fixed left-0 top-16 h-[calc(100vh-4rem)] z-40">
        <div class="p-4 border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800 transition-opacity duration-300" 
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Seller Panel</h2>
                <button 
                    @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg hover:bg-gray-100 transition-colors text-gray-600 hover:text-gray-900 flex-shrink-0"
                    title="Toggle Sidebar">
                    <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-transition>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                    <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-transition>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
        <nav class="mt-6 overflow-y-auto flex-1">
            <a href="{{ route('seller.index') }}" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs('seller.index') ? 'bg-blue-50 border-r-4 border-blue-600 text-blue-600' : '' }}"
               :title="sidebarOpen ? '' : 'Dashboard'">
                <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Dashboard</span>
            </a>
            <a href="{{ route('seller.categories') }}" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs('seller.categories') ? 'bg-blue-50 border-r-4 border-blue-600 text-blue-600' : '' }}"
               :title="sidebarOpen ? '' : 'Categories'">
                <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Categories</span>
            </a>
            <a href="{{ route('seller.products') }}" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs('seller.products') ? 'bg-blue-50 border-r-4 border-blue-600 text-blue-600' : '' }}"
               :title="sidebarOpen ? '' : 'Products'">
                <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Products</span>
            </a>
        </nav>

        <!-- Footer with Shop Profile -->
        <div class="border-t border-gray-200 flex-shrink-0">
            <a href="{{ route('seller.shop-profile') }}" 
               class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs('seller.shop-profile') ? 'bg-blue-50 border-r-4 border-blue-600 text-blue-600' : '' }}"
               :title="sidebarOpen ? '' : 'Shop Profile'">
                <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Shop Profile</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 transition-all duration-300 ease-in-out min-w-0" 
         :style="sidebarOpen ? 'margin-left: 16rem;' : 'margin-left: 4rem;'">

        <div class="px-6 py-8">
            @yield('seller-content')
        </div>
    </div>
</div>
@endsection
