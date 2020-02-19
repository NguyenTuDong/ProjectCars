<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;

        $items = Car::
        whereHas('users', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('types', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('types.brands', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('styles', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('colors', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('origins', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('conditions', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('fuels', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('locations', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhereHas('transmissions', function ($q) use ($request) {
            $q->where('ten', 'LIKE', "%{$request->q}%");
        })
        ->orWhere('ten', 'LIKE', '%'.$query.'%')
        ->orWhere('gia', 'LIKE', '%'.$query.'%')
        ->where('trangthai', '=', 0)
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

    public function show($id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Car::findOrFail($id);
        $items->trangthai = 1;
        $items->save();

        return response($items, 200);
    }

    public function count()
    {
        $count = Car::get()->count();
        return response()->json($count);
    }

    public function countPerMonth()
    {
        $chartDatas = Car::select([
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

    public function countActivePerMonth()
    {
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