<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Admin;
use App\Role;
use Auth;

class EmployeeController extends Controller
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
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-nhan-vien')){

            $query = $request->q;
            $items = Admin::where('ten', 'LIKE', '%'.$query.'%')
            ->orWhere('email', 'LIKE', '%'.$query.'%')
            ->orWhere('sdt', 'LIKE', '%'.$query.'%')
            ->with('roles')
            ->paginate(10);
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem khách hàng!' 
        ], 401);
    }

    public function show($id)
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-nhan-vien')){

            $items = Admin::where('id', $id)
            ->with(['roles.permissions', 'permissions'])->first();
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem khách hàng!' 
        ], 401);
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
        if($user->hasPermission('them-nhan-vien')){

            $item = new Admin();
            $item->ten = $request->name;
            $item->save();
            return response($item, 201);
        } 
        
        return response([
            'message' => 'Bạn không có quyền thêm nhân viên!' 
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
        if($user->id == $id){

            $item = Admin::findOrFail($id);
            $item->ten = $request->name;
            $item->save();
            return response($item, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền sửa tài khoản này!' 
        ], 401);
    }

    public function count()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard')){

            $count = Admin::get()->count();
            return response()->json($count);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function countPerMonth()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard')){

            $chartDatas = Admin::select([
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS date'),
                DB::raw('COUNT(id) AS count'),
            ])
            ->whereBetween('created_at', [Carbon::now()->subMonth(11), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();
            return response()->json($chartDatas);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function updateEmployeeRoles(Request $request)
    {

        $item = Admin::findOrFail($request->id);

        $roles = Role::whereIn('id', json_decode($request->roles))->get();
        $item->roles()->detach();
        $item->roles()->attach($roles);
        return response()->json($item->with(['roles.permissions', 'permissions'])->where('id', $request->id)->first());
    }
}
