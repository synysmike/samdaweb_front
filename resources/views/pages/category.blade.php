@extends('layouts.app')

@section('content')
<!-- Category Header -->
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-2">{{ $categoryName }}</h1>
    <p class="text-gray-600">Browse our collection of {{ strtolower($categoryName) }}</p>
</div>

<!-- Products Grid -->
<div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6"></div>
<div id="products-empty" class="text-center py-12 hidden">
    <p class="text-gray-600 text-lg">No products found in this category.</p>
</div>
@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Product utilities (shared with home page)
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
    
    // Load category products
    $(function() {
        const categorySlug = window.location.pathname.split('/').pop();
        
        // Replace with your actual API endpoint
        /*
        $.get(`/api/category/${categorySlug}/products`, function(response) {
            const products = response.data || response;
            const $grid = $('#products-grid');
            const $empty = $('#products-empty');
            
            if (products.length === 0) {
                $grid.hide();
                $empty.removeClass('hidden');
            } else {
                $empty.addClass('hidden');
                $grid.empty();
                products.forEach(function(product) {
                    const productUrl = `/product/${product.id}`;
                    $grid.append(ProductUtils.renderProductCard(product, productUrl));
                });
                initWishlistState();
            }
        }).fail(function() {
            $('#products-grid').hide();
            $('#products-empty').removeClass('hidden');
        });
        */
        
        // For demo: Initialize wishlist state
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
@endsection