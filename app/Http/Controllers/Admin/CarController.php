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
    public function index(Request $request)
    {
        $query = $request->q;
        $state = [
            0 => 'Chờ duyệt',
            2 => 'Đã duyệt',
            3 => 'Đã từ chối',
        ];

        $state_filter = [];

        if($query != ''){
            foreach ($state as $key => $value) {
                if (strpos($value, $query) !== false) {
                    array_push($state_filter, $key);
                }
            }
        }

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
        ->orWhereIn('trangthai', $state_filter)
        ->where('trangthai', '!=', 1)
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
        // return $query;
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
        // return $id;
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

        return response()->json($items->with([
            'users', 
            'types.brands', 
            'colors', 
            'conditions', 
            'fuels', 
            'locations', 
            'origins', 
            'styles', 
            'transmissions'
            ])->where('id', $id)->first());
    }
    public function deny($id)
    {
        $items = Car::findOrFail($id);
        $items->trangthai = 3;
        $items->save();

        return response()->json($items->with([
            'users', 
            'types.brands', 
            'colors', 
            'conditions', 
            'fuels', 
            'locations', 
            'origins', 
            'styles', 
            'transmissions'
            ])->where('id', $id)->first());
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
