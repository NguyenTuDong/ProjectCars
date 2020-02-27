<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Style;
use Auth;

class StyleController extends Controller
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

            $cars = DB::raw('(SELECT a.id, a.styles_id FROM `cars` a WHERE trangthai = 2)
                Total');
            $items = Style::select([
                'styles.id',
                'styles.ten',
                'styles.hinhanh',
                DB::raw('COUNT(Total.id) AS count'),
            ])
            ->leftJoin($cars, function($join){
                $join->on('styles.id', '=', 'Total.styles_id');
            })
            ->where('styles.trangthai', 0)
            ->where('styles.ten', 'LIKE', '%'.$query.'%')
            ->groupBy('styles.id')
            ->paginate(10);
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem kiểu dáng!' 
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
                'img' => 'image',
            ]);

            $items = new Style();

            if($request->hasFile('img')){
                $fileNameWithExt = $request->file('img')->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('img')->getClientOriginalExtension();
                $fileNameToStore = 'style_'.time().'.'.$extension;
                $path = $request->file('img')->storeAs('img/style', $fileNameToStore);
                $items->hinhanh = $fileNameToStore;
            }
            $items->ten = $request->name;

            $items->save();
            return response($items, 201);
        } 
        
        return response([
            'message' => 'Bạn không có quyền thêm kiểu dáng!' 
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
                'img' => 'image',
            ]);

            $items = Style::findOrFail($id);
            $items->ten = $request->name;

            if($request->hasFile('img')){
                $fileNameWithExt = $request->file('img')->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('img')->getClientOriginalExtension();
                $fileNameToStore = 'style_'.time().'.'.$extension;
                $path = $request->file('img')->storeAs('img/style', $fileNameToStore);
                $items->hinhanh = $fileNameToStore;
            }

            $items->save();
            return response($items, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền sửa kiểu dáng!' 
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

            $items = Style::findOrFail($id);
            $items->trangthai = 1;
            $items->save();
            return response($items, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xóa kiểu dáng!' 
        ], 401);
    }
}
