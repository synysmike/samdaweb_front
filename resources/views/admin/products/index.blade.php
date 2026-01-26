@extends('admin.layouts.app')

@section('title', 'Product Management')
@section('page-title', 'Product Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Manage Products</h3>
        <p class="text-sm text-gray-600 mt-1">Create, edit, and manage your product inventory</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Products</p>
                    <p id="totalProducts" class="text-3xl font-bold text-gray-900 mt-2">0</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Products</p>
                    <p id="activeProducts" class="text-3xl font-bold text-green-600 mt-2">0</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Low Stock</p>
                    <p id="lowStock" class="text-3xl font-bold text-orange-600 mt-2">0</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Value</p>
                    <p id="totalValue" class="text-3xl font-bold text-purple-600 mt-2">$0</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Custom Add Button - will be positioned next to entries dropdown by JavaScript -->
        <div id="custom-add-button-container" style="display: none;">
            <button onclick="openCreateModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Product
            </button>
        </div>
        <div class="overflow-x-auto">
            <table id="productsTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create/Edit Product Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeProductModalOnBackdrop(event)">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div class="p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
                <div class="flex justify-between items-center">
                    <h3 id="productModalTitle" class="text-lg font-semibold text-gray-900">Add New Product</h3>
                    <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="productForm" class="p-6 space-y-6">
                <!-- Basic Information -->
                <div>
                    <h4 class="text-md font-semibold text-gray-900 mb-4">Basic Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                            <input type="text" id="productName" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKU *</label>
                            <input type="text" id="productSKU" name="sku" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select id="productCategory" name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Category</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Clothing">Clothing</option>
                                <option value="Home & Garden">Home & Garden</option>
                                <option value="Sports">Sports</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Accessories">Accessories</option>
                                <option value="Beauty">Beauty</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="productDescription" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div>
                    <h4 class="text-md font-semibold text-gray-900 mb-4">Pricing & Inventory</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($) *</label>
                            <input type="number" id="productPrice" name="price" step="0.01" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                            <input type="number" id="productStock" name="stock" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select id="productStatus" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div>
                    <h4 class="text-md font-semibold text-gray-900 mb-4">Product Image</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                            <input type="url" id="productImage" name="image" placeholder="https://example.com/image.jpg" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div id="productImagePreview" class="w-32 h-32 border border-gray-300 rounded-lg overflow-hidden hidden">
                            <img id="productImagePreviewImg" src="" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeProductModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script>
    // Mock data untuk simulasi (frontend only)
    let productsData = [
        { id: 1, name: 'Wireless Headphones', category: 'Electronics', sku: 'PRD-001', price: 99.99, stock: 45, sales: 234, status: 'active', description: 'High-quality wireless headphones with noise cancellation', image: 'https://via.placeholder.com/300x300?text=Headphones' },
        { id: 2, name: 'Smart Watch', category: 'Electronics', sku: 'PRD-002', price: 299.99, stock: 23, sales: 156, status: 'active', description: 'Feature-rich smartwatch with fitness tracking', image: 'https://via.placeholder.com/300x300?text=SmartWatch' },
        { id: 3, name: 'Cotton T-Shirt', category: 'Clothing', sku: 'PRD-003', price: 19.99, stock: 120, sales: 456, status: 'active', description: 'Comfortable cotton t-shirt in various colors', image: 'https://via.placeholder.com/300x300?text=TShirt' },
        { id: 4, name: 'Garden Tools Set', category: 'Home & Garden', sku: 'PRD-004', price: 79.99, stock: 34, sales: 89, status: 'active', description: 'Complete set of gardening tools', image: 'https://via.placeholder.com/300x300?text=GardenTools' },
        { id: 5, name: 'Running Shoes', category: 'Sports', sku: 'PRD-005', price: 129.99, stock: 56, sales: 234, status: 'active', description: 'Professional running shoes with cushioning', image: 'https://via.placeholder.com/300x300?text=Shoes' },
        { id: 6, name: 'Designer Handbag', category: 'Fashion', sku: 'PRD-006', price: 199.99, stock: 12, sales: 45, status: 'active', description: 'Luxury designer handbag', image: 'https://via.placeholder.com/300x300?text=Handbag' },
        { id: 7, name: 'Leather Wallet', category: 'Accessories', sku: 'PRD-007', price: 49.99, stock: 78, sales: 123, status: 'active', description: 'Genuine leather wallet', image: 'https://via.placeholder.com/300x300?text=Wallet' },
        { id: 8, name: 'Face Cream', category: 'Beauty', sku: 'PRD-008', price: 29.99, stock: 90, sales: 234, status: 'active', description: 'Anti-aging face cream', image: 'https://via.placeholder.com/300x300?text=FaceCream' },
        { id: 9, name: 'Laptop Stand', category: 'Electronics', sku: 'PRD-009', price: 39.99, stock: 5, sales: 67, status: 'active', description: 'Adjustable laptop stand', image: 'https://via.placeholder.com/300x300?text=LaptopStand' },
        { id: 10, name: 'Wireless Mouse', category: 'Electronics', sku: 'PRD-010', price: 24.99, stock: 3, sales: 89, status: 'active', description: 'Ergonomic wireless mouse', image: 'https://via.placeholder.com/300x300?text=Mouse' },
        { id: 11, name: 'Yoga Mat', category: 'Sports', sku: 'PRD-011', price: 34.99, stock: 67, sales: 156, status: 'active', description: 'Non-slip yoga mat', image: 'https://via.placeholder.com/300x300?text=YogaMat' },
        { id: 12, name: 'Winter Jacket', category: 'Clothing', sku: 'PRD-012', price: 149.99, stock: 8, sales: 78, status: 'inactive', description: 'Warm winter jacket', image: 'https://via.placeholder.com/300x300?text=Jacket' }
    ];

    let currentEditId = null;

    // Initialize DataTable
    let productsTable = $('#productsTable').DataTable({
        data: [],
        columns: [
            {
                data: null,
                render: function(data, type, row) {
                    const imageSrc = row.image || 'https://via.placeholder.com/50x50?text=No+Image';
                    return `
                        <div class="flex items-center gap-3">
                            <img src="${imageSrc}" alt="${row.name}" class="w-12 h-12 object-cover rounded">
                            <div>
                                <div class="font-medium text-gray-900">${row.name}</div>
                                <div class="text-sm text-gray-500">${row.description || 'No description'}</div>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'category' },
            { data: 'sku' },
            {
                data: 'price',
                render: function(data) {
                    return '$' + parseFloat(data).toFixed(2);
                }
            },
            {
                data: 'stock',
                render: function(data, type, row) {
                    const stockClass = data <= 10 ? 'text-red-600 font-semibold' : 'text-gray-900';
                    return `<span class="${stockClass}">${data}</span>`;
                }
            },
            { data: 'sales' },
            {
                data: 'status',
                render: function(data) {
                    const statusColors = {
                        'active': 'bg-green-100 text-green-800',
                        'inactive': 'bg-gray-100 text-gray-800',
                        'draft': 'bg-yellow-100 text-yellow-800'
                    };
                    const statusColor = statusColors[data] || 'bg-gray-100 text-gray-800';
                    return `<span class="px-2 py-1 text-xs font-semibold rounded-full ${statusColor}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <div class="flex items-center gap-2">
                            <button onclick="editProduct(${row.id})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="deleteProduct(${row.id})" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        order: [[0, 'asc']],
        pageLength: 10,
        language: {
            search: "",
            searchPlaceholder: "Search products...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ products",
            infoEmpty: "Showing 0 to 0 of 0 products",
            infoFiltered: "(filtered from _TOTAL_ total products)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"<"flex items-center gap-4"l<"#custom-add-button-container">>f>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
        initComplete: function() {
            // Move custom button below entries dropdown after DataTables initializes
            setTimeout(function() {
                const lengthContainer = $('.dataTables_length');
                const customButtonContainer = $('#custom-add-button-container');
                if (lengthContainer.length && customButtonContainer.length) {
                    customButtonContainer.show();
                    customButtonContainer.detach().insertAfter(lengthContainer).css({
                        'margin-left': '0',
                        'margin-top': '0',
                        'display': 'inline-flex',
                        'align-items': 'center'
                    });
                }
            }, 100);
        }
    });

    // Load products data
    function loadProducts() {
        productsTable.clear();
        productsTable.rows.add(productsData);
        productsTable.draw();
        updateStatistics();
    }

    // Update statistics
    function updateStatistics() {
        const totalProducts = productsData.length;
        const activeProducts = productsData.filter(p => p.status === 'active').length;
        const lowStock = productsData.filter(p => p.stock <= 10).length;
        const totalValue = productsData.reduce((sum, p) => sum + (p.price * p.stock), 0);

        $('#totalProducts').text(totalProducts);
        $('#activeProducts').text(activeProducts);
        $('#lowStock').text(lowStock);
        $('#totalValue').text('$' + totalValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }

    // Open create modal
    function openCreateModal() {
        currentEditId = null;
        $('#productModalTitle').text('Add New Product');
        $('#productForm')[0].reset();
        $('#productImagePreview').addClass('hidden');
        $('#productModal').removeClass('hidden');
    }

    // Edit product
    function editProduct(id) {
        const product = productsData.find(p => p.id === id);
        if (!product) return;

        currentEditId = id;
        $('#productModalTitle').text('Edit Product');
        $('#productName').val(product.name);
        $('#productSKU').val(product.sku);
        $('#productCategory').val(product.category);
        $('#productDescription').val(product.description);
        $('#productPrice').val(product.price);
        $('#productStock').val(product.stock);
        $('#productStatus').val(product.status);
        $('#productImage').val(product.image || '');
        
        if (product.image) {
            $('#productImagePreviewImg').attr('src', product.image);
            $('#productImagePreview').removeClass('hidden');
        } else {
            $('#productImagePreview').addClass('hidden');
        }

        $('#productModal').removeClass('hidden');
    }

    // Delete product
    function deleteProduct(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this product?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                productsData = productsData.filter(p => p.id !== id);
                loadProducts();
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Product deleted successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Close modal
    function closeProductModal() {
        $('#productModal').addClass('hidden');
        currentEditId = null;
        $('#productForm')[0].reset();
        $('#productImagePreview').addClass('hidden');
    }

    // Close modal on backdrop click
    function closeProductModalOnBackdrop(event) {
        if (event.target.id === 'productModal') {
            closeProductModal();
        }
    }

    // Handle form submission
    $('#productForm').on('submit', function(e) {
        e.preventDefault();

        const formData = {
            name: $('#productName').val(),
            sku: $('#productSKU').val(),
            category: $('#productCategory').val(),
            description: $('#productDescription').val(),
            price: parseFloat($('#productPrice').val()),
            stock: parseInt($('#productStock').val()),
            status: $('#productStatus').val(),
            image: $('#productImage').val() || 'https://via.placeholder.com/300x300?text=No+Image'
        };

        if (currentEditId) {
            // Update existing product
            const productIndex = productsData.findIndex(p => p.id === currentEditId);
            if (productIndex !== -1) {
                productsData[productIndex] = {
                    ...productsData[productIndex],
                    ...formData
                };
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Product updated successfully!',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        } else {
            // Create new product
            const newProduct = {
                id: Math.max(...productsData.map(p => p.id)) + 1,
                sales: 0,
                ...formData
            };
            productsData.push(newProduct);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Product created successfully!',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }

        loadProducts();
        closeProductModal();
    });

    // Image preview
    $('#productImage').on('input', function() {
        const imageUrl = $(this).val();
        if (imageUrl) {
            $('#productImagePreviewImg').attr('src', imageUrl);
            $('#productImagePreview').removeClass('hidden');
        } else {
            $('#productImagePreview').addClass('hidden');
        }
    });

    // Initialize on page load
    $(document).ready(function() {
        loadProducts();
    });
</script>
@endpush

@endsection
