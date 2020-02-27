<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Car;
use Auth;

class CarController extends Controller
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
        if($user->hasPermission('xem-tin')){

            $search = $request->q;

            $items = Car::
            where('trangthai', '<>', 1)
            ->where(function($query) use ($request, $search) {
                $query->whereHas('users', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('types', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('types.brands', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('styles', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('colors', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('origins', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('conditions', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('fuels', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('locations', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhereHas('transmissions', function ($q) use ($request) {
                    $q->where('ten', 'LIKE', "%{$request->q}%");
                });
                $query->orWhere('ten', 'LIKE', '%'.$search.'%');
                $query->orWhere('gia', 'LIKE', '%'.$search.'%');
            })
            ->with([
                'users', 
                'types.brands', 
                'colors', 
                'conditions', 
                'fuels', 
                'locations', 
                'origins', 
                'styles', 
                'transmissions'
                ])->paginate(10);
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem tin!' 
        ], 401);
    }

    public function show($id)
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-tin')){

            $items = Car::with([
                'users', 
                'types.brands', 
                'colors', 
                'furnitures', 
                'conditions', 
                'fuels', 
                'locations', 
                'origins', 
                'styles', 
                'transmissions',
                'convenientcars.convenients',
                ])->where('id', $id)->first();
            return response()->json($items);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xem tin!' 
        ], 401);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('duyet-tin')){

            $items = Car::findOrFail($id);
            $items->trangthai = 2;
            $items->save();

            return response()->json($items->with([
                'users', 
                'types.brands', 
                'colors', 
                'conditions', 
                'fuels', 
                'locations', 
                'origins', 
                'styles', 
                'transmissions'
                ])->where('id', $id)->first());
        } 
        
        return response([
            'message' => 'Bạn không có quyền duyệt tin!' 
        ], 401);
    }
    public function deny($id)
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('duyet-tin')){

            $items = Car::findOrFail($id);
            $items->trangthai = 3;
            $items->save();

            return response()->json($items->with([
                'users', 
                'types.brands', 
                'colors', 
                'conditions', 
                'fuels', 
                'locations', 
                'origins', 
                'styles', 
                'transmissions'
                ])->where('id', $id)->first());
        } 
        
        return response([
            'message' => 'Bạn không có quyền duyệt tin!' 
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
        if($user->hasPermission('duyet-tin')){

            $items = Car::findOrFail($id);
            $items->trangthai = 1;
            $items->save();

            return response($items, 200);
        } 
        
        return response([
            'message' => 'Bạn không có quyền xóa tin!' 
        ], 401);
    }

    public function count()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard')){

            $count = Car::get()->count();
            return response()->json($count);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function countApprove()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard') || $user->hasPermission('quan-ly-danh-muc')){

            $count = Car::where('trangthai', '=', 2)->get()->count();
            return response()->json($count);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function countCost()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard')){

            $count = Car::where('trangthai', '=', 2)->get()->sum('phi');
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

            $first_day = Carbon::today()->startOfMonth();
            $chartDatas = array();
            for ($i=11; $i >=0; $i--) {
                $f = $first_day->copy()->subMonth($i);
                $l = $f->copy()->endOfMonth();

                $count = DB::table('cars')->select([
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereBetween('created_at', [$f, $l])
                ->first();

                $obj = new ChartData($f->format('Y-m'), $count->count);
                array_push($chartDatas, $obj);
            }
            return response()->json($chartDatas);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function countApprovePerMonth()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard')){

            $first_day = Carbon::today()->startOfMonth();
            $chartDatas = array();
            for ($i=11; $i >=0; $i--) {
                $f = $first_day->copy()->subMonth($i);
                $l = $f->copy()->endOfMonth();

                $count = DB::table('cars')->select([
                    DB::raw('COUNT(id) AS count'),
                ])
                ->whereBetween('created_at', [$f, $l])
                ->where('trangthai', '=', 2)
                ->first();

                $obj = new ChartData($f->format('Y-m'), $count->count);
                array_push($chartDatas, $obj);
            }
            return response()->json($chartDatas);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function countCostPerMonth()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard')){

            $first_day = Carbon::today()->startOfMonth();
            $chartDatas = array();
            for ($i=11; $i >=0; $i--) {
                $f = $first_day->copy()->subMonth($i);
                $l = $f->copy()->endOfMonth();

                $count = DB::table('cars')->select([
                    DB::raw('SUM(phi) AS count'),
                ])
                ->whereBetween('created_at', [$f, $l])
                ->where('trangthai', '=', 2)
                ->first();

                if($count->count == null){
                    $count->count = 0;
                }

                $obj = new ChartData($f->format('Y-m'), $count->count);
                array_push($chartDatas, $obj);
            }
            return response()->json($chartDatas);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    public function countActivePerMonth()
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('xem-dashboard')){

            $first_day = Carbon::today()->startOfMonth();
            $chartDatas = array();
            for ($i=11; $i >=0; $i--) {
                $f = $first_day->copy()->subMonth($i);
                $l = $f->copy()->endOfMonth();

                $count = DB::table('cars')->select([
                    DB::raw('COUNT(id) AS count'),
                ])
                ->where('ngaydang', '>', $f)
                ->where('ngayketthuc', '<', $l)
                ->first();

                $obj = new ChartData($f->format('Y-m'), $count->count);
                array_push($chartDatas, $obj);
            }
            return response()->json($chartDatas);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }
}

class ChartData { 
      
    /* Member variables */
    var $date; 
    var $count; 
      
    function __construct( $par1, $par2 )  
    { 
        $this->date = $par1; 
        $this->count = $par2; 
    } 
}