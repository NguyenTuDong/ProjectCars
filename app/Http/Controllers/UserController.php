<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Car;
use App\Location;
use App\Contact;
use Auth;
use Session;

class UserController extends Controller
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
        $cars = Car::where('users_id', Auth::user()->id)->where('trangthai', 0)->orderBy('created_at', 'DESC')->get();
        $contacts = Contact::where('users_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('info', compact('cars', 'contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()){
            if ($id == Auth::user()->id) {
                return redirect()->route('user.index');
            }
        }
        $user = User::findOrFail($id);
        $cars = Car::where('users_id', $id)->where('trangthai', 2)->orderBy('created_at', 'DESC')->get();
        return view('user', compact('user', 'cars'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $locations = Location::get();
        return view('info-edit', compact('locations'));
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
        $user = User::findOrFail($id);
        $user->ten = $request->name;
        $user->diachi = $request->diachi;
        $user->locations_id = $request->location;
        $user->sdt = $request->sdt;
        $user->cmnd = $request->cmnd;
        $user->sodkkd = $request->sodkkd;
        $user->mst = $request->mst;
        $user->gioithieu = $request->gioithieu;
        $user->save();

        Session::flash('flash_message', 'Cập nhật thành công');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateCover(Request $request)
    {
        request()->validate([
            'cover' => 'image|required'
        ]);
        if($request->hasFile('cover')){
            $fileNameWithExt = $request->file('cover')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('cover')->storeAs('img/userfiles/'. md5(Auth::user()->id) . '/images/Cover', $fileNameToStore);

            $user = User::find(Auth::user()->id);

            $user->cover = $fileNameToStore;
            $user->save();
            Session::flash('flash_message', 'Cập nhật thành công');
            return back();
        }else {
            Session::flash('flash_message', 'Cập nhật thất bại');
            return back();
        }
    }

    public function updateAvatar(Request $request)
    {
        request()->validate([
            'avatar' => 'image|required'
        ]);
        if($request->hasFile('avatar')){
            $fileNameWithExt = $request->file('avatar')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('avatar')->storeAs('img/userfiles/'. md5(Auth::user()->id) . '/images/Avatar', $fileNameToStore);

            $user = User::find(Auth::user()->id);

            $user->avatar = $fileNameToStore;
            $user->save();
            Session::flash('flash_message', 'Cập nhật thành công');
            return back();
        }else {
            Session::flash('flash_message', 'Cập nhật thất bại');
            return back();
        }
    }
}
