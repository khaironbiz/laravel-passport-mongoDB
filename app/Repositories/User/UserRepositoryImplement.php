<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByIdShort(string $user_id){
        $user       = $this->model->where('_id',$user_id)->first();
        $data_user  = $this->__userShort($user);
        return $data_user;
    }
    public function findByEmail(string $email){
        $user       = $this->model->where('kontak.email',$email)->first();
        $data_user  = $this->__user($user);
        return $data_user;
    }
    public function findByNIK(int $nik){
        $user       = $this->model->where('nik',$nik)->first();
        $data_user  = $this->__user($user);
        return $data_user;
    }
    public function profile(string $user_id){
        $user = $this->model->find($user_id);
        $data_profile = $this->__user($user);
        return $data_profile;
    }
    private function __user(object $user){
        $data_user = [
            'id'            => $user->_id,
            'nama_depan'    => $user->nama['nama_depan'],
            'nama_belakang' => $user->nama['nama_belakang'],
            'gender'        => $user->gender
        ];
        return $data_user;
    }
    private function __userShort(object $user){
        $data_user = [
            'id'            => $user->_id,
            'nama_depan'    => $user->nama['nama_depan'],
            'nama_belakang' => $user->nama['nama_belakang'],
            'nik'           => $user->nik,
            'email'         => $user->kontak['email']
        ];
        return $data_user;
    }

    // Write something awesome :)
}
