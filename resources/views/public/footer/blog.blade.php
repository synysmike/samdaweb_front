@extends('public.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold mb-6">Blog</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400&h=250&fit=crop" alt="Blog post" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-sm text-gray-500">January 15, 2024</span>
                <h2 class="text-xl font-semibold mt-2 mb-2">Welcome to Our New Platform</h2>
                <p class="text-gray-600 mb-4">We're excited to introduce our new and improved shopping experience...</p>
                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Read more →</a>
            </div>
        </article>
        
        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=250&fit=crop" alt="Blog post" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-sm text-gray-500">January 10, 2024</span>
                <h2 class="text-xl font-semibold mt-2 mb-2">Shopping Tips and Tricks</h2>
                <p class="text-gray-600 mb-4">Discover how to make the most of your shopping experience with our expert tips...</p>
                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Read more →</a>
            </div>
        </article>
        
        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&h=250&fit=crop" alt="Blog post" class="w-full h-48 object-cover">
            <div class="p-6">
                <span class="text-sm text-gray-500">January 5, 2024</span>
                <h2 class="text-xl font-semibold mt-2 mb-2">New Year, New Products</h2>
                <p class="text-gray-600 mb-4">Explore our latest collection of products for the new year...</p>
                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Read more →</a>
            </div>
        </article>
    </div>
</div>
@endsection
