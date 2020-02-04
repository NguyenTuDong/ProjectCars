<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Car::where('trangthai', '!=', 1)->with([
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $items = Car::findOrFail($id);
        $items->trangthai = 2;
        $items->save();
        return response($items, 200);
    }
    public function deny($id)
    {
        $items = Car::findOrFail($id);
        $items->trangthai = 3;
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
        $items = Car::findOrFail($id);
        $items->trangthai = 1;
        $items->save();
        return response($items, 200);
    }
}
