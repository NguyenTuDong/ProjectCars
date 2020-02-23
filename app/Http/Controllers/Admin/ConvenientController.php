<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Convenient;

class ConvenientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;

        $cars = DB::raw('(SELECT COUNT(`convenientcars`.`convenients_id`) AS count, `convenientcars`.`convenients_id`, `convenientcars`.`cars_id`, `cars`.`trangthai` FROM `convenientcars` JOIN `cars` ON `cars`.`id` = `convenientcars`.`cars_id` WHERE `cars`.`trangthai` = 2 GROUP BY `convenientcars`.`convenients_id` ORDER BY `convenientcars`.`convenients_id`)
               Total');
        $items = Convenient::select([
            'convenients.id',
            'convenients.ten',
            'Total.count'
        ])
        ->leftJoin($cars, function($join){
            $join->on('convenients.id', '=', 'Total.convenients_id');
        })
        ->where('convenients.trangthai', 0)
        ->where('convenients.ten', 'LIKE', '%'.$query.'%')
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
        $item = new Convenient();
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
        $item = Convenient::findOrFail($id);
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
        $item = Convenient::findOrFail($id);
        $item->trangthai = 1;
        $item->save();
        return response($item, 200);
    }
}
