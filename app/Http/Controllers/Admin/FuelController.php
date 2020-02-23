<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Fuel;

class FuelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;
        
        $cars = DB::raw('(SELECT a.id, a.fuels_id FROM `cars` a WHERE trangthai = 2)
               Total');
        $items = Fuel::select([
            'fuels.id',
            'fuels.ten',
            DB::raw('COUNT(Total.id) AS count'),
        ])
        ->leftJoin($cars, function($join){
            $join->on('fuels.id', '=', 'Total.fuels_id');
        })
        ->where('fuels.trangthai', 0)
        ->where('fuels.ten', 'LIKE', '%'.$query.'%')
        ->groupBy('fuels.id')
        ->paginate(10);
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Fuel();
        $item->ten = $request->name;
        $item->save();
        return response($item, 201);
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
        $item = Fuel::findOrFail($id);
        $item->ten = $request->name;
        $item->save();
        return response($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Fuel::findOrFail($id);
        $item->trangthai = 1;
        $item->save();
        return response($item, 200);
    }
}
