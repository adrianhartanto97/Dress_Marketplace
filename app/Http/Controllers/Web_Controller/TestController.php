<?php

namespace App\Http\Controllers\Web_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Test_Service\Test;
use Illuminate\Http\Response;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use \stdClass;

class TestController extends Controller
{
    public function algoritma_FFA_PSNN(Request $request) {
        set_time_limit(86400);
        $data_raw = DB::table('data_training')->get();

        $intensitas_terbaik = -1;
        $indeks_terbaik = -1;

        //inisialisasi parameter
        $total_data = 500;
        $string = "";
        $n = 12;
        $J_sum = 4;
        $maks_epoch_ffa = 2;
        $maks_epoch_psnn = 50;
        $LR = 0.1;
        $jumlah_firefly = 3;
        $B0 = 0.4; //base beta (koefisien ketertarikan awal untuk setiap kunang-kunang)
        $g = 0.5; //gamma (koefisien penarik / pengundang kunang-kunang lain)
        $a = 0.5; //alpha

        //inisialisasi dataset
        $data = array();
        for ($i = 0 ; $i<$total_data;$i++) {
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
            $data[$i][13] = ($data_raw[$i]->recommendation);
            $data[$i][14] = $data_raw[$i]->dress_id;            
        }

        $daftar_firefly = array();
        //inisialisasi firefly
        for ($i = 0; $i < $jumlah_firefly; $i++) {
            $daftar_firefly[$i] = new stdClass();
            //init random weight
            $w = array();
            for ($k = 0; $k <= $n; $k++) {
                $w[$k] = array();
                $w_temp[$k] = array();
                for ($j = 1; $j <= $J_sum; $j++) {
                    $w[$k][$j] = rand (-1*100, 1*100) / 100;
                }
            }
            $daftar_firefly[$i]->w = $w;
            $daftar_firefly[$i]->intensitas = 0;
        }

        //hitung intensitas masing-masing firefly
        for ($i = 0; $i < $jumlah_firefly; $i++) {
            $daftar_firefly[$i] = $this->komputasi_psnn($data, $total_data, $daftar_firefly[$i], $maks_epoch_psnn, $J_sum, $LR, $n);
            $string = $string." intensitas : ".$daftar_firefly[$i]->intensitas."<br>";
            $string = $string." ---- true : ".$daftar_firefly[$i]->true_counter."<br>";
            // for ($k = 0; $k <= $n; $k++) {
            //     for ($l = 1; $l <= $J_sum; $l++) {
            //         $string = $string." k : ".$k." , l : ".$l." , weight : ".$daftar_firefly[$i]->w[$k][$l]."<br>";
            //     }
            // }
            if ($daftar_firefly[$i]->intensitas > $intensitas_terbaik) {
                $intensitas_terbaik = $daftar_firefly[$i]->intensitas;
                $indeks_terbaik = $i;
            }
        }
        $string = $string."<br>Intensitas terbaik sementara : ".$intensitas_terbaik;

        for ($e = 0; $e < $maks_epoch_ffa; $e++) {
            for ($i = 0; $i < $jumlah_firefly; $i++) { 
                for ($j = 0; $j < $jumlah_firefly; $j++) {
                    if ($daftar_firefly[$i]->intensitas < $daftar_firefly[$j]->intensitas) {
                        $r = 0.0;
                        for ($kk = 0; $kk <= $n; $kk++) {
                            for ($jj = 1; $jj <= $J_sum; $jj++) {
                                $r += ($daftar_firefly[$i]->w[$kk][$jj] - $daftar_firefly[$j]->w[$kk][$jj]) * ($daftar_firefly[$i]->w[$kk][$jj] - $daftar_firefly[$j]->w[$kk][$jj]);
                            }
                        }
                        $r = sqrt($r);

                        $beta = $B0 * exp((-1*$g) * $r * $r);

                        for ($kk = 0; $kk <= $n; $kk++) {
                            for ($jj = 1; $jj <= $J_sum; $jj++) {
                                $daftar_firefly[$i]->w[$kk][$jj] += $beta * ($daftar_firefly[$j]->w[$kk][$jj] - $daftar_firefly[$i]->w[$kk][$jj]);
                                $random = rand(0,100)/100;
                                $daftar_firefly[$i]->w[$kk][$jj] += $a * ($random - 0.5);

                                if ($daftar_firefly[$i]->w[$kk][$jj] > 1) {$daftar_firefly[$i]->w[$kk][$jj] = 1;}
                                if ($daftar_firefly[$i]->w[$kk][$jj] < -1) {$daftar_firefly[$i]->w[$kk][$jj] = -1;}
                            }
                        }

                        $daftar_firefly[$i] = $this->komputasi_psnn($data, $total_data, $daftar_firefly[$i], $maks_epoch_psnn, $J_sum, $LR, $n);
                        
                        if ($daftar_firefly[$i]->intensitas > $intensitas_terbaik) {
                            $intensitas_terbaik = $daftar_firefly[$i]->intensitas;
                            $indeks_terbaik = $i;
                            //$string = $string."<br>true : ".$daftar_firefly[$i]->true_counter."<br>";
                        }
                    }
                }
            }
        }
        $string = $string."<br>Intensitas terbaik final : ".$intensitas_terbaik." pada indeks : ".$indeks_terbaik."<br>";
        $string = $string."true terbaik : ".$daftar_firefly[$indeks_terbaik]->true_counter;

        return view('greetings', ['data' => $string]);
    }

