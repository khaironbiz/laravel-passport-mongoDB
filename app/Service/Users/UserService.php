<?php

namespace App\Service\Users;

use App\Models\User;

class UserService
{
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


}
