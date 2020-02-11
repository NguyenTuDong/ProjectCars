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
    public function index()
    {
        $items = Contact::with('users')->paginate(10);
        return response()->json($items);
    }

    public function show($id)
    {
        $items = Contact::findOrFail($id)->with('users')->first();
        return response()->json($items);
    }
}
