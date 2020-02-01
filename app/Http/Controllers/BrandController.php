<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Brand::where('trangthai', 0)->paginate(10);
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
            'logo' => 'image',
        ]);

        function vn_to_str($str){
            $unicode = array(
                'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
                'd'=>'đ',
                'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'i'=>'í|ì|ỉ|ĩ|ị',
                'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
                'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'D'=>'Đ',
                'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
                'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            );
            foreach($unicode as $nonUnicode=>$uni){
                $str = preg_replace("/($uni)/i", $nonUnicode, $str);
            }
            $str = str_replace(' ','_',$str);
            return $str;
        }

        $brand = new Brand();

        $name = vn_to_str($request->name);

        if($request->hasFile('logo')){
            $fileNameWithExt = $request->file('logo')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = 'logo'.strtolower($name).'_'.date('YmdHi').'.'.$extension;
            $path = $request->file('logo')->storeAs('img/logo', $fileNameToStore);
            $brand->logo = $fileNameToStore;
        }
        $brand->ten = $request->name;

        $brand->save();
        return response($brand, 201);
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
            'logo' => 'image',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->ten = $request->name;

        if($request->hasFile('logo')){
            $fileNameWithExt = $request->file('logo')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $fileNameToStore = 'logo'.strtolower($request->name).'.'.$extension;
            $path = $request->file('logo')->storeAs('img/logo', $fileNameToStore);
            $brand->logo = $fileNameToStore;
        }

        $brand->save();
        return response($brand, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->trangthai = 1;
        $brand->save();
        return response($brand, 200);
    }
}
