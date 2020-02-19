<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Type;
use App\Brand;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands_id = $request->brands_id;
        $query = $request->q;
        $brand = Brand::find($brands_id);
        $id = null;
        if($brand === null) {
            $id = Brand::first()->id;
        } else {
            $id = $brands_id;
        }

        $cars = DB::raw('(SELECT a.id, a.types_id FROM `cars` a WHERE trangthai = 0)
               Total');
        $items = Type::select([
            'types.id',
            'types.ten',
            DB::raw('COUNT(Total.id) AS count'),
        ])
        ->leftJoin($cars, function($join){
            $join->on('types.id', '=', 'Total.types_id');
        })
        ->where('brands_id', $id)
        ->where('types.trangthai', 0)
        ->where('types.ten', 'LIKE', '%'.$query.'%')
        ->groupBy('types.id')
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
        $item = new Type();
        $item->brands_id = $request->brands_id;
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
        $item = Type::findOrFail($id);
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
        $item = Type::findOrFail($id);
        $item->trangthai = 1;
        $item->save();
        return response($item, 200);
    }
}