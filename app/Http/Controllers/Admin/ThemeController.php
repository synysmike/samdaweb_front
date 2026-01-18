<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display the theme settings page
     */
    public function index()
    {
        // Hanya tampilkan view tanpa query database
        return view('admin.themes.index');
    }

    /**
     * Update theme settings (placeholder - tidak digunakan untuk sementara)
     */
    public function update(Request $request)
    {
        // Placeholder - tidak melakukan apapun untuk sementara
        return redirect()->route('admin.themes.index')
            ->with('success', 'Theme settings updated successfully!');
    }
}
