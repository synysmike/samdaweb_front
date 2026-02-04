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

        <!-- Products Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="totalProducts">-</p>
                </div>
                <div class="bg-amber-100 rounded-full p-4">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('seller.products') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium mt-4 inline-block">
                View all →
            </a>
        </div>
    </div>

    <!-- Products Recap -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Products Recap</h2>
            <a href="{{ route('seller.products') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View all products →</a>
        </div>
        <div id="productsRecapBody" class="overflow-x-auto">
            <div class="flex items-center justify-center py-8 text-gray-500">
                <span>Loading products...</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <p class="text-sm font-medium text-gray-600 mb-4">Quick Actions</p>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('seller.products') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Product
            </a>
            <a href="{{ route('seller.categories') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm font-medium">
                Manage Categories
            </a>
            <a href="{{ route('seller.shop-profile') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors text-sm font-medium">
                Shop Profile
            </a>
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

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    async function loadStats() {
        try {
            const headers = {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            };

            const [categoriesRes, subcategoriesRes, productsRes] = await Promise.all([
                fetch('{{ route("api.seller.categories") }}', { method: 'GET', headers, credentials: 'same-origin' }),
                fetch('{{ route("api.seller.subcategories") }}', { method: 'GET', headers, credentials: 'same-origin' }),
                fetch('{{ route("api.seller.products") }}', { method: 'GET', headers, credentials: 'same-origin' })
            ]);

            if (categoriesRes.ok) {
                const d = await categoriesRes.json();
                const list = (d.success || d.status === 'success') ? (d.data || []) : [];
                document.getElementById('totalCategories').textContent = list.length;
            }
            if (subcategoriesRes.ok) {
                const d = await subcategoriesRes.json();
                const list = (d.success || d.status === 'success') ? (d.data || []) : [];
                document.getElementById('totalSubCategories').textContent = list.length;
            }
            if (productsRes.ok) {
                const d = await productsRes.json();
                const products = (d.success || d.status === 'success') ? (d.data || []) : [];
                document.getElementById('totalProducts').textContent = products.length;
                renderProductsRecap(products);
            } else {
                document.getElementById('totalProducts').textContent = '0';
                document.getElementById('productsRecapBody').innerHTML = '<div class="text-center py-8 text-gray-500 text-sm">Could not load products</div>';
            }
        } catch (error) {
            console.error('Error loading stats:', error);
            document.getElementById('productsRecapBody').innerHTML = '<div class="text-center py-8 text-gray-500 text-sm">Error loading products</div>';
        }
    }

    function renderProductsRecap(products) {
        const body = document.getElementById('productsRecapBody');
        const recent = products.slice(0, 10);
        if (recent.length === 0) {
            body.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <p class="mb-2">No products yet</p>
                    <a href="{{ route('seller.products') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Add your first product →</a>
                </div>
            `;
            return;
        }
        body.innerHTML = `
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    ${recent.map(p => {
                        const title = escapeHtml(p.title || p.name || 'Untitled');
                        const price = parseFloat(p.price || 0).toFixed(2);
                        const stock = p.stock ?? 0;
                        const isActive = p.is_active === true || p.is_active === '1' || p.is_active === 1;
                        return `<tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${title}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">$${price}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">${stock}</td>
                            <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs font-medium rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${isActive ? 'Active' : 'Inactive'}</span></td>
                            <td class="px-4 py-3 text-right"><a href="{{ route('seller.products') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a></td>
                        </tr>`;
                    }).join('')}
                </tbody>
            </table>
        `;
    }
</script>
@endpush
@endsection
