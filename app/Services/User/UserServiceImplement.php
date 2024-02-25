<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\Service;
use App\Repositories\User\UserRepository;

class UserServiceImplement extends Service implements UserService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function findByIdShort($user_id){
        try {
            return $this->mainRepository->findByIdShort($user_id);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }
    public function findByEmail($email){
        try {
            return $this->mainRepository->findByEmail($email);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }
    public function findByNIK($nik){
        try {
            return $this->mainRepository->findByNIK($nik);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }
    public function profile($user_id){
        try {
            return $this->mainRepository->profile($user_id);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    // Define your custom methods :)
}
