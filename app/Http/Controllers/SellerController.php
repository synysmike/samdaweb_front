<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SellerController extends Controller
{
    /**
     * Check if user has a shop account
     */
    private function checkShop()
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get(config('api.base_url') . config('api.endpoints.shop.get'));

            if ($response->successful()) {
                $responseData = $response->json();
                return $responseData['data'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Error checking shop: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Show shop registration page
     */
    public function registerShop()
    {
        $shop = $this->checkShop();

        // If shop already exists, redirect to dashboard
        if ($shop) {
            return redirect()->route('seller.index');
        }

        return view('public.seller.register-shop');
    }

    /**
     * Show the seller dashboard
     */
    public function index()
    {
        $shop = $this->checkShop();

        // If no shop, redirect to registration
        if (!$shop) {
            return redirect()->route('seller.register-shop');
        }

        return view('public.seller.dashboard');
    }

    /**
     * Show the categories page
     */
    public function categories()
    {
        $shop = $this->checkShop();

        // If no shop, redirect to registration
        if (!$shop) {
            return redirect()->route('seller.register-shop');
        }

        return view('public.seller.categories');
    }

    /**
     * Show the products page
     */
    public function products()
    {
        $shop = $this->checkShop();

        // If no shop, redirect to registration
        if (!$shop) {
            return redirect()->route('seller.register-shop');
        }

        return view('public.seller.products', ['shop' => $shop]);
    }

    /**
     * Show the shop profile page
     */
    public function shopProfile()
    {
        $shop = $this->checkShop();

        // If no shop, redirect to registration
        if (!$shop) {
            return redirect()->route('seller.register-shop');
        }

        return view('public.seller.shop-profile');
    }

    /**
     * Get shop information
     */
    public function getShop()
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get(config('api.base_url') . config('api.endpoints.shop.get'));

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch shop information',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error fetching shop: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching shop: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store shop information
     */
    public function storeShop(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        try {
            $data = $request->all();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.shop.store'), $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save shop information',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error saving shop: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving shop: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all product categories
     */
    public function getCategories()
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for getCategories', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_category.index');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Log API error for debugging
            Log::warning('API error fetching categories', [
                'status_code' => $statusCode,
                'response_data' => $responseData,
            ]);

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch categories',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching categories: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update a product category
     */
    public function storeCategory(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for storeCategory', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body - handle both JSON and form data
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            // Try to parse JSON from raw content
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'nullable|string',
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        try {
            $data = [
                'name' => (string) $request->input('name'),
                'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
            ];
            $id = $request->input('id');
            if ($id !== null && $id !== '') {
                $data['id'] = (string) $id;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.product_category.store'), $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save category',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error saving category: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product category
     */
    public function deleteCategory(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        // Log for debugging
        Log::info('Delete category request', [
            'has_token' => !empty($token),
            'token_length' => $token ? strlen($token) : 0,
            'session_id' => session()->getId(),
            'request_id' => $request->input('id'),
        ]);

        if (!$token) {
            Log::warning('No token found in session', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body - handle both JSON and form data
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            // Try to parse JSON from raw content
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'required|string',
        ]);

        try {
            $data = [
                'id' => $request->input('id'),
            ];

            $apiUrl = config('api.base_url') . config('api.endpoints.product_category.delete');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $data);

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to delete category',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error deleting category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all product subcategories
     */
    public function getSubCategories()
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for getSubCategories', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_sub_category.index');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Log API error for debugging
            Log::warning('API error fetching subcategories', [
                'status_code' => $statusCode,
                'response_data' => $responseData,
            ]);

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch subcategories',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error fetching subcategories: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching subcategories: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update a product subcategory
     */
    public function storeSubCategory(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for storeSubCategory', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body - handle both JSON and form data
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            // Try to parse JSON from raw content
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'nullable|string',
            'name' => 'required|string|max:255',
            'category_id' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        try {
            $data = [
                'name' => (string) $request->input('name'),
                'category_id' => (string) $request->input('category_id'),
                'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
            ];
            $id = $request->input('id');
            if ($id !== null && $id !== '') {
                $data['id'] = (string) $id;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.product_sub_category.store'), $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save subcategory',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error saving subcategory: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving subcategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product subcategory
     */
    public function deleteSubCategory(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for deleteSubCategory', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body - handle both JSON and form data
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            // Try to parse JSON from raw content
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'required|string',
        ]);

        try {
            $data = [
                'id' => $request->input('id'),
            ];

            $apiUrl = config('api.base_url') . config('api.endpoints.product_sub_category.delete');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $data);

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to delete subcategory',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error deleting subcategory: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error deleting subcategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all products
     */
    public function getProducts()
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for getProducts', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product.index');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Log API error for debugging
            Log::warning('API error fetching products', [
                'status_code' => $statusCode,
                'response_data' => $responseData,
            ]);

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch products',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update a product
     * API expects: id?, title, description, category_id, sub_category_id, is_active, is_visible,
     * stock, sku, price, discount_price, country_id, state_id, city_id
     */
    public function storeProduct(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for storeProduct', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body - handle both JSON and form data
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        try {
            $id = $request->input('id');
            $id = ($id === '' || $id === null) ? null : (string) $id;

            $data = [
                'title' => (string) ($request->input('title') ?? ''),
                'description' => (string) ($request->input('description') ?? ''),
                'category_id' => (string) ($request->input('category_id') ?? ''),
                'sub_category_id' => (string) ($request->input('sub_category_id') ?? ''),
                'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
                'is_visible' => filter_var($request->input('is_visible'), FILTER_VALIDATE_BOOLEAN),
                'stock' => (int) ($request->input('stock') ?? 0),
                'sku' => (string) ($request->input('sku') ?? ''),
                'price' => (float) ($request->input('price') ?? 0),
                'discount_price' => (float) ($request->input('discount_price') ?? 0),
                'country_id' => (int) ($request->input('country_id') ?? 0),
                'state_id' => (int) ($request->input('state_id') ?? 0),
                'city_id' => (int) ($request->input('city_id') ?? 0),
            ];
            if ($id !== null) {
                $data['id'] = $id;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.product.store'), $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save product',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error saving product: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store product image
     */
    public function storeProductImage(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for storeProductImage', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        try {
            $data = $request->all();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.product_image.store'), $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save product image',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error saving product image: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving product image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product images (POST /api/v1/product-image/get with { product_id })
     */
    public function getProductImages(Request $request)
    {
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');
        if (!$token) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
        } else {
            $raw = $request->getContent();
            if (!empty($raw)) {
                $decoded = json_decode($raw, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                }
            }
        }

        $productId = $jsonData['product_id'] ?? null;
        if ($productId === null || $productId === '') {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'product_id is required.'
            ], 422);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_image.index');
            $body = ['product_id' => (string) $productId];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $body);

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch product images',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error fetching product images: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching product images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product (POST /api/v1/product/delete with { id })
     */
    public function deleteProduct(Request $request)
    {
        // Start session if not started
        if (!session()->isStarted()) {
            session()->start();
        }

        $token = session('sanctum_token');

        if (!$token) {
            Log::warning('No token found in session for deleteProduct', [
                'session_keys' => array_keys(session()->all()),
            ]);
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body
        $jsonData = [];
        if ($request->isJson() || $request->header('Content-Type') === 'application/json') {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'required|string',
        ]);

        try {
            $data = [
                'id' => $request->input('id'),
            ];

            $apiUrl = config('api.base_url') . config('api.endpoints.product.delete');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $data);

            $responseData = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            // Return more detailed error information
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to delete product.',
                'data' => $responseData,
                'api_status' => $statusCode
            ], $statusCode);
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error deleting product: ' . $e->getMessage()
            ], 500);
        }
    }
}
