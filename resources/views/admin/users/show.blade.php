@extends('admin.layouts.app')

@section('title', 'User Detail - Seller Management')
@section('page-title', 'User Detail - Seller Management')

@section('content')
<div class="space-y-6">
    <!-- User Info Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <div id="userAvatar" class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-2xl">
                    <!-- Avatar will be populated -->
                </div>
                <div>
                    <h3 id="userName" class="text-2xl font-bold text-gray-900"></h3>
                    <p id="userEmail" class="text-gray-600 mt-1"></p>
                    <div class="flex items-center gap-2 mt-2">
                        <span id="userRole" class="px-2 py-1 text-xs font-semibold rounded-full"></span>
                        <span id="userStatus" class="px-2 py-1 text-xs font-semibold rounded-full"></span>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>
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
                    <p class="text-sm text-gray-600">Total Sales</p>
                    <p id="totalSales" class="text-3xl font-bold text-purple-600 mt-2">0</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Revenue</p>
                    <p id="totalRevenue" class="text-3xl font-bold text-orange-600 mt-2">$0</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Selling Progress Chart -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h4 class="text-lg font-semibold text-gray-900">Selling Progress</h4>
            <select id="progressPeriod" class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="7">Last 7 Days</option>
                <option value="30" selected>Last 30 Days</option>
                <option value="90">Last 90 Days</option>
                <option value="365">Last Year</option>
            </select>
        </div>
        <div class="h-64 flex items-end justify-between gap-2" id="progressChart">
            <!-- Chart bars will be generated by JavaScript -->
        </div>
    </div>

    <!-- Product Categories Management -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h4 class="text-lg font-semibold text-gray-900">Product Categories</h4>
                <p class="text-sm text-gray-600 mt-1">Manage categories and their product counts</p>
            </div>
            <button onclick="openAddCategoryModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Category
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoriesTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Categories will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Products List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h4 class="text-lg font-semibold text-gray-900">Products List</h4>
                <p class="text-sm text-gray-600 mt-1">All products from this seller</p>
            </div>
            <input type="text" id="productSearch" placeholder="Search products..." class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Products will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeCategoryModalOnBackdrop(event)">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6 border-b border-gray-200">
                <h3 id="categoryModalTitle" class="text-lg font-semibold text-gray-900">Add Category</h3>
            </div>
            <form id="categoryForm" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" id="categoryName" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="categoryStatus" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const userId = {{ $userId }};
    
    // Mock data untuk simulasi (frontend only)
    const userData = {
        1: {
            id: 1,
            name: 'John Doe',
            email: 'john.doe@example.com',
            role: 'admin',
            status: 'active',
            phone: '+1 (555) 123-4567',
            address: '123 Main Street, New York, NY 10001',
            totalProducts: 45,
            activeProducts: 38,
            totalSales: 234,
            totalRevenue: 45678.90,
            joinDate: '2020-01-15'
        },
        2: {
            id: 2,
            name: 'Jane Smith',
            email: 'jane.smith@example.com',
            role: 'manager',
            status: 'active',
            phone: '+1 (555) 234-5678',
            address: '456 Oak Avenue, Los Angeles, CA 90001',
            totalProducts: 32,
            activeProducts: 28,
            totalSales: 189,
            totalRevenue: 32156.78,
            joinDate: '2019-06-20'
        }
    };

    const categoriesData = {
        1: [
            { id: 1, name: 'Electronics', productCount: 15, status: 'active' },
            { id: 2, name: 'Clothing', productCount: 12, status: 'active' },
            { id: 3, name: 'Home & Garden', productCount: 10, status: 'active' },
            { id: 4, name: 'Sports', productCount: 8, status: 'active' }
        ],
        2: [
            { id: 1, name: 'Fashion', productCount: 18, status: 'active' },
            { id: 2, name: 'Accessories', productCount: 8, status: 'active' },
            { id: 3, name: 'Beauty', productCount: 6, status: 'active' }
        ]
    };

    const productsData = {
        1: [
            { id: 1, name: 'Wireless Headphones', category: 'Electronics', price: 99.99, stock: 45, sales: 234, status: 'active' },
            { id: 2, name: 'Smart Watch', category: 'Electronics', price: 299.99, stock: 23, sales: 156, status: 'active' },
            { id: 3, name: 'Cotton T-Shirt', category: 'Clothing', price: 19.99, stock: 120, sales: 456, status: 'active' },
            { id: 4, name: 'Garden Tools Set', category: 'Home & Garden', price: 79.99, stock: 34, sales: 89, status: 'active' },
            { id: 5, name: 'Running Shoes', category: 'Sports', price: 129.99, stock: 56, sales: 234, status: 'active' }
        ],
        2: [
            { id: 1, name: 'Designer Handbag', category: 'Fashion', price: 199.99, stock: 12, sales: 45, status: 'active' },
            { id: 2, name: 'Leather Wallet', category: 'Accessories', price: 49.99, stock: 78, sales: 123, status: 'active' },
            { id: 3, name: 'Face Cream', category: 'Beauty', price: 29.99, stock: 90, sales: 234, status: 'active' }
        ]
    };

    const salesProgressData = {
        1: {
            7: [12, 15, 18, 14, 20, 22, 19],
            30: [45, 52, 48, 55, 60, 58, 62, 59, 65, 68, 70, 72, 75, 78, 80, 82, 85, 88, 90, 92, 95, 98, 100, 102, 105, 108, 110, 112, 115, 118],
            90: [120, 125, 130, 135, 140, 145, 150, 155, 160, 165, 170, 175, 180, 185, 190, 195, 200, 205, 210, 215, 220, 225, 230, 234],
            365: Array.from({length: 12}, (_, i) => 20 + i * 18)
        },
        2: {
            7: [8, 10, 12, 9, 11, 13, 15],
            30: [30, 35, 32, 38, 40, 42, 45, 48, 50, 52, 55, 58, 60, 62, 65, 68, 70, 72, 75, 78, 80, 82, 85, 88, 90, 92, 95, 98, 100, 102],
            90: [100, 105, 110, 115, 120, 125, 130, 135, 140, 145, 150, 155, 160, 165, 170, 175, 180, 185, 189],
            365: Array.from({length: 12}, (_, i) => 15 + i * 14)
        }
    };

    let currentUser = userData[userId] || userData[1];
    let currentCategories = categoriesData[userId] || categoriesData[1];
    let currentProducts = productsData[userId] || productsData[1];
    let currentCategoryEditId = null;

    // Initialize page
    $(document).ready(function() {
        loadUserInfo();
        loadStatistics();
        loadCategories();
        loadProducts();
        loadSalesProgress(30);
    });

    function loadUserInfo() {
        const initials = currentUser.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        $('#userAvatar').html(initials);
        $('#userName').text(currentUser.name);
        $('#userEmail').text(currentUser.email);
        
        const roleColors = {
            'admin': 'bg-red-100 text-red-800',
            'manager': 'bg-blue-100 text-blue-800',
            'editor': 'bg-green-100 text-green-800',
            'user': 'bg-gray-100 text-gray-800'
        };
        const roleColorClass = roleColors[currentUser.role] || 'bg-gray-100 text-gray-800';
        $('#userRole').attr('class', `px-2 py-1 text-xs font-semibold rounded-full ${roleColorClass}`).text(currentUser.role.charAt(0).toUpperCase() + currentUser.role.slice(1));
        
        const statusColors = {
            'active': 'bg-green-100 text-green-800',
            'inactive': 'bg-gray-100 text-gray-800',
            'suspended': 'bg-red-100 text-red-800'
        };
        const statusColorClass = statusColors[currentUser.status] || 'bg-gray-100 text-gray-800';
        $('#userStatus').attr('class', `px-2 py-1 text-xs font-semibold rounded-full ${statusColorClass}`).text(currentUser.status.charAt(0).toUpperCase() + currentUser.status.slice(1));
    }

    function loadStatistics() {
        $('#totalProducts').text(currentUser.totalProducts);
        $('#activeProducts').text(currentUser.activeProducts);
        $('#totalSales').text(currentUser.totalSales);
        $('#totalRevenue').text('$' + currentUser.totalRevenue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }

    function loadCategories() {
        const tbody = $('#categoriesTableBody');
        tbody.empty();
        
        currentCategories.forEach(category => {
            const statusColor = category.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
            const row = `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-medium text-gray-900">${category.name}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-900">${category.productCount}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusColor}">${category.status.charAt(0).toUpperCase() + category.status.slice(1)}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                            <button onclick="editCategory(${category.id})" class="text-blue-600 hover:text-blue-900">Edit</button>
                            <button onclick="deleteCategory(${category.id})" class="text-red-600 hover:text-red-900">Delete</button>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    function loadProducts() {
        const tbody = $('#productsTableBody');
        tbody.empty();
        
        currentProducts.forEach(product => {
            const statusColor = product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800';
            const row = `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-medium text-gray-900">${product.name}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-600">${product.category}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-900">$${product.price.toFixed(2)}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-900">${product.stock}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-900">${product.sales}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusColor}">${product.status.charAt(0).toUpperCase() + product.status.slice(1)}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="viewProduct(${product.id})" class="text-blue-600 hover:text-blue-900">View</button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    function loadSalesProgress(days) {
        const data = salesProgressData[userId]?.[days] || salesProgressData[1][days];
        if (!data) return;
        
        const maxValue = Math.max(...data);
        const chart = $('#progressChart');
        chart.empty();
        
        const barCount = data.length;
        const barWidth = Math.max(20, (100 / barCount) - 2);
        
        data.forEach((value, index) => {
            const height = (value / maxValue) * 100;
            const bar = $(`
                <div class="flex flex-col items-center gap-1" style="flex: 1; max-width: ${barWidth}%">
                    <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition-colors cursor-pointer" style="height: ${height}%" title="Day ${index + 1}: ${value} sales"></div>
                    <span class="text-xs text-gray-500">${index + 1}</span>
                </div>
            `);
            chart.append(bar);
        });
    }

    $('#progressPeriod').on('change', function() {
        loadSalesProgress(parseInt($(this).val()));
    });

    $('#productSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('#productsTableBody tr').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(searchTerm));
        });
    });

    function openAddCategoryModal() {
        currentCategoryEditId = null;
        $('#categoryModalTitle').text('Add Category');
        $('#categoryForm')[0].reset();
        $('#categoryModal').removeClass('hidden');
    }

    function editCategory(id) {
        const category = currentCategories.find(c => c.id === id);
        if (!category) return;
        
        currentCategoryEditId = id;
        $('#categoryModalTitle').text('Edit Category');
        $('#categoryName').val(category.name);
        $('#categoryStatus').val(category.status);
        $('#categoryModal').removeClass('hidden');
    }

    function deleteCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this category?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                currentCategories = currentCategories.filter(c => c.id !== id);
                loadCategories();
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Category deleted successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    function closeCategoryModal() {
        $('#categoryModal').addClass('hidden');
        currentCategoryEditId = null;
        $('#categoryForm')[0].reset();
    }

    function closeCategoryModalOnBackdrop(event) {
        if (event.target.id === 'categoryModal') {
            closeCategoryModal();
        }
    }

    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            name: $('#categoryName').val(),
            status: $('#categoryStatus').val()
        };

        if (currentCategoryEditId) {
            const categoryIndex = currentCategories.findIndex(c => c.id === currentCategoryEditId);
            if (categoryIndex !== -1) {
                currentCategories[categoryIndex] = {
                    ...currentCategories[categoryIndex],
                    name: formData.name,
                    status: formData.status
                };
                loadCategories();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category updated successfully!',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        } else {
            const newCategory = {
                id: Math.max(...currentCategories.map(c => c.id)) + 1,
                name: formData.name,
                productCount: 0,
                status: formData.status
            };
            currentCategories.push(newCategory);
            loadCategories();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Category created successfully!',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }

        closeCategoryModal();
    });

    function viewProduct(id) {
        Swal.fire({
            icon: 'info',
            title: 'Product Detail',
            text: 'View product detail: ' + id,
            confirmButtonColor: '#3085d6'
        });
    }
</script>
@endpush

@endsection
