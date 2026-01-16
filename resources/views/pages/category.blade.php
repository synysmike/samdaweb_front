@extends('layouts.app')

@section('content')
<!-- Category Header -->
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-2">{{ $categoryName }}</h1>
    <p class="text-gray-600">Browse our collection of {{ strtolower($categoryName) }}</p>
</div>

<!-- Products Grid -->
@if(count($products) > 0)
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
    @foreach($products as $product)
    @php
    $discountPercent = $product['discount'] ?? 25;
    $originalPrice = $product['price'] / (1 - ($discountPercent / 100));
    @endphp
    <div class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
        <div class="relative overflow-hidden aspect-square">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-bold z-10">
                {{ $discountPercent }}% OFF
            </div>
            <button class="absolute top-2 right-2 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-red-50 transition-colors wishlist-btn" data-product-id="{{ $product['id'] }}" onclick="event.preventDefault(); toggleWishlist({{ $product['id'] }});">
                <svg class="w-5 h-5 text-gray-400 wishlist-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <a href="{{ route('product.show', $product['id']) }}">
                <h3 class="font-semibold text-gray-900 mb-1">{{ $product['name'] }}</h3>
            </a>
            <div class="flex items-center gap-1 mb-2">
                <div class="flex items-center star-rating" data-rating="{{ $product['rating'] ?? 4.5 }}">
                    @php
                    $rating = $product['rating'] ?? 4.5;
                    $fullStars = floor($rating);
                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <=$fullStars)
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>
                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545L10 15l-5.878-3.09 1.123-6.545L.489 6.91l6.572-.955L10 0z" />
                        </svg>
                        @else
                        <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                        @endif
                        @endfor
                </div>
                <span class="text-xs text-gray-500">({{ number_format($rating, 1) }})</span>
            </div>
            <div class="flex items-center gap-2">
                <p class="text-gray-400 font-medium line-through">${{ number_format($originalPrice, 2) }}</p>
                <p class="text-gray-900 font-bold">${{ number_format($product['price'], 2) }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-12">
    <p class="text-gray-600 text-lg">No products found in this category.</p>
</div>
@endif
@endsection