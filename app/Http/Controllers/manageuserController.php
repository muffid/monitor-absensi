<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class manageuserController extends Controller
{
    private function getUsername(){
        $user = user::where('id', session()->get('id'))->first();
        if($user){
            $username = $user->username;
            return $username;
        }else{
            return null;
        }
    }

    private function getAllKaryawan(){
        $karyawan=[];
        $users = User::where('role','like','user')->get();
        foreach ($users as $user) {
            $id = $user->id;
            $nama = $user->username;
            $fullName = $user->nama_lengkap;
            $img = $user->img;
         
            $data = [
                'id' => $id,
                'nama' => $nama,
                'full_name' => $fullName,
                'img' => $img,
            ];

            $karyawan[] = $data;
        }
        return $karyawan;
    }

    public function index(){
        
        $data = [
            'username' => $this->getUsername(),
            'karyawan' => $this->getAllKaryawan(),
        ];
        return view('admin/manageuser',compact('data'));
    }
}
