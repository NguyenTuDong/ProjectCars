<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Brand;
use Auth;

class BrandController extends Controller
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

            $cars = DB::raw('(SELECT a.id, a.types_id FROM `cars` a WHERE trangthai = 2)
                TotalCars');
            $items = Brand::select([
                'brands.id',
                'brands.ten',
                'brands.logo',
                DB::raw('COUNT(TotalCars.id) AS count'),
            ])
            ->leftJoin('types', 'brands.id', '=', 'types.brands_id')
            ->leftJoin($cars, function($join){
                $join->on('types.id', '=', 'TotalCars.types_id');
            })
            ->where('brands.trangthai', 0)
            ->where('brands.ten', 'LIKE', '%'.$query.'%')
            ->groupBy('brands.id')
            ->paginate(10);
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem thương hiệu!' 
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

            request()->validate([
                'logo' => 'image',
            ]);
    
            $items = new Brand();
    
            if($request->hasFile('logo')){
                $fileNameWithExt = $request->file('logo')->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('logo')->getClientOriginalExtension();
                $fileNameToStore = 'logo_'.time().'.'.$extension;
                $path = $request->file('logo')->storeAs('img/logo', $fileNameToStore);
                $items->logo = $fileNameToStore;
            }
            $items->ten = $request->name;
    
            $items->save();
            return response($items, 201);
        } 
        
        return response([
            'message' => 'Bạn không có quyền thêm thương hiệu!' 
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

            request()->validate([
                'logo' => 'image',
            ]);

            $items = Brand::findOrFail($id);
            $items->ten = $request->name;

            if($request->hasFile('logo')){
                $fileNameWithExt = $request->file('logo')->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('logo')->getClientOriginalExtension();
                $fileNameToStore = 'logo_'.time().'.'.$extension;
                $path = $request->file('logo')->storeAs('img/logo', $fileNameToStore);
                $items->logo = $fileNameToStore;
            }

            $items->save();
            return response($items, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền cập nhật thương hiệu!' 
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
                
            $items = Brand::findOrFail($id);
            $items->trangthai = 1;
            $items->save();
            return response($items, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xóa thương hiệu!' 
        ], 401);
    }
}
