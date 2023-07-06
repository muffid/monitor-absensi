<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\AbsensiModel;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){
        $dataArray =[];
        $dateNow = Carbon::now();
        $formattedDate = $dateNow->format('Y-m-d');
        $id_user = "";
        $user = user::where('id', session()->get('id'))->first();
        if($user){
            $id_user = $user->id;
            $username = $user->username;
            $nama_lengkap = $user->nama_lengkap;
            $hash = md5(strtolower(trim($username)));
            $avatarUrl = "https://www.gravatar.com/avatar/{$hash}?d=retro";
        $absensi = AbsensiModel::where('id_user', $id_user)->where('tanggal','like',$formattedDate)->first();
        $status = '';
        $timeCounter = '';
        $selisihJam = '-';
        $selisihMenit = '-';
        $jamRest = '-';
        $menitRest = '-';
        $nama = $user->username;
        $fName = $user->nama_lengkap;
        $img = $user->img;
        $jamMasuk = $absensi && $absensi->masuk ? $absensi->masuk : '-';
        $jamPulang = $absensi && $absensi->pulang? $absensi->pulang : '-';
        $jamRehat = $absensi && $absensi->rehat ? $absensi->rehat : '-';
        $jamKembali = $absensi && $absensi->kembali ? $absensi->kembali : '-';
        

        if($jamMasuk !== "-" && $jamPulang !== "-"){
           
         
            if($jamRehat == "-"){
               
                $status = "Pulang";
                $timeCounter = "off";
                $waktuMulai = Carbon::createFromFormat('H:i', $jamMasuk);
                $waktuSelesai = Carbon::createFromFormat('H:i', $jamPulang);
               
                $selisih = $waktuMulai->diff($waktuSelesai);
                $selisihJam = $selisih->h."j";
                $selisihMenit = $selisih->i."m";
                

            }else{
               
                $status = "Pulang";
                $timeCounter = "off";
                $waktuMulai = Carbon::createFromFormat('H:i', $jamMasuk);
                $waktuSelesai = Carbon::createFromFormat('H:i', $jamPulang);
                $selisih = $waktuMulai->diff($waktuSelesai);
                
                $mulaiRehat = Carbon::createFromFormat('H:i', $jamRehat);
                $mulaiKembali = Carbon::createFromFormat('H:i', $jamKembali);
                $selisiha = $mulaiRehat->diff($mulaiKembali);
  
                $waktuA = Carbon::createFromTime($selisih->h, $selisih->i); 
                $waktuB = Carbon::createFromTime($selisiha->h, $selisiha->i);

                $selisih = $waktuA->subHours($waktuB->hour)->subMinutes($waktuB->minute);

                $selisihJam = $selisih->hour."j";
                $selisihMenit = $selisih->minute."m";
               
                $jamRest = $waktuB->hour."j";
                $menitRest = $waktuB->minute."m";
               
            }

          
        }

        if($jamMasuk == "-"){
            $status = "Off Work";
            $timeCounter = "off";
          
        }

        if($jamMasuk !== "-" && $jamPulang == "-" && $jamRehat == "-" && $jamKembali == "-"){
            $status = "Kerja";
            $timeCounter = "on";
            $now = Carbon::now();
            $nowString = $now->format('H:i');
            $waktuSekarang = Carbon::createFromFormat('H:i',$nowString);
            $waktuMulai = Carbon::createFromFormat('H:i', $jamMasuk);
            $selisih = $waktuMulai->diffInMinutes($waktuSekarang);
            $selisihJam = floor($selisih / 60)."j";
            $selisihMenit = ($selisih % 60)."m"; 

        }

        if($jamMasuk !== "-" && $jamPulang == "-" && $jamRehat !== "-" && $jamKembali !== "-"){
            $addTime = 0;
            $status = "Kerja";
            $timeCounter = "on";
            $now = Carbon::now();
            $nowString = $now->format('H:i');
            $waktuSekarang = Carbon::createFromFormat('H:i',$nowString);
            $waktuMulai = Carbon::createFromFormat('H:i', $jamMasuk);
            $selisih = $waktuMulai->diff($waktuSekarang);
            
           

            $mulaiRehat = Carbon::createFromFormat('H:i', $jamRehat);
            $mulaiKembali = Carbon::createFromFormat('H:i', $jamKembali);
            $selisiha = $mulaiRehat->diff($mulaiKembali);
            $jamRest = $selisiha->h."j";
            $menitRest = $selisiha->i."m";

            $totalMenit = ($selisiha->h * 60) + $selisiha->i;

            if ($totalMenit > 30) {
               
                $addTime = 30;
            }

            $waktuA = Carbon::createFromTime($selisih->h, $selisih->i); 
            $waktuB = Carbon::createFromTime($selisiha->h, $selisiha->i);

            $selisih = $waktuA->subHours($waktuB->hour)->subMinutes(($waktuB->minute)-$addTime);

            $selisihJam = $selisih->hour."j"; 
            $selisihMenit = $selisih->minute."m";

            
        }
        if($jamRehat !== "-" && $jamKembali == "-"){
            $status = "Istirahat";
            $timeCounter = "off";
            $waktuMulai = Carbon::createFromFormat('H:i', $jamMasuk);
            $waktuSelesai = Carbon::createFromFormat('H:i', $jamRehat);
            $selisih = $waktuMulai->diff($waktuSelesai);
            $selisihJam = $selisih->h."j";
            $selisihMenit = $selisih->i."m";

            $now = Carbon::now();
            $nowString = $now->format('H:i');
            $waktuSekarang = Carbon::createFromFormat('H:i',$nowString);
            $waktuMulai = Carbon::createFromFormat('H:i', $jamRehat);
            $selisih = $waktuMulai->diffInMinutes($waktuSekarang);
            $jamRest = floor($selisih / 60)."j";
            $menitRest = ($selisih % 60)."m"; 

          

        }
       
    
        $dataAbsen = [
            'nama' => $nama,
            'nama_lengkap' => $fName,
            'img' => $img,
            'jam_masuk' => $jamMasuk,
            'jam_keluar' => $jamPulang,
            'jam_rest' => $jamRehat,
            'jam_kembali' => $jamKembali,
            'rehat' => $jamRehat,
            'kembali' => $jamKembali,
            'status' => $status,
            'cat' => $timeCounter,
            'jam' => $selisihJam,
            'menit' => $selisihMenit,
            'jam_rehat' => $jamRest,
            'menit_rehat' => $menitRest,
        ];
    
       
    }
    $dateNow = Carbon::now()->format('Y-m');
        $data = [
            'username' => $username,
            'nama_lengkap' => $nama_lengkap,
            'img' => $avatarUrl,
            'date' => $dateNow,
            'absensi' => $dataAbsen,
        ];

      
        return view('user/user',compact('data'));
        // return "system under development, be patient :)";
    }
}
