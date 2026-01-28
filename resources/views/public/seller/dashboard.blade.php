@extends('public.seller.layout')

@section('seller-content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-8 text-white">
        <h1 class="text-3xl font-bold mb-2">Welcome to Seller Dashboard</h1>
        <p class="text-blue-100">Manage your products, categories, and sales from here</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Categories Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Categories</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="totalCategories">-</p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('seller.categories') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mt-4 inline-block">
                View all →
            </a>
        </div>

        <!-- Subcategories Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Subcategories</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="totalSubCategories">-</p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('seller.categories') }}" class="text-green-600 hover:text-green-800 text-sm font-medium mt-4 inline-block">
                View all →
            </a>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Quick Actions</p>
                    <p class="text-lg font-semibold text-gray-900 mt-2">Get Started</p>
                </div>
                <div class="bg-purple-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <a href="{{ route('seller.categories') }}" class="block text-purple-600 hover:text-purple-800 text-sm font-medium">
                    Manage Categories →
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
        <div class="space-y-4">
            <div class="flex items-center text-gray-600">
                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                <p class="text-sm">Welcome to your seller dashboard. Start by managing your categories.</p>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    // Load stats on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadStats();
    });

    async function loadStats() {
        try {
            // Load categories count
            const categoriesResponse = await fetch('{{ route("api.seller.categories") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (categoriesResponse.ok) {
                const categoriesData = await categoriesResponse.json();
                if (categoriesData.status === 'success' || categoriesData.success) {
                    const categories = categoriesData.data || [];
                    document.getElementById('totalCategories').textContent = categories.length;
                }
            }

            // Load subcategories count
            const subcategoriesResponse = await fetch('{{ route("api.seller.subcategories") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (subcategoriesResponse.ok) {
                const subcategoriesData = await subcategoriesResponse.json();
                if (subcategoriesData.status === 'success' || subcategoriesData.success) {
                    const subcategories = subcategoriesData.data || [];
                    document.getElementById('totalSubCategories').textContent = subcategories.length;
                }
            }
        } catch (error) {
            console.error('Error loading stats:', error);
        }
    }
</script>
@endpush
@endsection
