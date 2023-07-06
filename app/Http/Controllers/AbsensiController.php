<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AbsensiModel;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;



class AbsensiController extends Controller
{


    private function getAllKaryawan(){
        $karyawan=[];
        $users = User::where('role','like','user')->get();
        foreach ($users as $user) {
            $id = $user->id;
            $nama = $user->username;
            $fullName = $user->nama_lengkap;
            $hash = md5(strtolower(trim($nama)));
            $avatarUrl = "https://www.gravatar.com/avatar/{$hash}?d=retro";
            $data = [
                'id' => $id,
                'nama' => $nama,
                'full_name' => $fullName,
                'img' => $avatarUrl,
            ];

            $karyawan[] = $data;
        }
        return $karyawan;
    }

    private function getAbsensiByMonth($month){

    }

    
    private function handleError(){
        $dateNow = Carbon::now()->format('Y-m');
        $user = user::where('id', session()->get('id'))->first();
        if($user){
            $username = $user->username;
        }
        $data = [
            'username' => $username,
            'karyawan' => $this->getAllKaryawan(),
            'date' => $dateNow,
        ];
        return $data;
    }

    public function index(){
        $dateNow = Carbon::now()->format('Y-m');
        $user = user::where('id', session()->get('id'))->first();
        if($user){
            $username = $user->username;
        }
        $data = [
            'username' => $username,
            'karyawan' => $this->getAllKaryawan(),
            'date' => $dateNow,
        ];
        return view('admin/absensi',compact('data'));
    }

