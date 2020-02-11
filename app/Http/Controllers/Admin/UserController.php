<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::paginate(10);
        return response()->json($items);
    }

    public function show($id)
    {
        $items = User::findOrFail($id)->first();
        return response()->json($items);
    }
}
