<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Admin;
use App\Role;
use App\Permission;
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

            $orderBy = 'id';
            if($request->orderBy != null){
                $orderBy = $request->orderBy;
            }
            
            $items = Admin::where('ten', 'LIKE', '%'.$query.'%')
            ->orWhere('email', 'LIKE', '%'.$query.'%')
            ->orWhere('sdt', 'LIKE', '%'.$query.'%')
            ->orderBy($orderBy, $request->direction)
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

            $checkExist = Admin::where('email', $request->email)->get();
            if($checkExist->count() > 0){
                return response([
                    'message' => 'Email này đã tồn tại!' 
                ], 401);
            }

            $item = new Admin();
            $item->ten = $request->name;
            $item->email = $request->email;
            $item->password = $request->password;
            $item->save();

            $roles = Role::where('slug', 'employee')->get();
            $item->roles()->attach($roles);
            return response($item->with('roles')->where('email', $request->email)->first(), 201);
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
    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if($user){

            $item = Admin::findOrFail($user->id);
            $item->ten = $request->name;
            $item->sdt = $request->phone;
            $item->email = $request->email;
            $item->diachi = $request->address;
            $item->cmnd = $request->cmnd;

            if($request->hasFile('avatar')){
                $fileNameWithExt = $request->file('avatar')->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('avatar')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $request->file('avatar')->storeAs('adminfiles/'. md5($user->id) . '/images/Avatar', $fileNameToStore);
                $item->avatar = $fileNameToStore;
            }

            if($request->hasFile('cover')){
                $fileNameWithExt = $request->file('cover')->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cover')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $request->file('cover')->storeAs('adminfiles/'. md5($user->id) . '/images/Cover', $fileNameToStore);
                $item->cover = $fileNameToStore;
            }

            $item->save();

            if($user->hasPermission('phan-quyen')){
                $roles = Role::whereIn('id', json_decode($request->roles))->get();
                $item->roles()->detach();
                $item->roles()->attach($roles);
            }
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

    public function updateEmployeeRolesPermissions(Request $request)
    {

        $item = Admin::findOrFail($request->id);

        $roles = Role::whereIn('id', json_decode($request->roles))->get();
        $item->roles()->detach();
        $item->roles()->attach($roles);

        $permissions = Permission::whereIn('id', json_decode($request->permissions))->get();
        $item->permissions()->detach();
        $item->permissions()->attach($permissions);
        return response()->json($item->with(['roles.permissions', 'permissions'])->where('id', $request->id)->first());
    }
}
