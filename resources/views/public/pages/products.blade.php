@extends('public.layouts.app')

@section('content')
<!-- Products Header -->
<div class="mb-8">
    <div id="header-all-products">
        <h1 class="text-4xl font-bold mb-2">All Products</h1>
        <p class="text-gray-600">Browse our complete collection of products</p>
    </div>
    <div id="header-search-results" class="hidden">
        <div class="flex items-center gap-3 mb-4">
            <a href="/products" class="text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-4xl font-bold mb-2">Search Results</h1>
        </div>
        <p class="text-gray-600">
            Showing results for: <span class="font-semibold text-gray-900" id="search-query-display"></span>
            <span id="search-results-count" class="ml-2"></span>
        </p>
    </div>
</div>

<!-- Filter and Sort Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <!-- Mobile Filter Toggle -->
    <button id="mobile-filter-toggle" class="md:hidden flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
        </svg>
        Filters
    </button>

    <!-- Sort Dropdown -->
    <div class="flex items-center gap-2">
        <label for="sort-select" class="text-gray-700 font-medium">Sort by:</label>
        <select id="sort-select" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="default">Default</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="rating-high">Rating: High to Low</option>
            <option value="rating-low">Rating: Low to High</option>
            <option value="name-asc">Name: A to Z</option>
            <option value="name-desc">Name: Z to A</option>
        </select>
    </div>
</div>

<!-- Main Content with Sidebar -->
<div class="flex flex-col lg:flex-row gap-6">
    <!-- Sidebar Filters -->
    <aside id="sidebar-filters" class="hidden lg:block w-full lg:w-64 flex-shrink-0 bg-white p-6 rounded-lg shadow-md h-fit sticky top-4">
        <!-- Mobile Close Button -->
        <div class="flex justify-between items-center mb-4 lg:hidden">
            <h2 class="text-xl font-bold">Filters</h2>
            <button id="close-sidebar" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Category Filter -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">Category</h3>
            <div class="space-y-2 max-h-48 overflow-y-auto">
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="all" checked>
                    <span>All Categories</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Shoes">
                    <span>Shoes</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Watches">
                    <span>Watches</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Shirts">
                    <span>Shirts</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Accessories">
                    <span>Accessories</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Electronics">
                    <span>Electronics</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Bags">
                    <span>Bags</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Jewelry">
                    <span>Jewelry</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="category-filter" value="Perfumes">
                    <span>Perfumes</span>
                </label>
            </div>
        </div>

        <!-- Price Filter -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">Price Range</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <input type="number" id="price-min" placeholder="Min" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0" step="0.01">
                    <span class="text-gray-500">-</span>
                    <input type="number" id="price-max" placeholder="Max" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" min="0" step="0.01">
                </div>
                <div class="flex gap-2">
                    <button id="apply-price" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">Apply</button>
                    <button id="reset-price" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">Reset</button>
                </div>
            </div>
        </div>

        <!-- Rating Filter -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">Rating</h3>
            <div class="space-y-2">
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="rating-filter" value="all" checked>
                    <span>All Ratings</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="rating-filter" value="4.5">
                    <span>
                        <span class="text-yellow-400">★★★★</span><span class="text-gray-300">★</span> 4.5 & above
                    </span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="rating-filter" value="4.0">
                    <span>
                        <span class="text-yellow-400">★★★★</span><span class="text-gray-300">★</span> 4.0 & above
                    </span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="rating-filter" value="3.5">
                    <span>
                        <span class="text-yellow-400">★★★</span><span class="text-gray-300">★★</span> 3.5 & above
                    </span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600">
                    <input type="checkbox" class="rating-filter" value="3.0">
                    <span>
                        <span class="text-yellow-400">★★★</span><span class="text-gray-300">★★</span> 3.0 & above
                    </span>
                </label>
            </div>
        </div>

        <!-- Clear All Filters -->
        <button id="clear-all-filters" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
            Clear All Filters
        </button>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

    <!-- Products Grid -->
    <div class="flex-1">
        <div id="products-count" class="mb-4 text-gray-600"></div>
        <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6"></div>
        
        <!-- No Results Message -->
        <div id="no-results" class="hidden text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
            <p class="text-gray-600 mb-4">
                @if(isset($searchQuery) && !empty($searchQuery))
                    Try adjusting your search terms or filters.
                @else
                    Try adjusting your filters.
                @endif
            </p>
            <button id="clear-filters-btn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Clear All Filters
            </button>
        </div>
    </div>