    private function komputasi_psnn($data, $total_data, $firefly, $maks_epoch_psnn, $J_sum, $LR, $n)
    {   
        $w_temp = array();
        $RMSE_terbaik = 1000000;
        $true_counter_terbaik = -1;
        $weight_terbaik = array();

        for ($e = 0; $e < $maks_epoch_psnn; $e++) {        
            for ($p = 0; $p < $total_data; $p++) {
                $h = array();
                $pi = 1;
                for ($j = 1; $j <= $J_sum; $j++) {
                    $h[$j] = 0;
                    for ($k = 0; $k <= $n; $k++) {
                        $h[$j] += ($firefly->w[$k][$j] * $data[$p][$k]);
                    }
                    $pi *= $h[$j];                 
                }

                //aktivasi sigmoid
                $ex = round(exp(-1*$pi), 20);
                $y = round(1 / (1.0 + $ex) , 20);

                if ($y == 0) {
                    $y=0.000000000000000000001;
                }

                for ($k = 0; $k <= $n; $k++) {
                    for ($l = 1; $l <= $J_sum; $l++) {
                        $delta = $LR * ($data[$p][13] - $y) * ((1.0-$y) * $y) * $data[$p][$k];
                        $hj = 0;
                        $pi_h = 1;

                        for ($b = 0; $b <= $n; $b++) {
                            $hj += ($firefly->w[$b][$l] * $data[$p][$b]);
                        }
                        $pi_h = $pi / $hj;
                        $delta = round($delta*$pi_h, 20);

                        $w_temp[$k][$l] = round($firefly->w[$k][$l] + $delta, 20);
                        if ($w_temp[$k][$l] > 1) {$w_temp[$k][$l] = 1;}
                        if ($w_temp[$k][$l] < -1) {$w_temp[$k][$l] = -1;}
                        //$string = $string." k : ".$k." , l : ".$l. " , delta : ".$w_temp[$k][$l]."<br>";
                        //$string = $string. "delta : ".$w_temp[$k][$l]."<br>";
                    }
                }
                
                for ($k = 0; $k <= $n; $k++) {
                    for ($j = 1; $j <= $J_sum; $j++) {
                        $firefly->w[$k][$j] = $w_temp[$k][$j];                
                    }
                }

                //hitung MSE
                $nilai_kesalahan = 0;
                $y_temp = array();
                $true_counter=0;
                for ($pp = 0; $pp < $total_data; $pp++) {
                    $h = array();
                    $pi = 1;
                    for ($jj = 1; $jj <= $J_sum; $jj++) {
                        $h[$jj] = 0;
                        for ($kk = 0; $kk <= $n; $kk++) {
                            $h[$jj] += ($firefly->w[$kk][$jj] * $data[$pp][$kk]);
                        }
                        $pi *= $h[$jj];                 
                    }
                    //aktivasi sigmoid
                    $ex = round(exp(-1*$pi), 20);
                    $y = round(1 / (1.0 + $ex) , 20);

                    if ($y == 0) {
                        $y=0.000000000000000000001;
                    }
                    $y_temp[$pp] = $y;
                    if (round($y) == $data[$pp][13]) {
                        $true_counter++ ;
                    }

                    if (round($y) <> $data[$pp][13] ) {
                        $nilai_kesalahan += (round($y) - $data[$pp][13]) * (round($y) - $data[$pp][13]);
                    }
                }
                $RMSE = sqrt($nilai_kesalahan/$total_data);

                if ($RMSE < $RMSE_terbaik) {
                    $RMSE_terbaik = $RMSE;
                    $true_counter_terbaik = $true_counter;
                    $weight_terbaik = $firefly->w;
                }                 
            }
        }

        $firefly->intensitas = 1/$RMSE_terbaik;
        $firefly->w = $weight_terbaik;
        $firefly->true_counter = $true_counter_terbaik;
        return $firefly;
    }
    public function test()
    {
//         $test = new Test();
//         $cookie = cookie('name', $test->test());
// //        return view('pages.index', ['name' => 'AD', 'login' => 'Adrianzz'])->withCookie($cookie);
//         $response = new \Illuminate\Http\Response(view('pages.index', ['name' => 'AD', 'login' => 'Adrianzz']));
//         $response->withCookie($cookie);
//         return $response;
            set_time_limit(1800);

            $data_raw = DB::table('data_training')->get();
            $total_data = 500;
            $string = "";

            $data = array();
            for ($i = 0 ; $i<$total_data;$i++) {
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
                $data[$i][13] = ($data_raw[$i]->recommendation);
                $data[$i][14] = $data_raw[$i]->dress_id;
                
            }
            
            $n = 12; //12 atribut
            $J_sum = 4;
            $RMSE_terbaik = 1000000;

            //init random weight
            $w = array();
            $w_temp = array();
            for ($k = 0; $k <= $n; $k++) {
                $w[$k] = array();
                $w_temp[$k] = array();
                for ($j = 1; $j <= $J_sum; $j++) {
                    $w[$k][$j] = rand (-1*100, 1*100) / 100;
                    $w_temp[$k][$j] = 0;
                    //$string = $string.$w[$k][$j]."<br>";
                    // $w[$k][$j] = 0.51;
                }
            }

            $maks_epoch = 100;
           
            for ($e = 0; $e < $maks_epoch; $e++) { 
                
                for ($p = 0; $p < $total_data; $p++) {
                    $h = array();
                    $pi = 1;
                    for ($j = 1; $j <= $J_sum; $j++) {
                        $h[$j] = 0;
                        for ($k = 0; $k <= $n; $k++) {
                            $h[$j] += ($w[$k][$j] * $data[$p][$k]);
                        }
                        $pi *= $h[$j];                 
                    }
                    //aktivasi sigmoid
                    $ex = round(exp(-1*$pi), 20);
                    $y = round(1 / (1.0 + $ex) , 20);

                    if ($y == 0) {
                        $y=0.000000000000000000001;
                        //$string = $string."EXP : ".$ex." , PI : ".$pi." , y : ".$y."<br>";
                    }

                    // if ($y >= 0.5) {
                    //     $y=1.0;
                    // }
                    // else {
                    //     $y = 0.0;
                    // }

                    //$string = $string.($p+1).") EXP : ".$ex." , PI : ".$pi." , y : ".$y." , y_d : ".$data[$p][13]."<br>";
                    //$string = $string."y : ".$y."<br>";
                    //$string = $string.print_r($w);
                    

                    $LR = 0.1;
                    
                    for ($k = 0; $k <= $n; $k++) {
                        for ($l = 1; $l <= $J_sum; $l++) {
                            //$string = $string." k : ".$k." , l : ".$l. "  delta : ";
                            $delta = $LR * ($data[$p][13] - $y) * ((1.0-$y) * $y) * $data[$p][$k];
                            //$delta = (1.0 / $y);
                            $hj = 0;
                            $pi_h = 1;

                            for ($b = 0; $b <= $n; $b++) {
                                $hj += ($w[$b][$l] * $data[$p][$b]);
                            }
                            $pi_h = $pi / $hj;
                            // for ($a = 1; $a <= $n; $a++) {
                            //     if ($a != $l) {
                            //         $hj[$a] = 0;
                            //         for ($b = 0; $b <= $n; $b++) {

                            //             $hj[$a] += ($w[$b][$a] * $data[$p][$b]);
                            //         }
                            //         $pi_h *= $hj[$a]; 
                            //     }                   
                            // }
                            $delta = round($delta*$pi_h, 20);
                            //$string = $string." k : ".$k." , l : ".$l. " , delta : ".$delta."<br>";
                            
                            
                            $w_temp[$k][$l] = round($w[$k][$l] + $delta, 20);
                            if ($w_temp[$k][$l] > 1) {$w_temp[$k][$l] = 1;}
                            if ($w_temp[$k][$l] < -1) {$w_temp[$k][$l] = -1;}
                            //$string = $string." k : ".$k." , l : ".$l. " , delta : ".$w_temp[$k][$l]."<br>";
                            //$string = $string. "delta : ".$w_temp[$k][$l]."<br>";
                        }
                    }
                    
                    for ($k = 0; $k <= $n; $k++) {
                        for ($j = 1; $j <= $J_sum; $j++) {
                            $w[$k][$j] = $w_temp[$k][$j];                
                        }
                    }

                    //hitung MSE
                    $nilai_kesalahan = 0;
                    $y_temp = array();
                    $true_counter=0;
                    for ($pp = 0; $pp < $total_data; $pp++) {
                        $h = array();
                        $pi = 1;
                        for ($jj = 1; $jj <= $J_sum; $jj++) {
                            $h[$jj] = 0;
                            for ($kk = 0; $kk <= $n; $kk++) {
                                $h[$jj] += ($w[$kk][$jj] * $data[$pp][$kk]);
                            }
                            $pi *= $h[$jj];                 
                        }
                        //aktivasi sigmoid
                        $ex = round(exp(-1*$pi), 20);
                        $y = round(1 / (1.0 + $ex) , 20);
    
                        if ($y == 0) {
                            $y=0.000000000000000000001;
                            //$string = $string."EXP : ".$ex." , PI : ".$pi." , y : ".$y."<br>";
                        }
                        $y_temp[$pp] = $y;
                        if (round($y) == $data[$pp][13]) {
                            $true_counter++ ;
                        }

                        if (round($y) <> $data[$pp][13] ) {
                            //$nilai_kesalahan += 0.5 * (round($y) - $data[$pp][13]) * (round($y) - $data[$pp][13]);
                            //$nilai_kesalahan++; 
                            $nilai_kesalahan += (round($y) - $data[$pp][13]) * (round($y) - $data[$pp][13]);
                        }
                    }
                    $RMSE = sqrt($nilai_kesalahan/$total_data);

                    if ($RMSE < $RMSE_terbaik) {
                        $RMSE_terbaik = $RMSE;
                        $string = $string. "RMSE terbaik : ".$RMSE_terbaik."<br>";
                        $string = $string. "true : ".$true_counter."<br>";
                        // for ($pp = 0; $pp < $total_data; $pp++) {
                        //     $string=$string."y_prediksi : ".$y_temp[$pp]." , y_d : ".$data[$pp][13]."<br>";
                        // }
                    }                 
                }
                $string = $string."------------------------------------------------------------------------------------------------------------------------------------<br>";
            }
            // foreach ($data as $d) {
            //     $string = $string.$d->dress_id."<br>";
            // }
            
            return view('greetings', ['data' => $string]);
    }