    public function getInfo($idencrypt, $date){
        try{
            $id = decrypt($idencrypt);
        }catch(DecryptException $e){
            $data = $this->handleError();
            return view('admin/absensi',compact('data'));
        }
       
        $absensi = AbsensiModel::where('id_user', $id)->where('tanggal','like',$date.'%')->where('pulang','not like',"")->orderBy('tanggal', 'asc')->get();
        $normalKerja = 8;
        $dataTable = [];
        $arrTanggal = [];
        $arrMasuk = [];
        $arrPulang = [];
        $arrRehat = [];
        $arrKembali = [];
        $arrJamNormalKerja = [];
        $arrLamaKerjaJamOnly = [];
        $arrOvertimeJamOnly = [];
        $arrLamaRehatJamOnly = [];
        $arrLamaRehatMinOnly = [];
        
            foreach ($absensi as $data) {
                $arrTanggal [] = $data->tanggal;
                $arrMasuk [] = $data->masuk;
                $arrPulang [] = $data->pulang;
                $arrRehat [] = $data->rehat;
                $arrKembali [] = $data->kembali;
                //jika ada istirahat
                if($data->rehat === "0"){
                    $jamMasuk = Carbon::createFromFormat('H:i', $data->masuk);
                    $jamPulang = Carbon::createFromFormat('H:i', $data->pulang);
                    $selisihKerja = $jamMasuk->diffInMinutes($jamPulang);
                    $lamaKerjaJamOnly = intval(floor($selisihKerja / 60));
                    $arrLamaKerjaJamOnly [] = $lamaKerjaJamOnly;
                    $arrLamaRehatJamOnly [] = 0;
                    $arrLamaRehatMinOnly [] = 0;
                    if($lamaKerjaJamOnly > $normalKerja){
                        //overtime
                        
                        $arrJamNormalKerja[] = $normalKerja;

                        $arrOvertimeJamOnly [] = $lamaKerjaJamOnly - $normalKerja;
                    }else{
                        //tidak overtime
                        $arrJamNormalKerja[] = $lamaKerjaJamOnly;
                        $arrOvertimeJamOnly [] = 0;
                    }
                    
                }else{

                    //jika ada istirahat
                    $jamMasuk = Carbon::createFromFormat('H:i', $data->masuk);
                    $jamPulang = Carbon::createFromFormat('H:i', $data->pulang);
                    $selisihKerja = $jamMasuk->diffInMinutes($jamPulang);

                    $jamRehat = Carbon::createFromFormat('H:i', $data->rehat);
                    $jamKembali = Carbon::createFromFormat('H:i', $data->kembali);
                    $selisihRehat = $jamRehat->diffInMinutes($jamKembali);

                    $hoursSelRehat = floor($selisihRehat / 60);
                    $minutesSelRehat = $selisihRehat % 60;

                    $actualKerja = $selisihKerja - $selisihRehat;
                    
                    $hoursKerja = floor($actualKerja / 60);
                    $minutesKerja = $actualKerja % 60;

                    $time = Carbon::createFromTime($hoursKerja, $minutesKerja);
                    
                    $arrLamaKerjaJamOnly [] = $hoursKerja;
                    $arrLamaRehatJamOnly [] = $hoursSelRehat;
                    $arrLamaRehatMinOnly [] = $minutesSelRehat;
                    
                    if($hoursKerja > $normalKerja){
                        //overtime
                        $arrJamNormalKerja[] = $normalKerja;
                        $arrOvertimeJamOnly [] = $hoursKerja - $normalKerja;
                    }else{
                        //tidak overtime
                        $arrJamNormalKerja[] = $hoursKerja;
                        $arrOvertimeJamOnly [] = 0;
                    }
                    
                }
            }
            $dataTable = [
                'Tanggal' => $arrTanggal,
                'Masuk' => $arrMasuk,
                'Pulang' => $arrPulang,
                'Rehat' => $arrRehat,
                'Kembali' => $arrKembali,
                'Jam_Kerja' => $arrJamNormalKerja,
                'Jam_Kerja_Actual' => $arrLamaKerjaJamOnly,
                'Overtime' => $arrOvertimeJamOnly,
                'Jam_Rehat' => $arrLamaRehatJamOnly,
                'Min_Rehat' => $arrLamaRehatMinOnly,
            ];

            $tot_Jam = 0;
            $tot_actual = 0;
            $tot_overtime = 0;
            foreach($arrJamNormalKerja as $tot){
                $tot_Jam +=$tot;
            }
            foreach($arrLamaKerjaJamOnly as $tot){
                $tot_actual +=$tot;
            }
            foreach($arrOvertimeJamOnly as $tot){
                $tot_overtime +=$tot;
            }

            $dataRekap = [
                'Total_Jam' => $tot_Jam,
                'Total_Actual' => $tot_actual,
                'Total_Over' => $tot_overtime,
            ];
            // dd($arrOvertimeJamOnly);
           
       
        $karyawan = User::where('id','like',$id)->get();
        $arrKaryawan=$karyawan->toArray();
        $hash = md5(strtolower(trim($arrKaryawan[0]['username'])));
        $avatarUrl = "https://www.gravatar.com/avatar/{$hash}?d=retro";
        $user = user::where('id', session()->get('id'))->first();
        if($user){
            $username = $user->username;
        }
        $data = [
            'username' => $username,
            'id' => $id,
            'nama' => $arrKaryawan[0]['username'],
            'nama_lengkap' => $arrKaryawan[0]['nama_lengkap'],
            'img' =>$avatarUrl,
            'date' => $date,
            'karyawan' => $this->getAllKaryawan(), 
            'tabel' => $dataTable,
            'rekap' => $dataRekap,
        ];
            return view('admin/absensi_personal',compact('data'));
     
    }

