<?php

namespace App\Service\Users;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public function register(Request $request){
        $user = new User();
        $input = [
            'nama_depan'    => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'username'      => $request->email,
            'kontak'        => [
                'email'     => $request->email,
            ],
            'password'      => bcrypt($request->password),
            'lahir'         => [
                'tempat'    => $request->tempat_lahir,
                'tanggal'   => $request->tanggal_lahir
            ]
        ];
        $create_user = $user->create($input);
        if($create_user){
            return $create_user;
        }else{
            return null;
        }

    }
    public function findByEmail($email){
        $user = User::where('email', $email)->first();
        if(!empty($user)){
            $data_user = [
                'id'        => $user->_id,
                'name'      => $user->name,
                'password'  => $user->password
            ];
        }else{
            $data_user = [];
        }
        return $data_user;
    }
    public function profile(){
        $user = \Illuminate\Support\Facades\Auth::user();
        $data = [
            "user_id"   => $user->_id,
            "name"      => ""

        ];
    }


}
