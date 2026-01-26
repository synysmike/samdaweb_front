<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class login extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('public.login');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // GuestMiddleware will handle the redirect if already logged in
        return view('public.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Store Sanctum token in session
     */
    public function storeToken(Request $request)
    {
        // Get raw input to check what we received
        $rawInput = $request->all();
        \Log::info('StoreToken called', [
            'has_token' => $request->has('token'),
            'has_user' => $request->has('user'),
            'has_profile' => $request->has('profile'),
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'raw_input_keys' => array_keys($rawInput),
            'request_body' => $request->getContent()
        ]);

        try {
            // Get JSON data from request body
            $jsonData = json_decode($request->getContent(), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('StoreToken JSON Error', ['error' => json_last_error_msg()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON: ' . json_last_error_msg()
                ], 400);
            }
            
            // Merge JSON data with request
            if (is_array($jsonData)) {
                $request->merge($jsonData);
            }
            
            // Validate request - roles is optional string
            $request->validate([
                'token' => 'required|string',
                'user' => 'nullable|array',
                'profile' => 'nullable|array',
                'roles' => 'nullable|string', // roles can be null or string
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('StoreToken Validation Error', ['errors' => $e->errors(), 'input' => $request->all()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('StoreToken Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }

        \Log::info('StoreToken validation passed', ['token_length' => strlen($request->token)]);

        // Store token in session
        $request->session()->put('sanctum_token', $request->token);
        \Log::info('Token stored in session', ['session_id' => $request->session()->getId()]);

        // Merge user and profile data
        $userData = $request->user ?? [];
        $profileData = $request->profile ?? [];
        
        // Merge user and profile data together
        $mergedUserData = array_merge($userData, $profileData);
        
        // Add roles if provided and not null/empty
        if ($request->has('roles') && $request->input('roles') !== null && $request->input('roles') !== '') {
            $mergedUserData['roles'] = (string) $request->input('roles');
        }
        
        // Store merged user data in session
        if (!empty($mergedUserData)) {
            $request->session()->put('user_data', $mergedUserData);
        }
        
        // Save session immediately before regenerating
        $request->session()->save();
        
        // Regenerate session ID for security (after saving)
        $request->session()->regenerate();
        
        // Save again after regenerate
        $request->session()->save();

        // Verify session was stored
        $tokenStored = $request->session()->has('sanctum_token');
        $sessionId = $request->session()->getId();

        return response()->json([
            'success' => true,
            'message' => 'Token stored successfully',
            'has_token' => $tokenStored,
            'session_id' => $sessionId
        ])->withCookie(cookie(
            config('session.cookie'),
            $sessionId,
            config('session.lifetime'),
            config('session.path'),
            config('session.domain'),
            config('session.secure'),
            config('session.http_only'),
            false,
            config('session.same_site')
        ));
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
        // Get bearer token from session before clearing
        $token = session('sanctum_token');
        
        // Call API logout endpoint if token exists
        if ($token) {
            try {
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post('http://36.93.42.27:4340/api/v1/auth/logout');
            } catch (\Exception $e) {
                // Log error but continue with logout process
                \Log::error('Logout API call failed: ' . $e->getMessage());
            }
        }
        
        // Clear Sanctum token from session
        $request->session()->forget('sanctum_token');
        $request->session()->forget('user_data');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // Example minimal controller method
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
