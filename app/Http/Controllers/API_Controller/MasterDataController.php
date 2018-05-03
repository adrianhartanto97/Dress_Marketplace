<?php

namespace App\Http\Controllers\API_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class MasterDataController extends Controller
{
    public function get_province_list(Request $request) {
        $data = DB::table('master_province')->select('province_id','province_name')->orderBy('province_name','asc')->get();

        return response()->json(['province'=>$data],200);
    }

    public function get_city_by_province(Request $request) {
        $data = DB::table('master_city')
                ->select('city_id','province_id','city_name','city_type','postal_code')
                ->where('province_id',$request->province_id)
                ->orderBy('city_name','asc')
                ->get();

        return response()->json(['city'=>$data],200);
    }

    public function get_courier_list(Request $request) {
        $data = DB::table('master_courier')->select('courier_id','courier_name','alias_name')->get();

        return response()->json(['courier'=>$data],200);
    }

    public function get_dress_attributes(Request $request) {
        $style = DB::table('product_style_attribute')->select('*')->get();
        $price = DB::table('product_price_attribute')->select('*')->get();
        $size = DB::table('product_size_attribute')->select('*')->get();
        $season = DB::table('product_season_attribute')->select('*')->get();
        $neckline = DB::table('product_neckline_attribute')->select('*')->get();
        $sleevelength = DB::table('product_sleevelength_attribute')->select('*')->get();
        $waiseline = DB::table('product_waiseline_attribute')->select('*')->get();
        $material = DB::table('product_material_attribute')->select('*')->get();
        $fabrictype = DB::table('product_fabrictype_attribute')->select('*')->get();
        $decoration = DB::table('product_decoration_attribute')->select('*')->get();
        $patterntype = DB::table('product_patterntype_attribute')->select('*')->get();
        
        return response()->json(
            [
                'style'=>$style, 
                'price'=>$price,
                'size'=>$size,
                'season'=>$season,
                'neckline'=>$neckline,
                'sleevelength'=>$sleevelength,
                'waiseline'=>$waiseline,
                'material'=>$material,
                'fabrictype'=>$fabrictype,
                'decoration'=>$decoration,
                'patterntype'=>$patterntype
            ], 200);
    }
}
