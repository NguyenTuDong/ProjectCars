<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Condition;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;

        $cars = DB::raw('(SELECT a.id, a.conditions_id FROM `cars` a WHERE trangthai = 2)
               Total');
        $items = Condition::select([
            'conditions.id',
            'conditions.ten',
            DB::raw('COUNT(Total.id) AS count'),
        ])
        ->leftJoin($cars, function($join){
            $join->on('conditions.id', '=', 'Total.conditions_id');
        })
        ->where('conditions.trangthai', 0)
        ->where('conditions.ten', 'LIKE', '%'.$query.'%')
        ->groupBy('conditions.id')
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
        $item = new Condition();
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
        $item = Condition::findOrFail($id);
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
        $item = Condition::findOrFail($id);
        $item->trangthai = 1;
        $item->save();
        return response($item, 200);
    }
}
