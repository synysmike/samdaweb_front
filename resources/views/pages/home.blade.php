@extends('layouts.app')

@section('content')
<!-- Full-Width Banner with Slideshow -->
<div class="w-screen relative left-1/2 -ml-[50vw] mb-10">
    <div id="banner-slideshow" class="relative h-[42vh] overflow-hidden">
        <img src="https://www.insignia.com/wp-content/uploads/2024/05/Insignia-Luxury-Lifestyle-Hero-scaled.jpg"
            class="banner-slide absolute w-full h-full object-cover" style="display:block;">
        <img src="https://images.pexels.com/photos/1034940/pexels-photo-1034940.jpeg"
            class="banner-slide absolute w-full h-full object-cover" style="display:none;">
        <img src="https://media.istockphoto.com/id/2153823097/id/foto/pasangan-atletik-ceria-jogging-melalui-taman.jpg?s=612x612&w=0&k=20&c=a-m5-CokUaWQs_i8BGEryW-6RwCK8pkY-tWpvOvHhHo="
            class="banner-slide absolute w-full h-full object-cover" style="display:none;">
        <div class="absolute inset-0 bg-white/30 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to MyShop</h1>
                <p class="text-lg text-gray-700">Discover amazing products and shop with style</p>
            </div>
        </div>
    </div>
</div>

<!-- Categories -->
<h1 class="text-3xl font-bold mb-6">Shop by Category</h1>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10">
    <a href="/category/shoes" class="group relative overflow-hidden rounded-lg aspect-square shadow-md">
        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop"
            alt="Shoes" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
        <div class="absolute inset-0 bg-red-500/0 group-hover:bg-red-500/30 transition-all duration-300 flex items-center justify-center">
            <span class="text-white font-bold text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">Shoes</span>
        </div>
    </a>

    <a href="/category/watches" class="group relative overflow-hidden rounded-lg aspect-square shadow-md">
        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop"
            alt="Watches" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
        <div class="absolute inset-0 bg-green-500/0 group-hover:bg-green-500/30 transition-all duration-300 flex items-center justify-center">
            <span class="text-white font-bold text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">Watches</span>
        </div>
    </a>

    <a href="/category/shirts" class="group relative overflow-hidden rounded-lg aspect-square shadow-md">
        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop"
            alt="Shirts" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
        <div class="absolute inset-0 bg-yellow-500/0 group-hover:bg-yellow-500/30 transition-all duration-300 flex items-center justify-center">
            <span class="text-white font-bold text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">Shirts</span>
        </div>
    </a>

    <a href="/category/accessories" class="group relative overflow-hidden rounded-lg aspect-square shadow-md">
        <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop"
            alt="Accessories" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
        <div class="absolute inset-0 bg-purple-500/0 group-hover:bg-purple-500/30 transition-all duration-300 flex items-center justify-center">
            <span class="text-white font-bold text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">Accessories</span>
        </div>
    </a>
</div>

<!-- Featured Products -->
<h2 class="text-2xl font-bold mb-6">Featured Products</h2>
<div id="featured-products" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Product utilities
    const ProductUtils = {
        // Calculate original price from discount
        calculateOriginalPrice: function(price, discountPercent) {
            return price / (1 - (discountPercent / 100));
        },
        
        // Generate star rating HTML
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
        
        // Render product card
        renderProductCard: function(product, productUrl) {
            const discountPercent = product.discount || 25;
            const rating = product.rating || 4.5;
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
                            ${this.generateStarRating(rating)}
                            <span class="text-xs text-gray-500">(${rating.toFixed(1)})</span>
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
    
    // Load featured products (replace with your API call)
    $(function() {
        // Banner slideshow
        let $slides = $('.banner-slide');
        let i = 0;
        setInterval(function() {
            $slides.eq(i).fadeOut(5000);
            i = (i + 1) % $slides.length;
            $slides.eq(i).fadeIn(5000);
        }, 6000);
        
        // Example: Load products from API
        // Replace this with your actual API endpoint
        /*
        $.get('/api/featured-products', function(products) {
            const $container = $('#featured-products');
            $container.empty();
            products.forEach(function(product) {
                const productUrl = `/product/${product.id}`;
                $container.append(ProductUtils.renderProductCard(product, productUrl));
            });
            // Initialize wishlist state
            initWishlistState();
        });
        */
        
        // For demo purposes, using sample data
        const sampleProducts = [
            { id: 1, name: 'Running Shoes', price: 89.99, discount: 25, rating: 4.5, image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop' },
            { id: 5, name: 'Classic Watch', price: 199.99, discount: 20, rating: 4.8, image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop' },
            { id: 9, name: 'Cotton T-Shirt', price: 24.99, discount: 30, rating: 4.2, image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop' },
            { id: 13, name: 'Leather Belt', price: 45.99, discount: 15, rating: 4.6, image: 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop' }
        ];
        
        const $container = $('#featured-products');
        sampleProducts.forEach(function(product) {
            const productUrl = `/product/${product.id}`;
            $container.append(ProductUtils.renderProductCard(product, productUrl));
        });
        
        // Initialize wishlist state
        initWishlistState();
    });
    
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
</script>
@endpush