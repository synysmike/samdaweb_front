@extends('public.seller.layout')

@section('seller-content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
            <h1 class="text-3xl font-bold text-white">Product Categories</h1>
            <p class="text-blue-100 mt-2">Manage your product categories and subcategories</p>
        </div>

        <!-- Categories Section -->
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Categories</h2>
                <button onclick="openCategoryModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    + Add Category
                </button>
            </div>

            <!-- Categories Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <p>Loading categories...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Subcategories Section -->
        <div class="p-6 border-t border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Subcategories</h2>
                <button onclick="openSubCategoryModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    + Add Subcategory
                </button>
            </div>

            <!-- Subcategories Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategory Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subcategoriesTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <p>Loading subcategories...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 id="modalTitle" class="text-xl font-semibold text-gray-800">Add Category</h3>
            <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="categoryForm" class="p-6 space-y-4">
            <input type="hidden" id="categoryId" name="id" value="">
            
            <div>
                <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
                <input type="text" id="categoryName" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter category name">
            </div>

            <div>
                <label for="categoryIsActive" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeCategoryModal()"
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

<!-- Subcategory Modal -->
<div id="subCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 id="subCategoryModalTitle" class="text-xl font-semibold text-gray-800">Add Subcategory</h3>
            <button onclick="closeSubCategoryModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="subCategoryForm" class="p-6 space-y-4">
            <input type="hidden" id="subCategoryId" name="id" value="">
            
            <div>
                <label for="subCategoryParentId" class="block text-sm font-medium text-gray-700 mb-2">Parent Category <span class="text-red-500">*</span></label>
                <select id="subCategoryParentId" name="parent_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Select a category</option>
                </select>
            </div>

            <div>
                <label for="subCategoryName" class="block text-sm font-medium text-gray-700 mb-2">Subcategory Name <span class="text-red-500">*</span></label>
                <input type="text" id="subCategoryName" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter subcategory name">
            </div>

            <div>
                <label for="subCategoryIsActive" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
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

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeSubCategoryModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
    let allCategories = [];  // flat list from API
    let categories = [];     // root categories (parent_id null/empty)
    let subcategories = [];  // child categories (parent_id set)

    // Parse UUID from category (handles id, categoryId, string, object)
    function parseUuid(val) {
        if (val == null) return '';
        if (typeof val === 'string') return val.trim();
        if (typeof val === 'object' && val !== null && (val.id || val.categoryId)) return String(val.id || val.categoryId || '').trim();
        return String(val).trim();
    }

    // Auth headers + credentials for category CRUD (ensures session cookie is sent)
    function getCategoryAuthHeaders() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': meta ? meta.content : '',
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    // Load categories on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCategories();
    });

    // Load all categories from API (unified endpoint with parent_id)
    async function loadCategories() {
        try {
            const response = await fetch('{{ route("api.seller.categories") }}', {
                method: 'GET',
                headers: getCategoryAuthHeaders(),
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
                let raw = result.data ?? result.categories ?? [];
                if (typeof raw === 'string') {
                    try { raw = JSON.parse(raw) || []; } catch (_) { raw = []; }
                }
                const arr = Array.isArray(raw) ? raw : [];
                // Map each item: { id, name, created_at, updated_at, slug, parent_id }
                allCategories = arr.map(c => {
                    const id = parseUuid(c.id ?? c.categoryId ?? '');
                    const parentId = parseUuid(c.parent_id ?? c.parentId ?? null);
                    return {
                        id: id,
                        name: c.name ?? '',
                        parent_id: parentId || null,
                        created_at: c.created_at,
                        updated_at: c.updated_at,
                        slug: c.slug ?? '',
                        is_active: c.is_active
                    };
                });
                // Split: no parent_id → category list; has parent_id → subcategory list
                categories = allCategories.filter(c => !c.parent_id || c.parent_id === '');
                subcategories = allCategories.filter(c => c.parent_id && c.parent_id !== '');
                renderCategories();
                renderSubCategories();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Failed to load categories'
                });
            }
        } catch (error) {
            console.error('Error loading categories:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while loading categories'
            });
        }
    }

    // Helper to get category name by id
    function getCategoryName(id) {
        const idStr = parseUuid(id);
        const c = allCategories.find(x => parseUuid(x.id) === idStr);
        return c ? c.name : 'Unknown';
    }

    // Render categories table
    function renderCategories() {
        const tbody = document.getElementById('categoriesTableBody');
        
        if (categories.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p>No categories found. Click "Add Category" to create one.</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = categories.map(category => {
            const createdDate = category.created_at ? new Date(category.created_at).toLocaleDateString() : 'N/A';
            const updatedDate = category.updated_at ? new Date(category.updated_at).toLocaleDateString() : 'N/A';
            const isActive = category.is_active === true || category.is_active === '1' || category.is_active === 1;
            
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(category.name || 'N/A')}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${isActive ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${createdDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${updatedDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editCategory('${category.id}')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                        <button onclick="deleteCategory('${category.id}', '${escapeHtml(category.name)}')" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Open category modal for add
    function openCategoryModal() {
        document.getElementById('modalTitle').textContent = 'Add Category';
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryId').value = '';
        document.querySelector('#categoryForm input[name="is_active"][value="1"]').checked = true;
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    // Close category modal
    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryId').value = '';
    }

    // Edit category
    function editCategory(id) {
        const category = categories.find(cat => String(cat.id) === String(id));
        if (!category) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Category not found'
            });
            return;
        }

        document.getElementById('modalTitle').textContent = 'Edit Category';
        document.getElementById('categoryId').value = category.id;
        document.getElementById('categoryName').value = category.name || '';
        
        const isActive = category.is_active === true || category.is_active === '1' || category.is_active === 1;
        document.querySelector(`#categoryForm input[name="is_active"][value="${isActive ? '1' : '0'}"]`).checked = true;
        
        document.getElementById('categoryModal').classList.remove('hidden');
    }

    // Delete category
    async function deleteCategory(id, name) {
        const result = await Swal.fire({
            title: 'Delete Category?',
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
                const response = await fetch('{{ route("api.seller.categories.delete") }}', {
                    method: 'POST',
                    headers: getCategoryAuthHeaders(),
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
                        text: data.message || 'Category deleted successfully',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    loadCategories();
                } else {
                    const errorMsg = data.message || data.data?.message || 'Failed to delete category';
                    const apiStatus = data.api_status ? ` (API Status: ${data.api_status})` : '';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: `<div>${escapeHtml(errorMsg)}${apiStatus}</div>${data.data ? '<pre style="text-align:left;font-size:0.8em;max-height:200px;overflow:auto;">' + escapeHtml(JSON.stringify(data.data, null, 2)) + '</pre>' : ''}`,
                        width: '600px'
                    });
                }
            } catch (error) {
                console.error('Error deleting category:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the category'
                });
            }
        }
    }

    // Handle category form submission
    document.getElementById('categoryForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            id: document.getElementById('categoryId').value || null,
            name: document.getElementById('categoryName').value.trim(),
            is_active: document.querySelector('#categoryForm input[name="is_active"]:checked').value === '1',
            parent_id: null
        };

        if (!formData.name) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Category name is required'
            });
            return;
        }

        try {
            const response = await fetch('{{ route("api.seller.categories.store") }}', {
                method: 'POST',
                headers: getCategoryAuthHeaders(),
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || (formData.id ? 'Category updated successfully' : 'Category created successfully'),
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                closeCategoryModal();
                loadCategories();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to save category'
                });
            }
        } catch (error) {
            console.error('Error saving category:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the category'
            });
        }
    });

    // ========== SUBCATEGORY FUNCTIONS ==========

    // Render subcategories table
    function renderSubCategories() {
        const tbody = document.getElementById('subcategoriesTableBody');
        
        if (subcategories.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p>No subcategories found. Click "Add Subcategory" to create one.</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = subcategories.map(subcategory => {
            const createdDate = subcategory.created_at ? new Date(subcategory.created_at).toLocaleDateString() : 'N/A';
            const updatedDate = subcategory.updated_at ? new Date(subcategory.updated_at).toLocaleDateString() : 'N/A';
            const isActive = subcategory.is_active === true || subcategory.is_active === '1' || subcategory.is_active === 1;
            
            const categoryName = getCategoryName(subcategory.parent_id ?? subcategory.category_id ?? subcategory.categoryId ?? '');
            
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(categoryName)}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(subcategory.name || 'N/A')}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${isActive ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${createdDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${updatedDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editSubCategory('${subcategory.id}')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                        <button onclick="deleteSubCategory('${subcategory.id}', '${escapeHtml(subcategory.name)}')" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Open subcategory modal for add
    function openSubCategoryModal() {
        document.getElementById('subCategoryModalTitle').textContent = 'Add Subcategory';
        document.getElementById('subCategoryForm').reset();
        document.getElementById('subCategoryId').value = '';
        document.querySelector('#subCategoryForm input[name="is_active"][value="1"]').checked = true;
        
        // Populate parent category dropdown (use parsed UUID as option value)
        const parentSelect = document.getElementById('subCategoryParentId');
        parentSelect.innerHTML = '<option value="">Select a category</option>';
        categories.forEach(category => {
            const uuid = parseUuid(category.id);
            if (!uuid) return;
            const option = document.createElement('option');
            option.value = uuid;
            option.textContent = category.name || 'Unnamed';
            parentSelect.appendChild(option);
        });
        
        document.getElementById('subCategoryModal').classList.remove('hidden');
    }

    // Close subcategory modal
    function closeSubCategoryModal() {
        document.getElementById('subCategoryModal').classList.add('hidden');
        document.getElementById('subCategoryForm').reset();
        document.getElementById('subCategoryId').value = '';
    }

    // Edit subcategory
    function editSubCategory(id) {
        const idStr = parseUuid(id);
        const subcategory = subcategories.find(sub => parseUuid(sub.id) === idStr);
        if (!subcategory) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Subcategory not found'
            });
            return;
        }

        document.getElementById('subCategoryModalTitle').textContent = 'Edit Subcategory';
        document.getElementById('subCategoryId').value = subcategory.id;
        document.getElementById('subCategoryName').value = subcategory.name || '';
        
        // Populate parent category dropdown (use parsed UUID as option value)
        const parentSelect = document.getElementById('subCategoryParentId');
        parentSelect.innerHTML = '<option value="">Select a category</option>';
        const targetParentId = parseUuid(subcategory.parent_id ?? subcategory.category_id ?? subcategory.categoryId ?? '');
        categories.forEach(category => {
            const uuid = parseUuid(category.id);
            if (!uuid) return;
            const option = document.createElement('option');
            option.value = uuid;
            option.textContent = category.name || 'Unnamed';
            if (uuid === targetParentId) option.selected = true;
            parentSelect.appendChild(option);
        });
        
        const isActive = subcategory.is_active === true || subcategory.is_active === '1' || subcategory.is_active === 1;
        document.querySelector(`#subCategoryForm input[name="is_active"][value="${isActive ? '1' : '0'}"]`).checked = true;
        
        document.getElementById('subCategoryModal').classList.remove('hidden');
    }

    // Delete subcategory
    async function deleteSubCategory(id, name) {
        const result = await Swal.fire({
            title: 'Delete Subcategory?',
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
                const response = await fetch('{{ route("api.seller.categories.delete") }}', {
                    method: 'POST',
                    headers: getCategoryAuthHeaders(),
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
                        text: data.message || 'Subcategory deleted successfully',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    loadCategories();
                } else {
                    const errorMsg = data.message || data.data?.message || 'Failed to delete subcategory';
                    const apiStatus = data.api_status ? ` (API Status: ${data.api_status})` : '';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: `<div>${escapeHtml(errorMsg)}${apiStatus}</div>${data.data ? '<pre style="text-align:left;font-size:0.8em;max-height:200px;overflow:auto;">' + escapeHtml(JSON.stringify(data.data, null, 2)) + '</pre>' : ''}`,
                        width: '600px'
                    });
                }
            } catch (error) {
                console.error('Error deleting subcategory:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the subcategory'
                });
            }
        }
    }

    // Handle subcategory form submission
    document.getElementById('subCategoryForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const parentSelect = document.getElementById('subCategoryParentId');
        const parentId = parseUuid(parentSelect?.value);

        const formData = {
            id: parseUuid(document.getElementById('subCategoryId').value) || null,
            name: document.getElementById('subCategoryName').value.trim(),
            parent_id: parentId || null,
            is_active: document.querySelector('#subCategoryForm input[name="is_active"]:checked').value === '1'
        };

        if (!formData.name) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Subcategory name is required'
            });
            return;
        }

        if (!formData.parent_id) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please select a parent category'
            });
            return;
        }

        try {
            const response = await fetch('{{ route("api.seller.categories.store") }}', {
                method: 'POST',
                headers: getCategoryAuthHeaders(),
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || (formData.id ? 'Subcategory updated successfully' : 'Subcategory created successfully'),
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                closeSubCategoryModal();
                loadCategories();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to save subcategory'
                });
            }
        } catch (error) {
            console.error('Error saving subcategory:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the subcategory'
            });
        }
    });

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

    // Close modals on outside click
    document.getElementById('categoryModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCategoryModal();
        }
    });

    document.getElementById('subCategoryModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeSubCategoryModal();
        }
    });
</script>
@endpush
@endsection