</div>

<!-- Loading Indicator -->
<div id="loading-indicator" class="text-center py-8 hidden">
    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
    <p class="mt-2 text-gray-600">Loading more products...</p>
</div>

<!-- End of Products Message -->
<div id="end-message" class="text-center py-8 hidden">
    <p class="text-gray-600 text-lg">You've reached the end of the products list.</p>
</div>

@push('js')
<style>
    /* Mobile sidebar styles */
    @media (max-width: 1023px) {
        #sidebar-filters.fixed {
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
    }
    
    /* Custom scrollbar for category filter */
    .space-y-2::-webkit-scrollbar {
        width: 6px;
    }
    
    .space-y-2::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .space-y-2::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .space-y-2::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Product utilities
    const ProductUtils = {
        calculateOriginalPrice: function(price, discountPercent) {
            return price / (1 - (discountPercent / 100));
        },
        
        generateStarRating: function(rating, size = 'w-4 h-4') {
            const fullStars = Math.floor(rating);
            const hasHalfStar = (rating - fullStars) >= 0.5;
            let html = '<div class="flex items-center">';
            
            for (let i = 1; i <= 5; i++) {
                if (i <= fullStars) {
                    html += `<svg class="${size} text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>`;
                } else if (i === fullStars + 1 && hasHalfStar) {
                    html += `<svg class="${size} text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545L10 15l-5.878-3.09 1.123-6.545L.489 6.91l6.572-.955L10 0z"/></svg>`;
                } else {
                    html += `<svg class="${size} text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>`;
                }
            }
            html += '</div>';
            return html;
        },
        
        renderProductCard: function(product, productUrl) {
            const discountPercent = product.discount || Math.floor(Math.random() * 30) + 15; // 15-45% discount
            const rating = product.rating || (Math.random() * 1.5 + 3.5).toFixed(1); // 3.5-5.0 rating
            const originalPrice = this.calculateOriginalPrice(product.price, discountPercent);
            const productId = product.id;
            
            return `
                <div class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
                    <div class="relative overflow-hidden aspect-square">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-bold z-10">
                            ${discountPercent}% OFF
                        </div>
                        <button class="absolute top-2 right-2 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-red-50 transition-colors wishlist-btn" data-product-id="${productId}" onclick="event.preventDefault(); toggleWishlist(${productId});">
                            <svg class="w-5 h-5 text-gray-400 wishlist-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <a href="${productUrl}">
                            <h3 class="font-semibold text-gray-900 mb-1">${product.name}</h3>
                        </a>
                        <div class="flex items-center gap-1 mb-2">
                            ${this.generateStarRating(parseFloat(rating))}
                            <span class="text-xs text-gray-500">(${rating})</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="text-gray-400 font-medium line-through">$${originalPrice.toFixed(2)}</p>
                            <p class="text-gray-900 font-bold">$${product.price.toFixed(2)}</p>
                        </div>
                    </div>
                </div>
            `;
        }
    };

    // Products simulation - 100 products
    const generateProducts = function() {
        const categories = [
            { name: 'Shoes', images: ['https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop'] },
            { name: 'Watches', images: ['https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop'] },
            { name: 'Shirts', images: ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop'] },
            { name: 'Accessories', images: ['https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop'] },
            { name: 'Electronics', images: ['https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop'] },
            { name: 'Bags', images: ['https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop'] },
            { name: 'Jewelry', images: ['https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=500&h=500&fit=crop'] },
            { name: 'Perfumes', images: ['https://images.unsplash.com/photo-1541643600914-78b084683601?w=500&h=500&fit=crop'] }
        ];

        const productTypes = {
            'Shoes': ['Running Shoes', 'Casual Sneakers', 'Basketball Shoes', 'Hiking Boots', 'Dress Shoes', 'Sandals', 'Boots', 'Trainers', 'Loafers', 'High Tops', 'Slip-ons', 'Athletic Shoes'],
            'Watches': ['Classic Watch', 'Smart Watch', 'Sport Watch', 'Luxury Watch', 'Digital Watch', 'Analog Watch', 'Chronograph', 'Diver Watch', 'Pilot Watch', 'Fashion Watch', 'Vintage Watch', 'Modern Watch'],
            'Shirts': ['Cotton T-Shirt', 'Polo Shirt', 'Dress Shirt', 'Casual Shirt', 'Button Down', 'Henley', 'Tank Top', 'Long Sleeve', 'Short Sleeve', 'V-Neck', 'Crew Neck', 'Hoodie'],
            'Accessories': ['Leather Belt', 'Sunglasses', 'Wallet', 'Backpack', 'Hat', 'Cap', 'Scarf', 'Gloves', 'Tie', 'Bracelet', 'Ring', 'Necklace'],
            'Electronics': ['Headphones', 'Speaker', 'Charger', 'Cable', 'Case', 'Stand', 'Adapter', 'Power Bank', 'Mouse', 'Keyboard', 'Webcam', 'Microphone'],
            'Bags': ['Handbag', 'Tote Bag', 'Backpack', 'Messenger Bag', 'Crossbody', 'Clutch', 'Duffel Bag', 'Travel Bag', 'Laptop Bag', 'Gym Bag', 'Shopping Bag', 'Briefcase'],
            'Jewelry': ['Ring', 'Necklace', 'Earrings', 'Bracelet', 'Anklet', 'Brooch', 'Cufflinks', 'Pendant', 'Chain', 'Charm', 'Locket', 'Bangle'],
            'Perfumes': ['Eau de Parfum', 'Eau de Toilette', 'Cologne', 'Body Spray', 'Aftershave', 'Fragrance Set', 'Travel Size', 'Gift Set', 'Limited Edition', 'Signature Scent', 'Floral', 'Woody']
        };

        const products = [];
        let id = 1;

        categories.forEach(category => {
            const types = productTypes[category.name] || [];
            const image = category.images[0];
            
            types.forEach((type, index) => {
                // Generate 12-13 products per category to reach ~100 total
                const basePrice = Math.random() * 200 + 20; // $20-$220
                const price = Math.round(basePrice * 100) / 100;
                
                products.push({
                    id: id++,
                    name: `${type} ${index + 1}`,
                    price: price,
                    image: image,
                    description: `Premium ${type.toLowerCase()} from our ${category.name.toLowerCase()} collection`,
                    category: category.name,
                    discount: Math.floor(Math.random() * 30) + 15, // 15-45%
                    rating: (Math.random() * 1.5 + 3.5).toFixed(1) // 3.5-5.0
                });
            });
        });

        // Fill remaining products to reach exactly 100
        while (products.length < 100) {
            const category = categories[Math.floor(Math.random() * categories.length)];
            const basePrice = Math.random() * 200 + 20;
            const price = Math.round(basePrice * 100) / 100;
            
            products.push({
                id: id++,
                name: `Premium Product ${products.length + 1}`,
                price: price,
                image: category.images[0],
                description: `High-quality product from our ${category.name.toLowerCase()} collection`,
                category: category.name,
                discount: Math.floor(Math.random() * 30) + 15,
                rating: (Math.random() * 1.5 + 3.5).toFixed(1)
            });
        }

        return products.slice(0, 100); // Ensure exactly 100 products
    };

    // Infinite scroll implementation
    let allProducts = [];
    let filteredProducts = [];
    let currentPage = 0;
    const itemsPerPage = 16;
    let isLoading = false;
    let hasMoreProducts = true;
    
    // Get URL parameters (for search query)
    // This processes the search query client-side, simulating how it will work with API later
    const getUrlParameter = function(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name) || '';
    };

    // Filter and sort state
    // All filtering and searching is done client-side (simulating API behavior)
    // When ready to use API, uncomment the fetchProductsFromAPI function below
    let filters = {
        categories: ['all'],
        priceMin: null,
        priceMax: null,
        ratings: ['all'],
        searchQuery: '' // Will be set from URL parameter on page load
    };
    let sortBy = 'default';

    // API Handler (commented out for later use)
    // This simulates how the search query and filters will be sent to the API
    /*
    const fetchProductsFromAPI = function(page, limit, filters, sortBy) {
        return $.ajax({
            url: '/api/products/search',
            method: 'POST', // Using POST for search queries (can handle larger payloads)
            data: JSON.stringify({
                page: page,
                limit: limit,
                search_query: filters.searchQuery, // Search query parameter
                categories: filters.categories,
                price_min: filters.priceMin,
                price_max: filters.priceMax,
                ratings: filters.ratings,
                sort_by: sortBy
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });
    };
    
    // Alternative GET method (if you prefer GET for search)
    /*
    const fetchProductsFromAPI = function(page, limit, filters, sortBy) {
        const params = new URLSearchParams({
            page: page,
            limit: limit,
            q: filters.searchQuery,
            categories: filters.categories.join(','),
            price_min: filters.priceMin || '',
            price_max: filters.priceMax || '',
            ratings: filters.ratings.join(','),
            sort_by: sortBy
        });
        
        return $.ajax({
            url: '/api/products?' + params.toString(),
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    };
    */

    // Apply filters to products
    const applyFilters = function(products) {
        let filtered = [...products];

        // Search query filter (searches in name and description)
        if (filters.searchQuery && filters.searchQuery.trim() !== '') {
            const searchTerm = filters.searchQuery.toLowerCase().trim();
            filtered = filtered.filter(product => {
                const nameMatch = product.name.toLowerCase().includes(searchTerm);
                const descMatch = product.description.toLowerCase().includes(searchTerm);
                const categoryMatch = product.category.toLowerCase().includes(searchTerm);
                return nameMatch || descMatch || categoryMatch;
            });
        }

        // Category filter
        if (!filters.categories.includes('all') && filters.categories.length > 0) {
            filtered = filtered.filter(product => filters.categories.includes(product.category));
        }

        // Price filter
        if (filters.priceMin !== null && filters.priceMin !== '') {
            filtered = filtered.filter(product => product.price >= parseFloat(filters.priceMin));
        }
        if (filters.priceMax !== null && filters.priceMax !== '') {
            filtered = filtered.filter(product => product.price <= parseFloat(filters.priceMax));
        }

        // Rating filter
        if (!filters.ratings.includes('all') && filters.ratings.length > 0) {
            filtered = filtered.filter(product => {
                const rating = parseFloat(product.rating);
                return filters.ratings.some(filterRating => rating >= parseFloat(filterRating));
            });
        }

        return filtered;
    };

    // Apply sorting to products
    const applySorting = function(products) {
        const sorted = [...products];
        
        switch(sortBy) {
            case 'price-low':
                sorted.sort((a, b) => a.price - b.price);
                break;
            case 'price-high':
                sorted.sort((a, b) => b.price - a.price);
                break;
            case 'rating-high':
                sorted.sort((a, b) => parseFloat(b.rating) - parseFloat(a.rating));
                break;
            case 'rating-low':
                sorted.sort((a, b) => parseFloat(a.rating) - parseFloat(b.rating));
                break;
            case 'name-asc':
                sorted.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case 'name-desc':
                sorted.sort((a, b) => b.name.localeCompare(a.name));
                break;
            default:
                // Default: keep original order
                break;
        }
        
        return sorted;
    };

    // Update header based on search query
    const updateHeader = function() {
        if (filters.searchQuery && filters.searchQuery.trim() !== '') {
            $('#header-all-products').addClass('hidden');
            $('#header-search-results').removeClass('hidden');
            $('#search-query-display').text(`"${filters.searchQuery}"`);
        } else {
            $('#header-all-products').removeClass('hidden');
            $('#header-search-results').addClass('hidden');
        }
    };

    // Refresh products based on filters and sorting
    const refreshProducts = function() {
        // Reset pagination
        currentPage = 0;
        hasMoreProducts = true;
        $('#products-grid').empty();
        $('#end-message').addClass('hidden');
        $('#no-results').addClass('hidden');
        
        // Apply filters and sorting
        filteredProducts = applyFilters(allProducts);
        filteredProducts = applySorting(filteredProducts);
        
        // Update header
        updateHeader();
        
        // Check if no results
        if (filteredProducts.length === 0) {
            $('#products-count').text('');
            $('#no-results').removeClass('hidden');
            return;
        }
        
        // Update product count
        const count = filteredProducts.length;
        const displayCount = Math.min(count, itemsPerPage);
        $('#products-count').text(`Showing ${displayCount} of ${count} products`);
        
        // Update search results count if in search mode
        if (filters.searchQuery && filters.searchQuery.trim() !== '') {
            $('#search-results-count').text(`(${count} ${count === 1 ? 'result' : 'results'})`);
        }
        
        // Load first page
        loadProducts();
    };

    // Load products (simulation mode)
    const loadProducts = function() {
        if (isLoading || !hasMoreProducts) return;
        
        isLoading = true;
        $('#loading-indicator').removeClass('hidden');

        // Simulate API delay
        setTimeout(function() {
            const startIndex = currentPage * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const productsToShow = filteredProducts.slice(startIndex, endIndex);

            if (productsToShow.length === 0) {
                hasMoreProducts = false;
                $('#loading-indicator').addClass('hidden');
                $('#end-message').removeClass('hidden');
                isLoading = false;
                return;
            }

            const $grid = $('#products-grid');
            productsToShow.forEach(function(product) {
                const productUrl = `/product/${product.id}`;
                $grid.append(ProductUtils.renderProductCard(product, productUrl));
            });

            // Initialize wishlist state for new products
            initWishlistState();

            currentPage++;
            
            // Update product count
            const displayed = Math.min(endIndex, filteredProducts.length);
            $('#products-count').text(`Showing ${displayed} of ${filteredProducts.length} products`);
            
            // Check if we've loaded all products
            if (endIndex >= filteredProducts.length) {
                hasMoreProducts = false;
                $('#end-message').removeClass('hidden');
            }

            $('#loading-indicator').addClass('hidden');
            isLoading = false;
        }, 500); // Simulate 500ms API delay
    };

    // API Handler version (commented out for later use)
    // This shows how to load products from API with search query and filters
    /*
    const loadProductsFromAPI = function() {
        if (isLoading || !hasMoreProducts) return;
        
        isLoading = true;
        $('#loading-indicator').removeClass('hidden');

        // Pass current filters (including searchQuery) and sortBy to API
        fetchProductsFromAPI(currentPage + 1, itemsPerPage, filters, sortBy)
            .done(function(response) {
                const products = response.data || response.products || [];
                
                if (products.length === 0) {
                    hasMoreProducts = false;
                    $('#loading-indicator').addClass('hidden');
                    $('#end-message').removeClass('hidden');
                    isLoading = false;
                    return;
                }

                const $grid = $('#products-grid');
                products.forEach(function(product) {
                    const productUrl = `/product/${product.id}`;
                    $grid.append(ProductUtils.renderProductCard(product, productUrl));
                });

                initWishlistState();

                currentPage++;
                
                // Check if there are more products
                if (products.length < itemsPerPage || !response.has_more) {
                    hasMoreProducts = false;
                    $('#end-message').removeClass('hidden');
                }

                $('#loading-indicator').addClass('hidden');
                isLoading = false;
            })
            .fail(function() {
                $('#loading-indicator').addClass('hidden');
                isLoading = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load products. Please try again.',
                    confirmButtonColor: '#3085d6'
                });
            });
    };
    
    // To use API instead of client-side filtering:
    // 1. Uncomment fetchProductsFromAPI and loadProductsFromAPI functions above
    // 2. Replace refreshProducts() to call loadProductsFromAPI() instead of loadProducts()
    // 3. Remove client-side filtering logic (applyFilters function) or keep it as fallback
    */

    // Scroll event handler
    $(window).on('scroll', function() {
        const scrollTop = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();
        
        // Load more when user is 200px from bottom
        if (scrollTop + windowHeight >= documentHeight - 200) {
            loadProducts();
        }
    });

    // Initialize wishlist state
    function initWishlistState() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        wishlist.forEach(function(productId) {
            const btn = document.querySelector(`.wishlist-btn[data-product-id="${productId}"]`);
            if (btn) {
                const icon = btn.querySelector('.wishlist-icon');
                const path = icon.querySelector('path');
                icon.classList.remove('text-gray-400');
                icon.classList.add('active', 'text-red-500');
                icon.setAttribute('fill', 'currentColor');
                path.setAttribute('stroke', 'none');
                btn.classList.add('bg-red-50');
            }
        });
    }

    // Mobile sidebar toggle
    $('#mobile-filter-toggle').on('click', function() {
        $('#sidebar-filters').removeClass('hidden').addClass('fixed inset-y-0 left-0 z-50 w-64 overflow-y-auto');
        $('#mobile-sidebar-overlay').removeClass('hidden');
    });

    $('#close-sidebar').on('click', function() {
        $('#sidebar-filters').removeClass('fixed inset-y-0 left-0 z-50 w-64 overflow-y-auto').addClass('hidden');
        $('#mobile-sidebar-overlay').addClass('hidden');
    });

    $('#mobile-sidebar-overlay').on('click', function() {
        $('#sidebar-filters').removeClass('fixed inset-y-0 left-0 z-50 w-64 overflow-y-auto').addClass('hidden');
        $(this).addClass('hidden');
    });

    // Prevent sidebar from closing when clicking inside
    $('#sidebar-filters').on('click', function(e) {
        e.stopPropagation();
    });

    // Category filter handlers
    $('.category-filter').on('change', function() {
        const value = $(this).val();
        const isChecked = $(this).is(':checked');
        
        if (value === 'all') {
            if (isChecked) {
                $('.category-filter').not(this).prop('checked', false);
                filters.categories = ['all'];
            }
        } else {
            $('.category-filter[value="all"]').prop('checked', false);
            if (isChecked) {
                if (!filters.categories.includes(value)) {
                    filters.categories.push(value);
                }
            } else {
                filters.categories = filters.categories.filter(cat => cat !== value);
                if (filters.categories.length === 0) {
                    filters.categories = ['all'];
                    $('.category-filter[value="all"]').prop('checked', true);
                }
            }
        }
        
        refreshProducts();
    });

    // Price filter handlers
    $('#apply-price').on('click', function() {
        filters.priceMin = $('#price-min').val();
        filters.priceMax = $('#price-max').val();
        refreshProducts();
    });

    $('#reset-price').on('click', function() {
        $('#price-min').val('');
        $('#price-max').val('');
        filters.priceMin = null;
        filters.priceMax = null;
        refreshProducts();
    });

    // Rating filter handlers
    $('.rating-filter').on('change', function() {
        const value = $(this).val();
        const isChecked = $(this).is(':checked');
        
        if (value === 'all') {
            if (isChecked) {
                $('.rating-filter').not(this).prop('checked', false);
                filters.ratings = ['all'];
            }
        } else {
            $('.rating-filter[value="all"]').prop('checked', false);
            if (isChecked) {
                if (!filters.ratings.includes(value)) {
                    filters.ratings.push(value);
                }
            } else {
                filters.ratings = filters.ratings.filter(rating => rating !== value);
                if (filters.ratings.length === 0) {
                    filters.ratings = ['all'];
                    $('.rating-filter[value="all"]').prop('checked', true);
                }
            }
        }
        
        refreshProducts();
    });

    // Sort handler
    $('#sort-select').on('change', function() {
        sortBy = $(this).val();
        refreshProducts();
    });

    // Clear all filters button (in sidebar)
    $('#clear-all-filters').on('click', function() {
        clearAllFilters();
    });

    // Clear all filters button (in no results message)
    $('#clear-filters-btn').on('click', function() {
        clearAllFilters();
    });

    // Clear all filters function
    const clearAllFilters = function() {
        // Reset category filters
        $('.category-filter[value="all"]').prop('checked', true);
        $('.category-filter').not('[value="all"]').prop('checked', false);
        filters.categories = ['all'];
        
        // Reset price filters
        $('#price-min').val('');
        $('#price-max').val('');
        filters.priceMin = null;
        filters.priceMax = null;
        
        // Reset rating filters
        $('.rating-filter[value="all"]').prop('checked', true);
        $('.rating-filter').not('[value="all"]').prop('checked', false);
        filters.ratings = ['all'];
        
        // Reset sort
        $('#sort-select').val('default');
        sortBy = 'default';
        
        // Note: Search query is preserved (user can navigate back to clear it)
        
        refreshProducts();
    };

    // Initialize page
    $(function() {
        // Get search query from URL parameter
        filters.searchQuery = getUrlParameter('q') || '';
        
        // Generate 100 products
        allProducts = generateProducts();
        filteredProducts = [...allProducts];
        
        // Load initial 16 products
        refreshProducts();
        
        // Initialize wishlist state
        initWishlistState();
        
        // Listen for URL changes (for browser back/forward buttons)
        $(window).on('popstate', function() {
            filters.searchQuery = getUrlParameter('q') || '';
            refreshProducts();
        });
    });
</script>
@endpush
@endsection
