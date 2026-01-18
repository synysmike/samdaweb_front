<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products with pagination
     * Search queries are handled client-side via JavaScript/jQuery
     */
    public function index()
    {
        return view('public.pages.products');
    }

    /**
     * Display products by category
     */
    public function category($category)
    {
        $categoryName = ucfirst($category);
        
        // Sample products data - in a real app, this would come from a database
        $products = $this->getProductsByCategory($category);
        
        return view('public.pages.category', [
            'category' => $category,
            'categoryName' => $categoryName,
            'products' => $products
        ]);
    }

    /**
     * Display product details
     */
    public function show($id)
    {
        // Sample product data - in a real app, this would come from a database
        $product = $this->getProductById($id);
        
        if (!$product) {
            abort(404);
        }
        
        return view('public.pages.product-detail', [
            'product' => $product
        ]);
    }

    /**
     * Get products by category (sample data)
     */
    private function getProductsByCategory($category)
    {
        $allProducts = [
            'shoes' => [
                ['id' => 1, 'name' => 'Running Shoes', 'price' => 89.99, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop', 'description' => 'Comfortable running shoes for daily exercise'],
                ['id' => 2, 'name' => 'Casual Sneakers', 'price' => 59.99, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop', 'description' => 'Stylish casual sneakers'],
                ['id' => 3, 'name' => 'Basketball Shoes', 'price' => 129.99, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop', 'description' => 'High-performance basketball shoes'],
                ['id' => 4, 'name' => 'Hiking Boots', 'price' => 149.99, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop', 'description' => 'Durable hiking boots for outdoor adventures'],
            ],
            'watches' => [
                ['id' => 5, 'name' => 'Classic Watch', 'price' => 199.99, 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', 'description' => 'Elegant classic timepiece'],
                ['id' => 6, 'name' => 'Smart Watch', 'price' => 299.99, 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', 'description' => 'Feature-rich smartwatch'],
                ['id' => 7, 'name' => 'Sport Watch', 'price' => 159.99, 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', 'description' => 'Durable sports watch'],
                ['id' => 8, 'name' => 'Luxury Watch', 'price' => 599.99, 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', 'description' => 'Premium luxury watch'],
            ],
            'shirts' => [
                ['id' => 9, 'name' => 'Cotton T-Shirt', 'price' => 24.99, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 'description' => 'Comfortable cotton t-shirt'],
                ['id' => 10, 'name' => 'Polo Shirt', 'price' => 39.99, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 'description' => 'Classic polo shirt'],
                ['id' => 11, 'name' => 'Dress Shirt', 'price' => 49.99, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 'description' => 'Formal dress shirt'],
                ['id' => 12, 'name' => 'Casual Shirt', 'price' => 34.99, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 'description' => 'Relaxed fit casual shirt'],
            ],
            'accessories' => [
                ['id' => 13, 'name' => 'Leather Belt', 'price' => 45.99, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop', 'description' => 'Genuine leather belt'],
                ['id' => 14, 'name' => 'Sunglasses', 'price' => 79.99, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop', 'description' => 'UV protection sunglasses'],
                ['id' => 15, 'name' => 'Wallet', 'price' => 35.99, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop', 'description' => 'Slim design wallet'],
                ['id' => 16, 'name' => 'Backpack', 'price' => 89.99, 'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=500&h=500&fit=crop', 'description' => 'Durable travel backpack'],
            ],
        ];

        return $allProducts[$category] ?? [];
    }

    /**
     * Get product by ID (sample data)
     */
    private function getProductById($id)
    {
        $allProducts = [];
        foreach (['shoes', 'watches', 'shirts', 'accessories'] as $category) {
            $allProducts = array_merge($allProducts, $this->getProductsByCategory($category));
        }

        foreach ($allProducts as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }

        return null;
    }
}
