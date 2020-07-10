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

    public function countCost(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if($user->hasPermission('bao-cao')){

            $chartDatas = array();
            $date = 'week';
            if($request->date != null){
                $date = $request->date;
            }
            $today = Carbon::today();

            switch ($date) {
                case '4_weeks':
                    for ($i=27; $i >=0; $i--) {
                        $day = $today->copy()->subDays($i);

                        $count = DB::table('cars')->select([
                            DB::raw('SUM(phi) AS count'),
                        ])
                        ->whereDate('created_at', $day)
                        ->where('trangthai', '=', 2)
                        ->first();

                        if($count->count == null){
                            $count->count = 0;
                        }

                        $obj = new ChartData($day->toDateString(), $count->count);
                        array_push($chartDatas, $obj);
                    }
                    break;
                case 'quarter':
                    for ($i=89; $i >=0; $i--) {
                        $day = $today->copy()->subDays($i);

                        $count = DB::table('cars')->select([
                            DB::raw('SUM(phi) AS count'),
                        ])
                        ->whereDate('created_at', $day)
                        ->where('trangthai', '=', 2)
                        ->first();

                        if($count->count == null){
                            $count->count = 0;
                        }

                        $obj = new ChartData($day->toDateString(), $count->count);
                        array_push($chartDatas, $obj);
                    }
                    break;
                case 'year':
                    for ($i=364; $i >=0; $i--) {
                        $day = $today->copy()->subDays($i);

                        $count = DB::table('cars')->select([
                            DB::raw('SUM(phi) AS count'),
                        ])
                        ->whereDate('created_at', $day)
                        ->where('trangthai', '=', 2)
                        ->first();

                        if($count->count == null){
                            $count->count = 0;
                        }

                        $obj = new ChartData($day->toDateString(), $count->count);
                        array_push($chartDatas, $obj);
                    }
                    break;
                case 'lifetime':
                    for ($i=364; $i >=0; $i--) {
                        $day = $today->copy()->subDays($i);

                        $count = DB::table('cars')->select([
                            DB::raw('SUM(phi) AS count'),
                        ])
                        ->whereDate('created_at', $day)
                        ->where('trangthai', '=', 2)
                        ->first();

                        if($count->count == null){
                            $count->count = 0;
                        }

                        $obj = new ChartData($day->toDateString(), $count->count);
                        array_push($chartDatas, $obj);
                    }
                    break;
                default:
                    for ($i=6; $i >=0; $i--) {
                        $day = $today->copy()->subDays($i);

                        $count = DB::table('cars')->select([
                            DB::raw('SUM(phi) AS count'),
                        ])
                        ->whereDate('created_at', $day)
                        ->where('trangthai', '=', 2)
                        ->first();

                        if($count->count == null){
                            $count->count = 0;
                        }

                        $obj = new ChartData($day->toDateString(), $count->count);
                        array_push($chartDatas, $obj);
                    }
                    break;
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