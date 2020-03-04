<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Convenient;
use Auth;

class ConvenientController extends Controller
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

            $cars = DB::raw('(SELECT COUNT(`convenientcars`.`convenients_id`) AS count, `convenientcars`.`convenients_id`, `convenientcars`.`cars_id`, `cars`.`trangthai` FROM `convenientcars` JOIN `cars` ON `cars`.`id` = `convenientcars`.`cars_id` WHERE `cars`.`trangthai` = 2 GROUP BY `convenientcars`.`convenients_id` ORDER BY `convenientcars`.`convenients_id`)
                Total');
            $items = Convenient::select([
                'convenients.*',
                'Total.count as count'
            ])
            ->leftJoin($cars, function($join){
                $join->on('convenients.id', '=', 'Total.convenients_id');
            })
            ->where('convenients.trangthai', 0)
            ->where('convenients.ten', 'LIKE', '%'.$query.'%')
            ->orderBy($orderBy, $request->direction)
            ->paginate(10);
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem tiện nghi!' 
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

            $item = new Convenient();
            $item->ten = $request->name;
            $item->save();
            return response($item, 201);
        } 
        
        return response([
            'message' => 'Bạn không có quyền thêm tiện nghi!' 
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

            $item = Convenient::findOrFail($id);
            $item->ten = $request->name;
            $item->save();
            return response($item, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền sửa tiện nghi!' 
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

            $item = Convenient::findOrFail($id);
            $item->trangthai = 1;
            $item->save();
            return response($item, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xóa tiện nghi!' 
        ], 401);
    }
}
