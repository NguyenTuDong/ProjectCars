<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use Auth;

class UserController extends Controller
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
        if($user->can('xem-khach-hang')){

            $query = $request->q;
            $items = User::where('ten', 'LIKE', '%'.$query.'%')
            ->orWhere('email', 'LIKE', '%'.$query.'%')
            ->orWhere('sdt', 'LIKE', '%'.$query.'%')
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
        if($user->can('xem-khach-hang')){

            $items = User::findOrFail($id);
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem khách hàng!' 
        ], 401);
    }

    public function count()
    {
        $user = Auth::guard('admin')->user();
        if($user->can('xem-dashboard')){

            $count = User::get()->count();
            return response()->json($count);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function countPerMonth()
    {
        $user = Auth::guard('admin')->user();
        if($user->can('xem-dashboard')){

            $chartDatas = User::select([
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
}
