<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Car;
use Auth;

class ReportController extends Controller
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

    public function revenue(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('bao-cao')){

            $chartDatas = array();
            $end = Carbon::today();
            $start = $end->copy()->subDays(6);
            if($request->end != null){
                $end = Carbon::createFromFormat('Y/m/d', $request->end);
            }
            if($request->start != null){
                $start = Carbon::createFromFormat('Y/m/d', $request->start);
            }

            $diff = $start->diff($end)->days;
            
            for ($i=$diff; $i >=0; $i--) {
                $day = $end->copy()->subDays($i);
                $count = DB::table('cars')->select([
                    DB::raw('SUM(phi) AS count'),
                ])
                ->whereDate('created_at', $day)
                ->where('trangthai', '=', 2)
                ->first();

                if($count->count == null){
                    $count->count = 0;
                }
                $obj = new \stdClass();
                $obj->date = $day->toDateString();
                $obj->count = $count->count;
                array_push($chartDatas, $obj);
            }

            $records = Car::where('trangthai', '=', 2)->whereBetween('created_at', [$start, $end])->orderBy('phi', 'DESC')->with([
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
                ])->limit(10)->get();

            $data = new \stdClass();
            $data->chartData = $chartDatas;
            $data->records = $records;

            return response()->json($data);
        } 
        
        return response([
            'message' => 'Bạn không có quyền này!' 
        ], 401);
    }

    // public function countActivePerMonth()
    // {
    //     $user = Auth::guard('admin')->user();
    //     if($user->hasPermission('xem-dashboard')){

    //         $first_day = Carbon::today()->startOfMonth();
    //         $chartDatas = array();
    //         for ($i=11; $i >=0; $i--) {
    //             $f = $first_day->copy()->subMonth($i);
    //             $l = $f->copy()->endOfMonth();

    //             $count = DB::table('cars')->select([
    //                 DB::raw('COUNT(id) AS count'),
    //             ])
    //             ->where('ngaydang', '>', $f)
    //             ->where('ngayketthuc', '<', $l)
    //             ->first();

    //             $obj = new ChartData($f->format('Y-m'), $count->count);
    //             array_push($chartDatas, $obj);
    //         }
    //         return response()->json($chartDatas);
    //     } 
        
    //     return response([
    //         'message' => 'Bạn không có quyền này!' 
    //     ], 401);
    // }
}