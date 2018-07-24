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

     public function get_sort_by_list(Request $request) {
        $data = DB::table('master_sort')->select('sort_id','sort_name','alias_name')->get();

        return response()->json(['sort'=>$data],200);
    }

    private function sigmoid_bipolar($x) {
        // return (exp($x) - exp(-1*$x)) / (exp($x) + exp(-1*$x));
        return (1 - exp(-1*$x)) / (1 + exp(-1*$x));
    }

    public function generate_recommendation (Request $request)
    {
        set_time_limit(86400);
        $param_id = $request->param_id;
        $n = 12;
        $J_sum = (int) (DB::table('param_settings')
                ->where('id',$param_id)
                ->first()->param_summing_units);

        $weight_set = DB::table('param_settings_weight_set')
                ->where('id',$param_id)
                ->get();
        $data_raw = DB::table('view_generate_recommendation')->get();

        $data = array();
        for ($i = 0 ; $i<sizeof($data_raw);$i++) {
            $data[$i] = array();
            $data[$i][0] = 1;
            $data[$i][1] = $this->sigmoid_bipolar($data_raw[$i]->style);
            $data[$i][2] = $this->sigmoid_bipolar($data_raw[$i]->price);
            $data[$i][3] = $this->sigmoid_bipolar($data_raw[$i]->rating);
            $data[$i][4] = $this->sigmoid_bipolar($data_raw[$i]->size);
            $data[$i][5] = $this->sigmoid_bipolar($data_raw[$i]->season);
            $data[$i][6] = $this->sigmoid_bipolar($data_raw[$i]->neck_line);
            $data[$i][7] = $this->sigmoid_bipolar($data_raw[$i]->sleeve_length);
            $data[$i][8] = $this->sigmoid_bipolar($data_raw[$i]->waist_line);
            $data[$i][9] = $this->sigmoid_bipolar($data_raw[$i]->material);
            $data[$i][10] = $this->sigmoid_bipolar($data_raw[$i]->fabric_type);
            $data[$i][11] = $this->sigmoid_bipolar($data_raw[$i]->decoration);
            $data[$i][12] = $this->sigmoid_bipolar($data_raw[$i]->pattern_type);
            $data[$i][13] = 0;
            $data[$i][14] = $data_raw[$i]->dress_id;            
        }

        for ($p = 0; $p < sizeof($data_raw); $p++) {
            $h = array();
            $pi = 1;
            for ($j = 1; $j <= $J_sum; $j++) {
                $h[$j] = 0;
                for ($k = 0; $k <= $n; $k++) {
                    $weight = null;
                    foreach($weight_set as $struct) {
                        if ($k == $struct->node_i && $j == $struct->node_j) {
                            $weight = $struct->weight;
                            break;
                        }
                    }
                    $h[$j] += ($weight * $data[$p][$k]);
                }
                $pi *= $h[$j];                 
            }

            //aktivasi sigmoid
            $ex = round(exp(-1*$pi), 8);
            $y = round(1 / (1.0 + $ex) , 8);

            DB::beginTransaction();
            try {
                DB::table('product_size')
                ->where('product_id', $data_raw[$p]->dress_id)
                ->where('size_id', $data_raw[$p]->size)
                ->update(['recommendation' => $y]);

                DB::table('param_settings')
                    ->update(['status_use' => '0']);

                DB::table('param_settings')
                    ->where('id',$param_id)
                    ->update(['status_use' => '1']);

                DB::commit();
            }
            catch(Exception $error)
            {
                DB::rollback();
                $message = $error->getMessage();
            }
        }
    }
}
