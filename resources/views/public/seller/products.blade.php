@extends('public.seller.layout')

@section('seller-content')
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
                <button onclick="openProductModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    + Add Product
                </button>
            </div>

            <!-- Products Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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

<!-- Product Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 id="productModalTitle" class="text-xl font-semibold text-gray-800">Add Product</h3>
            <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="productForm" class="p-6 space-y-4">
            <input type="hidden" id="productId" name="id" value="">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="productName" class="block text-sm font-medium text-gray-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" id="productName" name="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter product name">
                </div>

                <div>
                    <label for="productPrice" class="block text-sm font-medium text-gray-700 mb-2">Price <span class="text-red-500">*</span></label>
                    <input type="number" id="productPrice" name="price" step="0.01" min="0" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0.00">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="productCategoryId" class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select id="productCategoryId" name="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a category</option>
                    </select>
                </div>

                <div>
                    <label for="productSubCategoryId" class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                    <select id="productSubCategoryId" name="sub_category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a subcategory</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="productDescription" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="productDescription" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter product description"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="productStock" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                    <input type="number" id="productStock" name="stock" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0">
                </div>

                <div>
                    <label for="productIsActive" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="1" checked
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="0"
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Inactive</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label for="productImages" class="block text-sm font-medium text-gray-700 mb-2">Product Images</label>
                <input type="file" id="productImages" name="images[]" multiple accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">You can select multiple images. Max file size: 1MB per image.</p>
                <div id="imagePreview" class="mt-4 grid grid-cols-4 gap-4"></div>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeProductModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    let products = [];
    let categories = [];
    let subcategories = [];

    // Load data on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCategories();
        loadSubCategories();
        loadProducts();
    });

    // Load categories
    async function loadCategories() {
        try {
            const response = await fetch('{{ route("api.seller.categories") }}', {
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
                categories = result.data || [];
            }
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    // Load subcategories
    async function loadSubCategories() {
        try {
            const response = await fetch('{{ route("api.seller.subcategories") }}', {
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
                subcategories = result.data || [];
            }
        } catch (error) {
            console.error('Error loading subcategories:', error);
        }
    }

    // Load products
    async function loadProducts() {
        try {
            const response = await fetch('{{ route("api.seller.products") }}', {
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
                        window.location.href = '{{ route("login") }}';
                    }
                });
                return;
            }

            if (result.status === 'success' || result.success) {
                products = result.data || [];
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
            const category = categories.find(cat => cat.id === product.category_id);
            const categoryName = category ? category.name : 'N/A';
            const imageUrl = product.image || product.images?.[0] || '/placeholder-image.png';
            
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(product.name || 'Product')}" 
                             class="w-16 h-16 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(product.name || 'N/A')}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${escapeHtml(categoryName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">$${parseFloat(product.price || 0).toFixed(2)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${product.stock || 0}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${isActive ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editProduct('${product.id}')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                        <button onclick="deleteProduct('${product.id}', '${escapeHtml(product.name)}')" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Open product modal for add
    function openProductModal() {
        document.getElementById('productModalTitle').textContent = 'Add Product';
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('imagePreview').innerHTML = '';
        document.querySelector('input[name="is_active"][value="1"]').checked = true;
        
        // Populate category dropdown
        populateCategoryDropdown();
        
        document.getElementById('productModal').classList.remove('hidden');
    }

    // Close product modal
    function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        document.getElementById('imagePreview').innerHTML = '';
    }

    // Populate category dropdown
    function populateCategoryDropdown() {
        const categorySelect = document.getElementById('productCategoryId');
        categorySelect.innerHTML = '<option value="">Select a category</option>';
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });
    }

    // Handle category change to load subcategories
    document.getElementById('productCategoryId').addEventListener('change', function() {
        const categoryId = this.value;
        const subCategorySelect = document.getElementById('productSubCategoryId');
        subCategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
        
        if (categoryId) {
            const filteredSubcategories = subcategories.filter(sub => sub.category_id === categoryId);
            filteredSubcategories.forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory.id;
                option.textContent = subcategory.name;
                subCategorySelect.appendChild(option);
            });
        }
    });

    // Handle image preview
    document.getElementById('productImages').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        Array.from(e.target.files).forEach(file => {
            if (file.size > 1048576) { // 1MB
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: `${file.name} is larger than 1MB`
                });
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">×</button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Edit product
    function editProduct(id) {
        const product = products.find(p => p.id === id);
        if (!product) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Product not found'
            });
            return;
        }

        document.getElementById('productModalTitle').textContent = 'Edit Product';
        document.getElementById('productId').value = product.id;
        document.getElementById('productName').value = product.name || '';
        document.getElementById('productPrice').value = product.price || '';
        document.getElementById('productDescription').value = product.description || '';
        document.getElementById('productStock').value = product.stock || '';
        
        populateCategoryDropdown();
        setTimeout(() => {
            document.getElementById('productCategoryId').value = product.category_id || '';
            document.getElementById('productCategoryId').dispatchEvent(new Event('change'));
            setTimeout(() => {
                document.getElementById('productSubCategoryId').value = product.sub_category_id || '';
            }, 100);
        }, 100);
        
        const isActive = product.is_active === true || product.is_active === '1' || product.is_active === 1;
        document.querySelector(`input[name="is_active"][value="${isActive ? '1' : '0'}"]`).checked = true;
        
        document.getElementById('productModal').classList.remove('hidden');
    }

    // Delete product
    async function deleteProduct(id, name) {
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
                const response = await fetch('{{ route("api.seller.products.delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ id: id })
                });

                const data = await response.json();

                if (response.status === 401) {
                    const errorMsg = data.message || data.data?.message || 'Your session has expired. Please login again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Unauthorized',
                        text: errorMsg,
                        confirmButtonText: 'Go to Login',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("login") }}';
                        }
                    });
                    return;
                }

                if (data.status === 'success' || response.ok) {
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
                    const errorMsg = data.message || data.data?.message || 'Failed to delete product. Endpoint may not be ready yet.';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Delete Endpoint Not Ready',
                        text: errorMsg,
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Error deleting product:', error);
                Swal.fire({
                    icon: 'warning',
                    title: 'Delete Endpoint Not Ready',
                    text: 'The delete endpoint is not available yet. Please try again later.'
                });
            }
        }
    }

    // Handle product form submission
    document.getElementById('productForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            id: document.getElementById('productId').value || null,
            name: document.getElementById('productName').value.trim(),
            price: parseFloat(document.getElementById('productPrice').value) || 0,
            category_id: document.getElementById('productCategoryId').value,
            sub_category_id: document.getElementById('productSubCategoryId').value || null,
            description: document.getElementById('productDescription').value.trim(),
            stock: parseInt(document.getElementById('productStock').value) || 0,
            is_active: document.querySelector('input[name="is_active"]:checked').value === '1'
        };

        if (!formData.name) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Product name is required'
            });
            return;
        }

        if (!formData.category_id) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select a category'
            });
            return;
        }

        try {
            // First save the product
            const response = await fetch('{{ route("api.seller.products.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.status === 401) {
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: data.message || 'Your session has expired. Please login again.',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
                return;
            }

            if (data.status === 'success' || response.ok) {
                const productId = data.data?.id || formData.id;
                
                // Handle image uploads if any
                const imageInput = document.getElementById('productImages');
                if (imageInput.files.length > 0 && productId) {
                    await uploadProductImages(productId, imageInput.files);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || (formData.id ? 'Product updated successfully' : 'Product created successfully'),
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                closeProductModal();
                loadProducts();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to save product'
                });
            }
        } catch (error) {
            console.error('Error saving product:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the product'
            });
        }
    });

    // Upload product images
    async function uploadProductImages(productId, files) {
        for (let file of Array.from(files)) {
            if (file.size > 1048576) {
                continue; // Skip files larger than 1MB
            }

            // Convert to base64
            const base64 = await new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => {
                    const base64String = reader.result.split(',')[1];
                    resolve(base64String);
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });

            try {
                await fetch('{{ route("api.seller.products.image.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        product_id: productId,
                        image: base64
                    })
                });
            } catch (error) {
                console.error('Error uploading image:', error);
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

    // Close modal on outside click
    document.getElementById('productModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProductModal();
        }
    });
</script>
@endpush
@endsection
