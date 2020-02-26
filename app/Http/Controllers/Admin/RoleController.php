<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\Permission;

class RoleController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;

        $items = Role::where('roles.ten', 'LIKE', '%'.$query.'%')->with(['permissions', 'admins'])
        ->paginate(10);
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Role();
        $item->ten = $request->name;
        $item->slug = $request->slug;
        $item->save();
        return response($item, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $item = Role::findOrFail($id);
        $item->ten = $request->name;
        $item->save();

        $permissions = Permission::whereIn('id', json_decode($request->permissions))->get();
        $item->permissions()->detach();
        $item->permissions()->attach($permissions);
        return response()->json($item->with(['permissions', 'admins'])->where('id', $id)->first());
        // return $request->permissions;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Role::findOrFail($id);
        $item->trangthai = 1;
        $item->save();
        return response($item, 200);
    }
}
