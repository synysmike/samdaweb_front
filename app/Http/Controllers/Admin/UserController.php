<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        // Hanya tampilkan view tanpa query database (frontend only)
        return view('admin.users.index');
    }

    /**
     * Display user detail with products and selling progress
     */
    public function show($id)
    {
        // Hanya tampilkan view tanpa query database (frontend only)
        return view('admin.users.show', ['userId' => $id]);
    }
}
