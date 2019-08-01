<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Brand;
use App\Type;
use App\Condition;
use App\Origin;
use App\Transmission;
use App\Fuel;
use App\Style;
use App\Color;
use App\Car;
use App\Contact;

use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->except('index', 'getTypes');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cars = Car::where('trangthai', 0)->orderBy('created_at', 'DESC')->get();
        $conditions = Condition::get();

        return view('welcome', compact('cars', 'conditions'));
    }

    public function getLocations() {
        $data = Location::get();
        return json_encode($data);
    }
    public function getBrands() {
        $data = Brand::get();
        return json_encode($data);
    }
    public function getTypes() {
        $data = Type::get();
        return json_encode($data);
    }
    public function getConditions() {
        $data = Condition::get();
        return json_encode($data);
    }
    public function getOrigins() {
        $data = Origin::get();
        return json_encode($data);
    }
    public function getTransmissions() {
        $data = Transmission::get();
        return json_encode($data);
    }
    public function getFuels() {
        $data = Fuel::get();
        return json_encode($data);
    }
    public function getStyles() {
        $data = Style::get();
        return json_encode($data);
    }
    public function getColors() {
        $data = Color::get();
        return json_encode($data);
    }

    public function search(Request $request) {
        $search = Car::where('trangthai', 0)->orderBy('created_at', 'DESC');
        if (!empty($request->name)) {
            $search->where('ten', 'LIKE', '%' . $request->name . '%');
        }
        if (!empty($request->location)) {
            $search->where('locations_id', $request->location);
        }
        if (!empty($request->brand)) {
            if (!empty($request->type)) {
                $search->where('types_id', $request->type);
            } else {
                $types = Type::where('brands_id', $request->brand)->pluck('id');
                $search->whereIn('types_id', $types);
            }
        }
        if (!empty($request->namsx_s)) {
            $search->where('namsx', '>=', $request->namsx_s);
        }
        if (!empty($request->namsx_e)) {
            $search->where('namsx', '<=', $request->namsx_e);
        }
        if (!empty($request->gia_s)) {
            $search->where('gia', '>=', $request->gia_s * 1000000);
        }
        if (!empty($request->gia_e)) {
            $search->where('gia', '<=', $request->gia_e * 1000000);
        }
        if (!empty($request->condition)) {
            $search->whereIn('conditions_id', $request->condition);
        }
        $cars = $search->get();
        $conditions = Condition::get();
        return view('welcome', compact('cars', 'conditions'))->withName($request->name)->withLocation($request->location)->withBrand($request->brand)->withType($request->type)->withNamsxS($request->namsx_s)->withNamsxE($request->namsx_e)->withGiaS($request->gia_s)->withGiaE($request->gia_e)->withTinhtrang($request->condition);
    }

    public function contact(Request $request) {
        $contact = new Contact();
        $contact->users_id = $request->user;
        $contact->ten = $request->name;
        $contact->email = $request->email;
        $contact->sdt = $request->sdt;
        $contact->noidung = $request->noidung;
        $contact->save();

        Session::flash('flash_message', 'Gửi thông tin liên hệ thành công');

        return back();
    }
}
