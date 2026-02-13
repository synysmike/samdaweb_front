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
            $apiUrl = config('api.base_url') . config('api.endpoints.product_category.get');

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
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'nullable|string',
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'parent_id' => 'nullable|string',
        ]);

        try {
            $data = [
                'name' => (string) $request->input('name'),
                'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
            ];
            $id = $request->input('id');
            if ($id !== null && $id !== '') {
                $data['id'] = (string) trim($id);
            }
            // Parse parent_id from request (API may expect parent_id or parentId per docs)
            $parentId = $request->input('parent_id')
                ?? $request->input('parentId')
                ?? ($jsonData['parent_id'] ?? $jsonData['parentId'] ?? null);
            $parentId = $parentId !== null && $parentId !== '' ? trim((string) $parentId) : '';
            if ($parentId !== '') {
                $data['parent_id'] = $parentId;
                $data['parentId'] = $parentId; // some APIs expect camelCase
            }

            $response = Http::withToken($token)->withHeaders([
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

            $http = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            $response = $http->post($apiUrl, $data);

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
     * Show the product attributes page
     */
    public function attributes()
    {
        $shop = $this->checkShop();

        if (!$shop) {
            return redirect()->route('seller.register-shop');
        }

        return view('public.seller.attributes', ['shop' => $shop]);
    }

    /**
     * Get all product attributes
     */
    public function getAttributes()
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

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute.get');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch attributes',
                'data' => $responseData,
                'api_status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching attributes: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching attributes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a single product attribute
     */
    public function showAttribute(Request $request)
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
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                }
            }
        }

        $id = $request->input('id') ?? $jsonData['id'] ?? null;

        if (!$id) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Attribute ID is required'
            ], 422);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute.show');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, ['id' => $id]);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch attribute',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching attribute: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching attribute: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update a product attribute
     */
    public function storeAttribute(Request $request)
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
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'nullable|string',
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|in:radio,select',
        ]);

        try {
            $data = [
                'name' => (string) trim($request->input('name')),
            ];
            $id = $request->input('id');
            if ($id !== null && $id !== '') {
                $data['id'] = (string) trim($id);
            }
            $type = trim((string) ($request->input('type') ?? ''));
            if ($type !== '') {
                $data['type'] = $type;
            }
            // When type is empty, backend will auto-set as "select"

            $response = Http::withToken($token)->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.product_attribute.store'), $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save attribute',
                'data' => $responseData
            ], $response->status());
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error saving attribute: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving attribute: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product attribute
     */
    public function deleteAttribute(Request $request)
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
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute.delete');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, ['id' => $request->input('id')]);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to delete attribute',
                'data' => $responseData,
                'api_status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error deleting attribute: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error deleting attribute: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product attribute values (filtered by product_attribute_id)
     */
    public function getAttributeValues(Request $request)
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
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                    $request->merge($decoded);
                }
            }
        }

        $productAttributeId = $request->input('product_attribute_id') ?? $jsonData['product_attribute_id'] ?? null;
        if (!$productAttributeId) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'product_attribute_id is required'
            ], 422);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute_value.get');
            $body = ['product_attribute_id' => $productAttributeId];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $body);

            $responseData = $response->json();
            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch attribute values',
                'data' => $responseData,
                'api_status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching attribute values: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching attribute values: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a single product attribute value
     */
    public function showAttributeValue(Request $request)
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
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                }
            }
        }

        $id = $request->input('id') ?? $jsonData['id'] ?? null;
        if (!$id) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Attribute value ID is required'
            ], 422);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute_value.show');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, ['id' => $id]);

            $responseData = $response->json();
            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch attribute value',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching attribute value: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching attribute value: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update a product attribute value
     */
    public function storeAttributeValue(Request $request)
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
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'id' => 'nullable|string',
            'product_attribute_id' => 'required|string',
            'value' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        try {
            $id = $request->input('id');
            $data = [
                'product_attribute_id' => (string) trim($request->input('product_attribute_id')),
                'value' => (string) trim($request->input('value')),
                'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
                'sort_order' => (int) ($request->input('sort_order') ?? 0),
            ];
            if ($id !== null && $id !== '') {
                $data['id'] = (string) trim($id);
            }

            $response = Http::withToken($token)->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.product_attribute_value.store'), $data);

            $responseData = $response->json();
            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save attribute value',
                'data' => $responseData
            ], $response->status());
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error saving attribute value: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving attribute value: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product attribute value
     */
    public function deleteAttributeValue(Request $request)
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
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute_value.delete');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, ['id' => $request->input('id')]);

            $responseData = $response->json();
            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to delete attribute value',
                'data' => $responseData,
                'api_status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error deleting attribute value: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error deleting attribute value: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product attribute set (attributes joined with product)
     */
    public function getProductAttributeSet(Request $request)
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
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                    $request->merge($decoded);
                }
            }
        }

        $productId = $request->input('product_id') ?? $jsonData['product_id'] ?? null;
        if (!$productId) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'product_id is required'
            ], 422);
        }

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute_set.get');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, ['product_id' => $productId]);

            $responseData = $response->json();
            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to fetch product attribute set',
                'data' => $responseData,
                'api_status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching product attribute set: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error fetching product attribute set: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store product attribute set (pair product with attribute)
     */
    public function storeProductAttributeSet(Request $request)
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
            $request->merge($jsonData);
        } else {
            $rawContent = $request->getContent();
            if (!empty($rawContent)) {
                $decoded = json_decode($rawContent, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $jsonData = $decoded;
                    $request->merge($decoded);
                }
            }
        }

        $request->validate([
            'product_id' => 'required|string',
            'product_attribute_id' => 'required|string',
        ]);

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute_set.store');
            $body = [
                'product_id' => (string) trim($request->input('product_id')),
                'product_attribute_id' => (string) trim($request->input('product_attribute_id')),
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $body);

            $responseData = $response->json();
            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to save product attribute set',
                'data' => $responseData
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error saving product attribute set: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error saving product attribute set: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete product attribute set
     */
    public function deleteProductAttributeSet(Request $request)
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
            'product_id' => 'required|string',
            'product_attribute_id' => 'required|string',
        ]);

        try {
            $apiUrl = config('api.base_url') . config('api.endpoints.product_attribute_set.delete');
            $body = [
                'product_id' => (string) trim($request->input('product_id')),
                'product_attribute_id' => (string) trim($request->input('product_attribute_id')),
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $body);

            $responseData = $response->json();
            if ($response->successful()) {
                return response()->json($responseData);
            }

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Failed to delete product attribute set',
                'data' => $responseData,
                'api_status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            Log::error('Error deleting product attribute set: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Error deleting product attribute set: ' . $e->getMessage()
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
     * API expects: id?, title, description, category_id, is_active, is_visible,
     * country_id, state_id, city_id, min_price, max_price
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
            $id = ($id === '' || $id === null) ? null : trim((string) $id);

            $data = [
                'title' => (string) trim($request->input('title') ?? ''),
                'description' => (string) trim($request->input('description') ?? ''),
                'category_id' => (string) trim($request->input('category_id') ?? ''),
                'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
                'is_visible' => filter_var($request->input('is_visible'), FILTER_VALIDATE_BOOLEAN),
                'country_id' => (int) ($request->input('country_id') ?? 0),
                'state_id' => (int) ($request->input('state_id') ?? 0),
                'city_id' => (int) ($request->input('city_id') ?? 0),
                'min_price' => (int) round((float) ($request->input('min_price') ?? 0)),
                'max_price' => (int) round((float) ($request->input('max_price') ?? 0)),
            ];
            if ($id !== null && $id !== '') {
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
