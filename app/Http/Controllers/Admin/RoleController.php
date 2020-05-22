<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\Permission;
use Auth;

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

        $orderBy = 'created_at';
        if($request->orderBy != null){
            $orderBy = $request->orderBy;
        }

        $items = Role::where('roles.ten', 'LIKE', '%'.$query.'%')
        ->orderBy($orderBy, $request->direction)
        ->with(['permissions', 'admins'])
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
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('quan-ly-chuc-vu')){

            $item = new Role();
            $item->ten = $request->name;
            $item->slug = $request->slug;
            $item->save();
            return response($item, 201);
        } 
        
        return response([
            'message' => 'Bạn không có quyền thêm chức vụ!' 
        ], 401);
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
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('quan-ly-chuc-vu')){
            $item = Role::findOrFail($id);
            $item->ten = $request->name;
            $item->save();

            if($user->hasPermission('phan-quyen')){
                $permissions = Permission::whereIn('id', json_decode($request->permissions))->get();
                $item->permissions()->detach();
                $item->permissions()->attach($permissions);
            }
            
            return response()->json($item->with(['permissions', 'admins'])->where('id', $id)->first());
        } 
        
        return response([
            'message' => 'Bạn không có quyền sửa chức vụ!' 
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('quan-ly-chuc-vu')){

            $item = Role::findOrFail($id);
            $item->trangthai = 1;
            $item->save();
            return response($item, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xoá chức vụ!' 
        ], 401);
    }

    public function getRoles()
    {
        $item = Role::where('trangthai', 0)->get();
        return response()->json($item);
    }
}
