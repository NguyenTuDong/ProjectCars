<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;
        $items = Contact::whereHas('users', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhere('ten', 'LIKE', '%'.$query.'%')
        ->orWhere('email', 'LIKE', '%'.$query.'%')
        ->orWhere('sdt', 'LIKE', '%'.$query.'%')
        ->orWhere('noidung', 'LIKE', '%'.$query.'%')
        ->with('users')
        ->paginate(10);
        return response()->json($items);
    }

    public function show($id)
    {
        $items = Contact::findOrFail($id)->with('users')->first();
        return response()->json($items);
    }
}
