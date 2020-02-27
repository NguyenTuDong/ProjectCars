<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::guard('admin')->user()->load(['roles.permissions', 'permissions']);
        return view('admin.dashboard', compact('user'));
    }

    public function auth()
    {
        $auth = Auth::guard('admin')->user()->load(['roles.permissions', 'permissions']);
        return response()->json($auth);
    }
}
