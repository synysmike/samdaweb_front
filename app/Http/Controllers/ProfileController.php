<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form
     */
    public function show()
    {
        return view('public.profile');
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        // Get JSON data from request body if Content-Type is application/json
        $jsonData = [];
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'tax_id_number' => 'nullable|string|max:255',
            'notify_on_message' => 'nullable',
            'show_email' => 'nullable',
            'show_phone_number' => 'nullable',
            'profile_picture' => 'nullable|string', // Base64 string, not file
            'cover_image' => 'nullable|string', // Base64 string, not file
        ]);

        // Get bearer token from session
        $token = session('sanctum_token');

        if (!$token) {
            return back()->withErrors(['error' => 'Authentication token not found. Please login again.'])->withInput();
        }

        // Prepare request data according to API documentation
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Optional fields - only include if they have values
        if ($request->filled('phone_number')) {
            $data['phone_number'] = $request->phone_number;
        } else {
            $data['phone_number'] = null;
        }

        if ($request->filled('tax_id_number')) {
            $data['tax_id_number'] = $request->tax_id_number;
        } else {
            $data['tax_id_number'] = null;
        }

        // Boolean fields - convert to boolean or null
        $data['notify_on_message'] = $request->has('notify_on_message') && ($request->notify_on_message === true || $request->notify_on_message === '1' || $request->notify_on_message === 1) ? true : null;
        $data['show_email'] = $request->has('show_email') && ($request->show_email === true || $request->show_email === '1' || $request->show_email === 1) ? true : null;
        $data['show_phone_number'] = $request->has('show_phone_number') && ($request->show_phone_number === true || $request->show_phone_number === '1' || $request->show_phone_number === 1) ? true : null;

        // Handle profile picture - validate base64 and send to API
        if ($request->filled('profile_picture') && $request->input('profile_picture') !== null) {
            $profilePictureInput = $request->input('profile_picture');
            
            // Validate base64 string
            if (is_string($profilePictureInput) && !$request->hasFile('profile_picture')) {
                // Remove any data URL prefix if present (data:image/...;base64,)
                $base64String = $profilePictureInput;
                if (str_contains($base64String, ',')) {
                    $base64String = explode(',', $base64String)[1];
                }
                
                // Remove any whitespace or newlines
                $base64String = preg_replace('/\s+/', '', $base64String);
                
                // Validate base64 string size (1MB = 1048576 bytes, base64 is ~33% larger)
                $maxBase64Length = 1400000; // ~1MB file when decoded
                if (strlen($base64String) > $maxBase64Length) {
                    $errorMsg = 'Profile picture size must be less than 1MB.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
                
                // Validate base64 format and check if it's an image
                try {
                    $imageData = base64_decode($base64String, true);
                    if ($imageData === false) {
                        throw new \Exception('Invalid base64 data');
                    }
                    
                    // Validate file size (decoded)
                    if (strlen($imageData) > 1048576) {
                        $errorMsg = 'Profile picture size must be less than 1MB.';
                        if ($request->wantsJson() || $request->ajax()) {
                            return response()->json([
                                'success' => false,
                                'status' => 'error',
                                'message' => $errorMsg
                            ], 422);
                        }
                        return back()->withErrors(['error' => $errorMsg])->withInput();
                    }
                    
                    // Validate image type by checking magic bytes
                    $imageInfo = @getimagesizefromstring($imageData);
                    if ($imageInfo === false) {
                        throw new \Exception('Invalid image file');
                    }
                    
                    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
                    if (!in_array($imageInfo[2], $allowedTypes)) {
                        throw new \Exception('Only JPEG, PNG, GIF, and WebP images are allowed');
                    }
                    
                    // Send clean base64 string (without prefix) to API
                    $data['profile_picture'] = $base64String;
                } catch (\Exception $e) {
                    \Log::error('Error validating profile picture: ' . $e->getMessage());
                    $errorMsg = 'Invalid image file. Only JPEG, PNG, GIF, and WebP images are allowed.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
            } elseif ($request->hasFile('profile_picture')) {
                // Fallback: handle file upload (for non-AJAX requests)
                $profilePicture = $request->file('profile_picture');
                
                // Validate file type
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($profilePicture->getMimeType(), $allowedMimes)) {
                    $errorMsg = 'Only JPEG, PNG, GIF, and WebP images are allowed.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
                
                // Validate file size
                if ($profilePicture->getSize() > 1048576) {
                    $errorMsg = 'Profile picture size must be less than 1MB.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
                
                // Convert to base64 (clean, without prefix)
                $data['profile_picture'] = base64_encode(file_get_contents($profilePicture->getRealPath()));
            }
        } else {
            $data['profile_picture'] = null;
        }

        // Handle cover image - validate base64 and send to API
        if ($request->filled('cover_image') && $request->input('cover_image') !== null) {
            $coverImageInput = $request->input('cover_image');
            
            // Validate base64 string
            if (is_string($coverImageInput) && !$request->hasFile('cover_image')) {
                // Remove any data URL prefix if present (data:image/...;base64,)
                $base64String = $coverImageInput;
                if (str_contains($base64String, ',')) {
                    $base64String = explode(',', $base64String)[1];
                }
                
                // Remove any whitespace or newlines
                $base64String = preg_replace('/\s+/', '', $base64String);
                
                // Validate base64 string size (1MB = 1048576 bytes, base64 is ~33% larger)
                $maxBase64Length = 1400000; // ~1MB file when decoded
                if (strlen($base64String) > $maxBase64Length) {
                    $errorMsg = 'Cover image size must be less than 1MB.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
                
                // Validate base64 format and check if it's an image
                try {
                    $imageData = base64_decode($base64String, true);
                    if ($imageData === false) {
                        throw new \Exception('Invalid base64 data');
                    }
                    
                    // Validate file size (decoded)
                    if (strlen($imageData) > 1048576) {
                        $errorMsg = 'Cover image size must be less than 1MB.';
                        if ($request->wantsJson() || $request->ajax()) {
                            return response()->json([
                                'success' => false,
                                'status' => 'error',
                                'message' => $errorMsg
                            ], 422);
                        }
                        return back()->withErrors(['error' => $errorMsg])->withInput();
                    }
                    
                    // Validate image type by checking magic bytes
                    $imageInfo = @getimagesizefromstring($imageData);
                    if ($imageInfo === false) {
                        throw new \Exception('Invalid image file');
                    }
                    
                    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
                    if (!in_array($imageInfo[2], $allowedTypes)) {
                        throw new \Exception('Only JPEG, PNG, GIF, and WebP images are allowed');
                    }
                    
                    // Send clean base64 string (without prefix) to API
                    $data['cover_image'] = $base64String;
                } catch (\Exception $e) {
                    \Log::error('Error validating cover image: ' . $e->getMessage());
                    $errorMsg = 'Invalid image file. Only JPEG, PNG, GIF, and WebP images are allowed.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
            } elseif ($request->hasFile('cover_image')) {
                // Fallback: handle file upload (for non-AJAX requests)
                $coverImage = $request->file('cover_image');
                
                // Validate file type
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($coverImage->getMimeType(), $allowedMimes)) {
                    $errorMsg = 'Only JPEG, PNG, GIF, and WebP images are allowed.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
                
                // Validate file size
                if ($coverImage->getSize() > 1048576) {
                    $errorMsg = 'Cover image size must be less than 1MB.';
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 422);
                    }
                    return back()->withErrors(['error' => $errorMsg])->withInput();
                }
                
                // Convert to base64 (clean, without prefix)
                $data['cover_image'] = base64_encode(file_get_contents($coverImage->getRealPath()));
            }
        } else {
            $data['cover_image'] = null;
        }

        // Make API request
        try {
            $apiBaseUrl = config('api.base_url');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiBaseUrl . config('api.endpoints.settings.update_profile'), $data);

            if ($response->successful()) {
                $responseData = $response->json();

                // Update user data in session
                $currentUserData = session('user_data', []);

                // Update name and email from form
                $currentUserData['name'] = $request->name;
                $currentUserData['email'] = $request->email;

                // Update phone_number and tax_id_number if provided
                if ($request->filled('phone_number')) {
                    $currentUserData['phone_number'] = $request->phone_number;
                }
                if ($request->filled('tax_id_number')) {
                    $currentUserData['tax_id_number'] = $request->tax_id_number;
                }

                // Update boolean fields
                $currentUserData['notify_on_message'] = $data['notify_on_message'];
                $currentUserData['show_email'] = $data['show_email'];
                $currentUserData['show_phone_number'] = $data['show_phone_number'];

                // Update images from API response (API returns storage URL/path)
                if (isset($responseData['data'])) {
                    $apiData = $responseData['data'];
                    
                    // Update profile_picture from API response (should be storage URL/path from API)
                    if (isset($apiData['profile']) && isset($apiData['profile']['profile_picture'])) {
                        $currentUserData['profile_picture'] = $apiData['profile']['profile_picture'];
                    } elseif (isset($apiData['profile_picture'])) {
                        $currentUserData['profile_picture'] = $apiData['profile_picture'];
                    } elseif ($request->input('profile_picture') === null) {
                        // User removed the image
                        $currentUserData['profile_picture'] = null;
                    }
                    // If not in API response and not null in request, keep existing value
                    
                    // Update cover_image from API response (should be storage URL/path from API)
                    if (isset($apiData['profile']) && isset($apiData['profile']['cover_image'])) {
                        $currentUserData['cover_image'] = $apiData['profile']['cover_image'];
                    } elseif (isset($apiData['cover_image'])) {
                        $currentUserData['cover_image'] = $apiData['cover_image'];
                    } elseif ($request->input('cover_image') === null) {
                        // User removed the image
                        $currentUserData['cover_image'] = null;
                    }
                    // If not in API response and not null in request, keep existing value
                } else {
                    // Fallback: if API doesn't return data, handle based on request
                    if ($request->input('profile_picture') === null) {
                        $currentUserData['profile_picture'] = null;
                    }
                    if ($request->input('cover_image') === null) {
                        $currentUserData['cover_image'] = null;
                    }
                }

                session(['user_data' => $currentUserData]);
                session()->save(); // Explicitly save session

                // Return JSON response for AJAX requests
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'status' => 'success',
                        'message' => $responseData['message'] ?? 'Profile updated successfully!',
                        'data' => $responseData['data'] ?? $responseData
                    ]);
                }

                return back()->with('success', $responseData['message'] ?? 'Profile updated successfully!');
            } else {
                $responseData = $response->json();
                $errorMessage = $responseData['message'] ?? 'Failed to update profile. Please try again.';

                // Handle specific validation errors
                if (isset($responseData['errors']) && is_array($responseData['errors'])) {
                    $errors = [];
                    foreach ($responseData['errors'] as $field => $messages) {
                        if (is_array($messages)) {
                            $errors[] = implode(', ', $messages);
                        } else {
                            $errors[] = $messages;
                        }
                    }
                    $errorMessage = implode(' ', $errors);
                }

                // Return JSON response for AJAX requests
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'status' => 'error',
                        'message' => $errorMessage,
                        'errors' => $responseData['errors'] ?? []
                    ], $response->status());
                }

                return back()->withErrors(['error' => $errorMessage])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8',
        ]);

        // Get bearer token from session
        $token = session('sanctum_token');

        // Debug logging
        \Log::info('Change Password - Token check', [
            'has_token' => !empty($token),
            'token_length' => $token ? strlen($token) : 0,
            'token_preview' => $token ? substr($token, 0, 20) . '...' : null,
            'session_id' => session()->getId(),
        ]);

        if (!$token || empty($token)) {
            \Log::warning('Change Password - No token in session');
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Prepare request data according to API documentation
        $data = [
            'old_password' => $request->old_password,
            'new_password' => $request->new_password,
            'confirm_password' => $request->confirm_password,
        ];

        // Make API request
        try {
            \Log::info('Change Password - Making API request', [
                'url' => config('api.base_url') . config('api.endpoints.settings.change_password'),
                'has_auth_header' => !empty($token),
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.settings.change_password'), $data);

            \Log::info('Change Password - API Response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            $responseData = $response->json();

            \Log::info('Change Password - API Response', [
                'status' => $response->status(),
                'response_body' => $responseData,
            ]);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $responseData['message'] ?? 'Password changed successfully!'
                ]);
            } else {
                // Handle authentication errors specifically
                if ($response->status() === 401 || ($responseData['message'] ?? '') === 'Unauthenticated.') {
                    \Log::warning('Change Password - Unauthenticated', [
                        'token_exists' => !empty($token),
                        'token_preview' => $token ? substr($token, 0, 20) . '...' : null,
                    ]);

                    // Clear invalid token from session
                    session()->forget('sanctum_token');

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Your session has expired. Please login again.',
                        'errors' => [],
                        'requires_login' => true
                    ], 401);
                }

                // Handle validation errors
                $errorMessage = $responseData['message'] ?? 'Failed to change password. Please try again.';
                $errors = $responseData['errors'] ?? [];

                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage,
                    'errors' => $errors
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get list of shipping addresses
     * Uses GET method to base endpoint
     */
    public function shippingAddressIndex()
    {
        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        try {
            // API uses GET method to base endpoint for listing shipping addresses
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get(config('api.base_url') . config('api.endpoints.settings.shipping_address.index'));

            $responseData = $response->json();

            if ($response->successful()) {
                // Handle both single object and array responses
                $data = $responseData['data'] ?? $responseData;
                // If data is a single object, wrap it in an array
                if (isset($data) && !is_array($data) || (is_array($data) && isset($data['id']))) {
                    $data = [$data];
                }
                // If data is already an array, use it as is
                if (!is_array($data)) {
                    $data = [];
                }

                return response()->json([
                    'status' => 'success',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Failed to load shipping addresses.',
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get countries list
     */
    public function getCountries()
    {
        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get(config('api.base_url') . config('api.endpoints.world.countries'));

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $responseData['data'] ?? $responseData
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Failed to load countries.',
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get states list by country
     */
    public function getStates(Request $request)
    {
        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body if Content-Type is application/json
        $jsonData = [];
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        }

        $request->validate([
            'country_id' => 'required|integer',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.world.states'), [
                'country_id' => $request->input('country_id')
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $responseData['data'] ?? $responseData
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Failed to load states.',
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cities list by state
     */
    public function getCities(Request $request)
    {
        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body if Content-Type is application/json
        $jsonData = [];
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        }

        $request->validate([
            'state_id' => 'required|integer',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.world.cities'), [
                'state_id' => $request->input('state_id')
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $responseData['data'] ?? $responseData
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Failed to load cities.',
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store or update shipping address
     * Uses /store endpoint for both create and update
     */
    public function shippingAddressStore(Request $request)
    {
        // Get JSON data from request body if Content-Type is application/json
        $jsonData = [];
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        }

        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'address_description' => 'nullable|string',
            'city_name' => 'nullable|string|max:255',
            'state_name' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address_title' => 'nullable|string|max:255',
            'address_type' => 'nullable|string|max:255',
            'city_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'country_id' => 'nullable|integer',
            'country_name' => 'nullable|string|max:255',
        ]);

        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get user_id from session
        $userData = session('user_data', []);
        $userId = $userData['id'] ?? null;

        // Get ID from request (for update) or null (for create)
        $addressId = $request->input('id');

        // Prepare all required fields (all can be null but must be present)
        $data = [
            'id' => $addressId, // ID for update, null for new address
            'user_id' => $userId,
            'address_type' => $request->input('address_type') ?? null,
            'address_title' => $request->input('address_title') ?? null,
            'first_name' => $request->input('first_name') ?? null,
            'last_name' => $request->input('last_name') ?? null,
            'email' => $request->input('email') ?? null,
            'phone_number' => $request->input('phone_number') ?? null,
            'country_name' => $request->input('country_name') ?? null,
            'state_id' => $request->has('state_id') && $request->input('state_id') ? (int)$request->input('state_id') : null,
            'state_name' => $request->input('state_name') ?? null,
            'city_id' => $request->has('city_id') && $request->input('city_id') ? (int)$request->input('city_id') : null,
            'city_name' => $request->input('city_name') ?? null,
            'zip_code' => $request->input('zip_code') ?? null,
            'address_description' => $request->input('address_description') ?? null,
            'created_at' => null, // Will be set by API
            'updated_at' => null, // Will be set by API
            'country_id' => $request->has('country_id') && $request->input('country_id') ? (int)$request->input('country_id') : null,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.settings.shipping_address.store'), $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $responseData['message'] ?? ($addressId ? 'Shipping address updated successfully!' : 'Shipping address created successfully!'),
                    'data' => $responseData['data'] ?? $responseData
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? ($addressId ? 'Failed to update shipping address.' : 'Failed to create shipping address.'),
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single shipping address
     * Uses POST method to /show endpoint as per API documentation
     */
    public function shippingAddressShow(Request $request, $id)
    {
        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body if Content-Type is application/json
        $jsonData = [];
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        }

        try {
            // API uses POST method to /show endpoint
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.settings.shipping_address.show'), [
                'id' => $id
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $responseData['data'] ?? $responseData
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Failed to load shipping address.',
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update shipping address
     */
    public function shippingAddressUpdate(Request $request, $id)
    {
        // Get JSON data from request body if Content-Type is application/json
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address_description' => 'required|string',
            'city_name' => 'required|string|max:255',
            'state_name' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address_title' => 'nullable|string|max:255',
            'city_id' => 'nullable|integer',
            'state_id' => 'nullable|integer',
            'country_id' => 'nullable|integer',
            'country_name' => 'nullable|string|max:255',
        ]);

        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
            'address_description' => $request->input('address_description'),
            'city_name' => $request->input('city_name'),
            'state_name' => $request->input('state_name'),
            'zip_code' => $request->input('zip_code'),
        ];

        // Optional fields
        if ($request->has('email') && $request->input('email')) {
            $data['email'] = $request->input('email');
        }
        if ($request->has('address_title') && $request->input('address_title')) {
            $data['address_title'] = $request->input('address_title');
        }
        if ($request->has('city_id') && $request->input('city_id')) {
            $data['city_id'] = (int)$request->input('city_id');
        }
        if ($request->has('state_id') && $request->input('state_id')) {
            $data['state_id'] = (int)$request->input('state_id');
        }
        if ($request->has('country_id') && $request->input('country_id')) {
            $data['country_id'] = (int)$request->input('country_id');
        }
        if ($request->has('country_name') && $request->input('country_name')) {
            $data['country_name'] = $request->input('country_name');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->put(config('api.base_url') . config('api.endpoints.settings.shipping_address.index') . '/' . $id, $data);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $responseData['message'] ?? 'Shipping address updated successfully!',
                    'data' => $responseData['data'] ?? $responseData
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Failed to update shipping address.',
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete shipping address
     * Uses POST method to /delete endpoint as per API documentation
     */
    public function shippingAddressDestroy(Request $request, $id)
    {
        $token = session('sanctum_token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication token not found. Please login again.'
            ], 401);
        }

        // Get JSON data from request body if Content-Type is application/json
        $jsonData = [];
        if ($request->isJson()) {
            $jsonData = $request->json()->all();
            $request->merge($jsonData);
        }

        try {
            // API uses POST method to /delete endpoint
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('api.base_url') . config('api.endpoints.settings.shipping_address.delete'), [
                'id' => $id
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $responseData['message'] ?? 'Shipping address deleted successfully!',
                    'data' => $responseData['data'] ?? $responseData
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $responseData['message'] ?? 'Failed to delete shipping address.',
                    'errors' => $responseData['errors'] ?? []
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
