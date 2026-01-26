<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        // Hanya tampilkan view tanpa query database (frontend only)
        return view('admin.products.index');
    }
}
