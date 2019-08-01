<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Convenient;
use App\Convenientcar;
use Auth;
use Session;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $convenients = Convenient::get();
        return view('post', compact('convenients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            request()->validate([
                'hinhanh' => 'image',

            ]);

            $car = new Car();

            if($request->hasFile('hinhanh')){
                $fileNameWithExt = $request->file('hinhanh')->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('hinhanh')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $request->file('hinhanh')->storeAs('img/userfiles/'. md5(Auth::user()->id) . '/images', $fileNameToStore);
                $car->hinhanh = $fileNameToStore;
            }

            
            $car->ten = $request->name;

            $car->users_id = Auth::user()->id;

            $car->gia = $request->gia;
            $car->types_id = $request->type;
            $car->origins_id = $request->origin;
            $car->conditions_id = $request->condition;
            $car->locations_id = $request->location;
            $car->styles_id = $request->style;
            $car->transmissions_id = $request->transmission;
            $car->fuels_id = $request->fuel;
            $car->colors_id = $request->color;
            $car->furnitures_id = $request->furniture;

            $car->doixe = $request->doixe;
            $car->namsx = $request->namsx;
            $car->socua = $request->socua;
            $car->sochongoi = $request->sochongoi;
            $car->kichthuoc = $request->kichthuoc;
            $car->cannang = $request->cannang;
            $car->dungtich = $request->dungtich;
            $car->phanh = $request->phanh;
            $car->giamxoc = $request->giamxoc;
            $car->lopxe = $request->lopxe;
            $car->mota = $request->mota;

            $convenients = $request->convenient;

            $car->save();

            if ($convenients != null){
                foreach($convenients as $convenient){
                $convenientcar = new Convenientcar();
                $convenientcar->cars_id = $car->id;
                $convenientcar->convenients_id = $convenient;
                $convenientcar->save();
                }
            }
            Session::flash('flash_message', 'Đăng tin thành công');
        } catch (\Exception $th) {
            Session::flash('flash_message', 'Đăng tin thất bại');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);
        $convenientcars = Convenientcar::where('cars_id', $id)->get();

        return view('show', compact('car', 'convenientcars'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $convenients = Convenient::get();

        return view('edit', compact('car', 'convenients'));
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
            'hinhanh' => 'image',

        ]);

        $car = Car::findOrFail($id);

        if($request->hasFile('hinhanh')){
            $fileNameWithExt = $request->file('hinhanh')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('hinhanh')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('hinhanh')->storeAs('public/img/userfiles/'. md5(Auth::user()->id) . '/images', $fileNameToStore);
            $car->hinhanh = $fileNameToStore;
        }

        
        $car->ten = $request->name;

        $car->gia = $request->gia;
        $car->types_id = $request->type;
        $car->origins_id = $request->origin;
        $car->conditions_id = $request->condition;
        $car->locations_id = $request->location;
        $car->styles_id = $request->style;
        $car->transmissions_id = $request->transmission;
        $car->fuels_id = $request->fuel;
        $car->colors_id = $request->color;
        $car->furnitures_id = $request->furniture;

        $car->doixe = $request->doixe;
        $car->namsx = $request->namsx;
        $car->socua = $request->socua;
        $car->sochongoi = $request->sochongoi;
        $car->kichthuoc = $request->kichthuoc;
        $car->cannang = $request->cannang;
        $car->dungtich = $request->dungtich;
        $car->phanh = $request->phanh;
        $car->giamxoc = $request->giamxoc;
        $car->lopxe = $request->lopxe;
        $car->mota = $request->mota;

        $convenients = $request->convenient;

        $car->save();

        
        Convenientcar::where('cars_id', $id)->delete();

        if ($convenients != null){
            foreach($convenients as $convenient){
                $convenientcar = new Convenientcar();
                $convenientcar->cars_id = $car->id;
                $convenientcar->convenients_id = $convenient;
                $convenientcar->save();
            }
        }

        $convenientcars = Convenientcar::where('cars_id', $id)->get();

        Session::flash('flash_message', 'Cập nhật thành công');
        return view('show', compact('car', 'convenientcars'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->trangthai = 1;
        $car->save();

        return redirect()->route('home');
    }
}
