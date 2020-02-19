<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Style;

class StyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->q;

        $cars = DB::raw('(SELECT a.id, a.styles_id FROM `cars` a WHERE trangthai = 0)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Style::findOrFail($id);
        $items->trangthai = 1;
        $items->save();
        return response($items, 200);
    }
}