    private function sigmoid_bipolar($x) {
        return (exp($x) - exp(-1*$x)) / (exp($x) + exp(-1*$x));
    }
    
    public function test2(Request $request)
    {
        $client = new Client();
        $value = $client->post('http://localhost/dress_marketplace/api/test', [
            'form_params' => [
                'name' => 'Adrian'
            ]
        ]);
        //$value = $request->cookie('name');
//        return view('pages.index', ['name' => json_decode($value->getBody())->name, 'login' => 'Adrianzz']);
         return view('pages.index', ['name' => json_decode($value->getStatusCode()), 'login' => 'Adrianzz']);
    }

    public function test3(Request $request) {
        // $daftar_firefly = array();
        // for ($i=0;$i<3;$i++) {
        //     $daftar_firefly[$i] = new stdClass();
        //     $daftar_firefly[$i]->intensitas = 1;
        //     $daftar_firefly[$i]->best = 2;
        // }
        // $string = "";
        // for ($i=0;$i<3;$i++) {
        //     $daftar_firefly[$i] = $this->hitung($daftar_firefly[$i]);
        //     $string = $string.($daftar_firefly[$i]->best)."<br>";
        // }
        
        return view('welcome');
    }

    private function hitung($firefly) {
        $firefly->intensitas+=5;
        $firefly->best++;
        return $firefly;
    }
}
