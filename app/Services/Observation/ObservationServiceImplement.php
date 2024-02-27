<?php

namespace App\Services\Observation;

use App\Models\Observation;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use LaravelEasyRepository\Service;
use App\Repositories\Observation\ObservationRepository;

/**
 *
 */
class ObservationServiceImplement extends Service implements ObservationService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $observationRepository;

    public function __construct(ObservationRepository $observationRepository)
    {
      $this->observationRepository = $observationRepository;
    }
    public function index($limit){
        try {
            return $this->observationRepository->getAll($limit);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    public function simpan($data){
        $validator = Validator::make($data, [
            'value'         => 'required|numeric',
            'unit'          => 'required',
            'id_pasien'     => 'required|string|max:255',
            'id_petugas'    => 'required|string|max:255',
            'atm_sehat'     => 'required',
            'time'          => 'required',
            'coding'        => 'required',
            'category'      => 'required',


        ]);
        if ($validator->fails()) {
            Log::debug($validator->fails());
            return [];
        }else{
            $input          = [
                'value'         => $data['value'],
                'unit'          => $data['unit'],
                'id_pasien'     => $data['id_pasien'],
                'id_petugas'    => $data['id_petugas'],
                'atm_sehat'     => $data['atm_sehat'],
                'time'          => $data['time'],
                'coding'        => $data['coding'],
                'category'      => $data['category'],
                'base_line'     => $data['base_line'],
                'interpretation'=> $data['interpretation'],
            ];
            $observation = new Observation();
            try {
                return $observation->create($input);
            }catch (\Exception $exception){
                Log::debug($exception->getMessage());
                return [];
            }
        }
    }
    public function observasiPasien($code, $id_pasien, $limit){
        try {
            return $this->observationRepository->observasiPasien($code, $id_pasien, $limit);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }
    public function showById($observation_id){
        try {
            return $this->observationRepository->findById($observation_id);
        }catch (\Exception $exception){
            Log::debug($exception->getMessage());
            return [];
        }
    }

    // Define your custom methods :)
}
