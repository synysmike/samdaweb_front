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
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        <a href="{{ route('product.show', 1) }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-square">
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop" alt="Running Shoes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-1">Running Shoes</h3>
                <p class="text-gray-600 font-medium">$89.99</p>
            </div>
        </a>

        <a href="{{ route('product.show', 5) }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-square">
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop" alt="Classic Watch" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-1">Classic Watch</h3>
                <p class="text-gray-600 font-medium">$199.99</p>
            </div>
        </a>

        <a href="{{ route('product.show', 9) }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-square">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop" alt="Cotton T-Shirt" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-1">Cotton T-Shirt</h3>
                <p class="text-gray-600 font-medium">$24.99</p>
            </div>
        </a>

        <a href="{{ route('product.show', 13) }}" class="group bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="relative overflow-hidden aspect-square">
                <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop" alt="Leather Belt" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-1">Leather Belt</h3>
                <p class="text-gray-600 font-medium">$45.99</p>
            </div>
        </a>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(function() {
            let $slides = $('.banner-slide');
            let i = 0;
            setInterval(function() {
                $slides.eq(i).fadeOut(5000);
                i = (i + 1) % $slides.length;
                $slides.eq(i).fadeIn(5000);
            }, 6000);
        });
    </script>
@endpush