    public function getMyAbsen($date){
        $absensi = AbsensiModel::where('id_user', session()->get('id'))->where('tanggal','like',$date.'%')->where('pulang','not like',"")->orderBy('tanggal', 'asc')->get();
        $normalKerja = 8;
        $dataTable = [];
        $arrTanggal = [];
        $arrMasuk = [];
        $arrPulang = [];
        $arrRehat = [];
        $arrKembali = [];
        $arrJamNormalKerja = [];
        $arrLamaKerjaJamOnly = [];
        $arrOvertimeJamOnly = [];
        $arrLamaRehatJamOnly = [];
        $arrLamaRehatMinOnly = [];
        
            foreach ($absensi as $data) {
                $arrTanggal [] = $data->tanggal;
                $arrMasuk [] = $data->masuk;
                $arrPulang [] = $data->pulang;
                $arrRehat [] = $data->rehat;
                $arrKembali [] = $data->kembali;
                //jika ada istirahat
                if($data->rehat === "0"){
                    $jamMasuk = Carbon::createFromFormat('H:i', $data->masuk);
                    $jamPulang = Carbon::createFromFormat('H:i', $data->pulang);
                    $selisihKerja = $jamMasuk->diffInMinutes($jamPulang);
                    $lamaKerjaJamOnly = intval(floor($selisihKerja / 60));
                    $arrLamaKerjaJamOnly [] = $lamaKerjaJamOnly;
                    $arrLamaRehatJamOnly [] = 0;
                    $arrLamaRehatMinOnly [] = 0;
                    if($lamaKerjaJamOnly > $normalKerja){
                        //overtime
                        
                        $arrJamNormalKerja[] = $normalKerja;

                        $arrOvertimeJamOnly [] = $lamaKerjaJamOnly - $normalKerja;
                    }else{
                        //tidak overtime
                        $arrJamNormalKerja[] = $lamaKerjaJamOnly;
                        $arrOvertimeJamOnly [] = 0;
                    }
                    
                }else{

                    //jika ada istirahat
                    $jamMasuk = Carbon::createFromFormat('H:i', $data->masuk);
                    $jamPulang = Carbon::createFromFormat('H:i', $data->pulang);
                    $selisihKerja = $jamMasuk->diffInMinutes($jamPulang);

                    $jamRehat = Carbon::createFromFormat('H:i', $data->rehat);
                    $jamKembali = Carbon::createFromFormat('H:i', $data->kembali);
                    $selisihRehat = $jamRehat->diffInMinutes($jamKembali);

                    $hoursSelRehat = floor($selisihRehat / 60);
                    $minutesSelRehat = $selisihRehat % 60;

                    $actualKerja = $selisihKerja - $selisihRehat;
                    
                    $hoursKerja = floor($actualKerja / 60);
                    $minutesKerja = $actualKerja % 60;

                    $time = Carbon::createFromTime($hoursKerja, $minutesKerja);
                    
                    $arrLamaKerjaJamOnly [] = $hoursKerja;
                    $arrLamaRehatJamOnly [] = $hoursSelRehat;
                    $arrLamaRehatMinOnly [] = $minutesSelRehat;
                    
                    if($hoursKerja > $normalKerja){
                        //overtime
                        $arrJamNormalKerja[] = $normalKerja;
                        $arrOvertimeJamOnly [] = $hoursKerja - $normalKerja;
                    }else{
                        //tidak overtime
                        $arrJamNormalKerja[] = $hoursKerja;
                        $arrOvertimeJamOnly [] = 0;
                    }
                    
                }
            }
            $dataTable = [
                'Tanggal' => $arrTanggal,
                'Masuk' => $arrMasuk,
                'Pulang' => $arrPulang,
                'Rehat' => $arrRehat,
                'Kembali' => $arrKembali,
                'Jam_Kerja' => $arrJamNormalKerja,
                'Jam_Kerja_Actual' => $arrLamaKerjaJamOnly,
                'Overtime' => $arrOvertimeJamOnly,
                'Jam_Rehat' => $arrLamaRehatJamOnly,
                'Min_Rehat' => $arrLamaRehatMinOnly,
            ];

            $tot_Jam = 0;
            $tot_actual = 0;
            $tot_overtime = 0;
            foreach($arrJamNormalKerja as $tot){
                $tot_Jam +=$tot;
            }
            foreach($arrLamaKerjaJamOnly as $tot){
                $tot_actual +=$tot;
            }
            foreach($arrOvertimeJamOnly as $tot){
                $tot_overtime +=$tot;
            }

            $dataRekap = [
                'Total_Jam' => $tot_Jam,
                'Total_Actual' => $tot_actual,
                'Total_Over' => $tot_overtime,
            ];
            // dd($arrOvertimeJamOnly);
           
       
        $karyawan = User::where('id','like',session()->get('id'))->get();
        $arrKaryawan=$karyawan->toArray();
        $hash = md5(strtolower(trim($arrKaryawan[0]['username'])));
        $avatarUrl = "https://www.gravatar.com/avatar/{$hash}?d=retro";
        $user = user::where('id', session()->get('id'))->first();
        if($user){
            $username = $user->username;
        }
        $data = [
            'username' => $username,
            'id' => session()->get('id'),
            'nama' => $arrKaryawan[0]['username'],
            'nama_lengkap' => $arrKaryawan[0]['nama_lengkap'],
            'img' =>$avatarUrl,
            'date' => $date,
          
            'tabel' => $dataTable,
            'rekap' => $dataRekap,
        ];
            return view('user/myabsensi',compact('data'));
    
    }
}
