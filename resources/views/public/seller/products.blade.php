@extends('public.seller.layout')

@section('seller-content')
    <style>
        .product-image-slider {
            position: relative;
            width: 5rem;
            height: 5rem;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #f3f4f6;
        }

        .product-image-slider .slides {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .product-image-slider .slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.25s ease;
            pointer-events: none;
        }

        .product-image-slider .slide.active {
            opacity: 1;
            z-index: 1;
            pointer-events: auto;
        }

        .product-image-slider .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-image-slider .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            width: 1.5rem;
            height: 1.5rem;
            border: 0;
            border-radius: 9999px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.7;
            transition: opacity 0.2s;
            font-size: 0.75rem;
        }

        .product-image-slider .slider-btn:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.7);
        }

        .product-image-slider .slider-prev {
            left: 2px;
        }

        .product-image-slider .slider-next {
            right: 2px;
        }

    </style>

    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
                <h1 class="text-3xl font-bold text-white">Products</h1>
                <p class="text-blue-100 mt-2">Manage your products</p>
            </div>

            <!-- Products Section -->
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Product List</h2>
                    <a href="{{ route('seller.products.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium inline-block">
                        + Add Product
                    </a>
                </div>

                <!-- Products Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subcategory</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price Range</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <p>Loading products...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            let products = [];
            let categories = [];
            let subcategories = [];

            const API_BASE_URL = ((@json(config('api.base_url'))) || '').replace(/\/$/, '');
            function imageUrlFromFilePath(filePath) {
                if (!filePath || typeof filePath !== 'string') return null;
                if (filePath.startsWith('http://') || filePath.startsWith('https://')) return filePath;
                let rel = String(filePath).replace(/^\/+/, '');
                for (const p of ['storage/app/public/', 'app/public/', 'storage/']) {
                    if (rel.startsWith(p)) { rel = rel.slice(p.length); break; }
                }
                rel = rel.replace(/^\/+/, '');
                if (!rel) return null;
                return API_BASE_URL ? (API_BASE_URL + '/storage/' + rel) : ('/storage/' + rel);
            }

            document.addEventListener('DOMContentLoaded', async function() {
                await loadCategories();
                loadProducts();
            });

            // Load categories (unified API returns all with parent_id; root = categories, children = subcategories)
            async function loadCategories() {
                try {
                    const response = await fetch('{{ route('api.seller.categories') }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    });

                    const result = await response.json();
                    if (result.status === 'success' || result.success) {
                        let raw = result.data ?? result.categories ?? [];
                        if (typeof raw === 'string') {
                            try {
                                raw = JSON.parse(raw) || [];
                            } catch (_) {
                                raw = [];
                            }
                        }
                        const arr = Array.isArray(raw) ? raw : [];
                        // Split API response: no parent_id → category; has parent_id → subcategory
                        const roots = arr.filter(c => {
                            const pid = c.parent_id ?? c.parentId ?? null;
                            return pid == null || pid === '';
                        });
                        const children = arr.filter(c => {
                            const pid = c.parent_id ?? c.parentId ?? null;
                            return pid != null && String(pid).trim() !== '';
                        });
                        categories = roots.map(c => ({
                            id: String(c.id ?? c.categoryId ?? ''),
                            name: c.name ?? ''
                        }));
                        subcategories = children.map(s => ({
                            id: String(s.id ?? s.subcategoryId ?? ''),
                            name: s.name ?? '',
                            category_id: String(s.parent_id ?? s.category_id ?? s.categoryId ?? '')
                        }));
                    }
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
            }

            // Load products
            async function loadProducts() {
                try {
                    const response = await fetch('{{ route('api.seller.products') }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    });

                    const result = await response.json();

                    if (response.status === 401) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unauthorized',
                            text: result.message || 'Your session has expired. Please login again.',
                            confirmButtonText: 'Go to Login',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('login') }}';
                            }
                        });
                        return;
                    }

                    if (result.status === 'success' || result.success) {
                        products = result.data || [];
                        await loadProductImagesAndMerge();
                        renderProducts();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message || 'Failed to load products'
                        });
                    }
                } catch (error) {
                    console.error('Error loading products:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while loading products'
                    });
                }
            }

            // Fetch product images (POST { product_id }) and merge into products. Response: { success, data: [ { file_path, ... } ] }
            async function fetchProductImages(productId) {
                const res = await fetch('{{ route('api.seller.products.images') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        product_id: String(productId)
                    })
                });
                const json = await res.json();
                const list = (json.success && json.data) ? json.data : [];
                return list.map(item => imageUrlFromFilePath(item.file_path)).filter(Boolean);
            }

            async function loadProductImagesAndMerge() {
                try {
                    const pair = await Promise.all(products.map(async (p) => {
                        const urls = await fetchProductImages(p.id);
                        return [p, urls];
                    }));
                    pair.forEach(([p, urls]) => {
                        p.images = urls;
                        p.image = urls[0] || null;
                    });
                } catch (e) {
                    console.warn('Could not load product images:', e);
                }
            }

            // Render products table
            function renderProducts() {
                const tbody = document.getElementById('productsTableBody');

                if (products.length === 0) {
                    tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p>No products found. Click "Add Product" to create one.</p>
                        </div>
                    </td>
                </tr>
            `;
                    return;
                }

                tbody.innerHTML = products.map(product => {
                    const isActive = product.is_active === true || product.is_active === '1' || product.is_active === 1;
                    const productCatId = String(product.category_id ?? product.categoryId ?? '');
                    const sub = subcategories.find(s => String(s.id) === productCatId);
                    const cat = categories.find(c => String(c.id) === productCatId);
                    let categoryName = 'N/A';
                    let subcategoryName = '-';
                    if (sub) {
                        const parentCat = categories.find(c => String(c.id) === String(sub.category_id ?? ''));
                        categoryName = parentCat ? parentCat.name : 'N/A';
                        subcategoryName = sub.name || '-';
                    } else if (cat) {
                        categoryName = cat.name || 'N/A';
                        subcategoryName = '-';
                    }
                    const imgs = (product.images && product.images.length) ? product.images : [
                        '/placeholder-image.svg'
                    ];
                    const displayName = product.title || product.name || 'N/A';
                    const slidesHtml = imgs.map((url, i) =>
                        `<div class="slide ${i === 0 ? 'active' : ''}" data-index="${i}"><img src="${escapeHtml(url)}" alt="${escapeHtml(displayName)}" onerror="this.src='/placeholder-image.svg'"></div>`
                    ).join('');
                    const multi = imgs.length > 1;
                    const navHtml = multi ?
                        `<button type="button" class="slider-btn slider-prev" onclick="productImageSliderPrev(this)" aria-label="Previous">&lsaquo;</button><button type="button" class="slider-btn slider-next" onclick="productImageSliderNext(this)" aria-label="Next">&rsaquo;</button>` :
                        '';
                    return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="product-image-slider" data-current="0">
                            <div class="slides">${slidesHtml}</div>
                            ${navHtml}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(displayName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${escapeHtml(categoryName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${escapeHtml(subcategoryName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$${parseFloat(((product.min_price != null ? product.min_price : product.price) || 0)).toFixed(2)} - $${parseFloat(((product.max_price != null ? product.max_price : product.price) || 0)).toFixed(2)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${isActive ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ url('seller/products') }}/${product.id}/edit" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <button onclick="deleteProduct('${product.id}', '${escapeHtml(displayName)}')" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
            `;
                }).join('');
            }

            // Delete product
            window.deleteProduct = async function deleteProduct(id, name) {
                const result = await Swal.fire({
                    title: 'Delete Product?',
                    text: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                });

                if (result.isConfirmed) {
                    try {
                        const response = await fetch('{{ route('api.seller.products.delete') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                id: id
                            })
                        });

                        const data = await response.json();

                        if (response.status === 401) {
                            const errorMsg = data.message || (data.data && data.data.message) ||
                                'Your session has expired. Please login again.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Unauthorized',
                                text: errorMsg,
                                confirmButtonText: 'Go to Login',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '{{ route('login') }}';
                                }
                            });
                            return;
                        }

                        if (data.success || data.status === 'success' || response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message || 'Product deleted successfully',
                                timer: 2000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            loadProducts();
                        } else {
                            const errorMsg = data.message || (data.data && data.data.message) ||
                                'Failed to delete product.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete failed',
                                text: errorMsg,
                                confirmButtonText: 'OK'
                            });
                        }
                    } catch (error) {
                        console.error('Error deleting product:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Could not delete product. Please try again.'
                        });
                    }
                }
            }

            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return String(text).replace(/[&<>"']/g, m => map[m]);
            }

            window.productImageSliderPrev = function productImageSliderPrev(btn) {
                const wrap = btn.closest('.product-image-slider');
                if (!wrap) return;
                const slides = wrap.querySelectorAll('.slide');
                if (slides.length < 2) return;
                let cur = parseInt(wrap.getAttribute('data-current') || '0', 10);
                cur = cur <= 0 ? slides.length - 1 : cur - 1;
                wrap.setAttribute('data-current', String(cur));
                slides.forEach((s, i) => s.classList.toggle('active', i === cur));
            }

            window.productImageSliderNext = function productImageSliderNext(btn) {
                const wrap = btn.closest('.product-image-slider');
                if (!wrap) return;
                const slides = wrap.querySelectorAll('.slide');
                if (slides.length < 2) return;
                let cur = parseInt(wrap.getAttribute('data-current') || '0', 10);
                cur = cur >= slides.length - 1 ? 0 : cur + 1;
                wrap.setAttribute('data-current', String(cur));
                slides.forEach((s, i) => s.classList.toggle('active', i === cur));
            }

        </script>
    @endpush
@endsection
