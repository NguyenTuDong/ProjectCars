<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transmission;
use Auth;

class TransmissionController extends Controller
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
        if($user->hasPermission('quan-ly-danh-muc')){

            $query = $request->q;

            $orderBy = 'id';
            if($request->orderBy != null){
                $orderBy = $request->orderBy;
            }

            $cars = DB::raw('(SELECT a.id, a.transmissions_id FROM `cars` a WHERE trangthai = 2)
                Total');
            $items = Transmission::select([
                'transmissions.id',
                'transmissions.ten',
                DB::raw('COUNT(Total.id) AS count'),
            ])
            ->leftJoin($cars, function($join){
                $join->on('transmissions.id', '=', 'Total.transmissions_id');
            })
            ->where('transmissions.trangthai', 0)
            ->where('transmissions.ten', 'LIKE', '%'.$query.'%')
            ->orderBy($orderBy, $request->direction)
            ->groupBy('transmissions.id')
            ->paginate(10);
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem hộp số!' 
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
        if($user->hasPermission('quan-ly-danh-muc')){

            $item = new Transmission();
            $item->ten = $request->name;
            $item->save();
            return response($item, 201);
        } 
        
        return response([
            'message' => 'Bạn không có quyền thêm hộp số!' 
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
        if($user->hasPermission('quan-ly-danh-muc')){

            $item = Transmission::findOrFail($id);
            $item->ten = $request->name;
            $item->save();
            return response($item, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền sửa hộp số!' 
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
        if($user->hasPermission('quan-ly-danh-muc')){

            $item = Transmission::findOrFail($id);
            $item->trangthai = 1;
            $item->save();
            return response($item, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xóa hộp số!' 
        ], 401);
    }
}
