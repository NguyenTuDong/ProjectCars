<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Color;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Color::where('trangthai', 0)->paginate(10);
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

        $items = new Color();

        if($request->hasFile('img')){
            $fileNameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileNameToStore = 'color_'.date('YmdHi').'.'.$extension;
            $path = $request->file('img')->storeAs('img/color', $fileNameToStore);
            $items->rgb = $fileNameToStore;
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

        $items = Color::findOrFail($id);
        $items->ten = $request->name;

        if($request->hasFile('img')){
            $fileNameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileNameToStore = 'color_'.date('YmdHi').'.'.$extension;
            $path = $request->file('img')->storeAs('img/color', $fileNameToStore);
            $items->rgb = $fileNameToStore;
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
        $items = Color::findOrFail($id);
        $items->trangthai = 1;
        $items->save();
        return response($items, 200);
    }
}
