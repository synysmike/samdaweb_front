@extends('public.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
            <img id="product-image" src="" alt="" class="w-full h-auto object-cover">
            <div id="discount-badge" class="absolute top-4 left-4 bg-red-500 text-white px-3 py-2 rounded-md text-sm font-bold z-10"></div>
            <button id="wishlist-btn" class="absolute top-4 right-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-50 transition-colors wishlist-btn" onclick="toggleWishlist();">
                <svg class="w-6 h-6 text-gray-400 wishlist-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>

        <!-- Product Details -->
        <div>
            <h1 id="product-name" class="text-4xl font-bold mb-4"></h1>
            <div id="product-rating" class="flex items-center gap-2 mb-4"></div>
            <div id="product-price" class="flex items-center gap-3 mb-6"></div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Description</h2>
                <p id="product-description" class="text-gray-600"></p>
            </div>

            <div class="space-y-4">
                <button class="w-full bg-gray-900 text-white py-3 rounded-md hover:bg-gray-800 transition-colors text-lg font-medium">
                    Add to Cart
                </button>
            </div>

            

            <!-- Product Info -->
            <div class="mt-8 space-y-4">
                <div class="border-t pt-4">
                    <h3 class="font-semibold mb-2">Product Information</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>Free shipping on orders over $50</li>
                        <li>30-day return policy</li>
                        <li>Secure payment processing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Product utilities
    const ProductUtils = {
        calculateOriginalPrice: function(price, discountPercent) {
            return price / (1 - (discountPercent / 100));
        },

        generateStarRating: function(rating, size = 'w-5 h-5') {
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
            html += `<span class="text-sm text-gray-600 ml-2">(${rating.toFixed(1)})</span></div>`;
            return html;
        },

        renderProductDetail: function(product) {
            const discountPercent = product.discount || 25;
            const rating = product.rating || 4.5;
            const originalPrice = this.calculateOriginalPrice(product.price, discountPercent);

            $('#product-image').attr('src', product.image).attr('alt', product.name);
            $('#product-name').text(product.name);
            $('#product-description').text(product.description || 'No description available.');
            $('#discount-badge').text(`${discountPercent}% OFF`);
            $('#product-rating').html(this.generateStarRating(rating));
            $('#product-price').html(`
                <p class="text-2xl text-gray-400 font-medium line-through">$${originalPrice.toFixed(2)}</p>
                <p class="text-3xl font-bold text-gray-900">$${product.price.toFixed(2)}</p>
            `);

            // Set wishlist button data
            $('#wishlist-btn').attr('data-product-id', product.id);

            // Initialize wishlist state
            initWishlistState(product.id);
        }
    };

    let currentProductId = null;

    // Load product detail
    $(function() {
        const productId = window.location.pathname.split('/').pop();

        // Replace with your actual API endpoint
        /*
        $.get(`/api/product/${productId}`, function(response) {
            const product = response.data || response;
            ProductUtils.renderProductDetail(product);
        }).fail(function() {
            alert('Product not found');
        });
        */

        // For demo: Sample product data
        // Replace this with your API call
        const sampleProduct = {
            id: productId,
            name: 'Sample Product',
            price: 99.99,
            discount: 25,
            rating: 4.5,
            image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop',
            description: 'This is a sample product description.'
        };

        // Uncomment the API call above and remove this line when ready
        // ProductUtils.renderProductDetail(sampleProduct);
    });

    $('#wishlist-btn').on('click', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        if (productId && typeof window.toggleWishlist === 'function') {
            window.toggleWishlist(productId);
        }
    });

    function initWishlistState(productId) {
        const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        if (wishlist.includes(productId)) {
            const btn = $('#wishlist-btn');
            const icon = btn.find('.wishlist-icon');
            const path = icon.find('path');
            icon.removeClass('text-gray-400').addClass('active text-red-500');
            icon.attr('fill', 'currentColor');
            path.attr('stroke', 'none');
            btn.addClass('bg-red-50');
        }
    }
</script>
@endpush
@endsection