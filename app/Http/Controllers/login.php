<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class login extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('login');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login');
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
        $request->validate([
            'token' => 'required|string',
            'user' => 'nullable|array',
        ]);

        // Store token in session
        $request->session()->put('sanctum_token', $request->token);

        // Store user data if provided
        if ($request->has('user')) {
            $request->session()->put('user_data', $request->user);
        }

        return response()->json([
            'success' => true,
            'message' => 'Token stored successfully'
        ]);
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
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
