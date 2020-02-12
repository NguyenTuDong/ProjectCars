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
    public function index(Request $request)
    {
        $query = $request->q;
        $items = User::where('ten', 'LIKE', '%'.$query.'%')
        ->orWhere('email', 'LIKE', '%'.$query.'%')
        ->orWhere('sdt', 'LIKE', '%'.$query.'%')
        ->paginate(10);
        return response()->json($items);
    }

    public function show($id)
    {
        $items = User::findOrFail($id);
        return response()->json($items);
    }
}
