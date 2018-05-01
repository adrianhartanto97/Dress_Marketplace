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
}
