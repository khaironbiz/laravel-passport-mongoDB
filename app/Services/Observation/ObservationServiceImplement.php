<?php

namespace App\Services\Observation;

use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\Service;
use App\Repositories\Observation\ObservationRepository;

class ObservationServiceImplement extends Service implements ObservationService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(ObservationRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }
    public function findByCode($code){
        try {
            return $this->mainRepository->findByEmail($email);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    // Define your custom methods :)
}
