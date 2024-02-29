<?php

namespace App\Repositories\Observation;

use App\Http\Resources\ObservationResource;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Observation;

class ObservationRepositoryImplement extends Eloquent implements ObservationRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Observation $model)
    {
        $this->model = $model;
    }

    public function index(){

    }

    public function getAll(int $limit){
        $observation    = $this->model->orderBy('time', 'DESC')->paginate($limit);
        $data           = ObservationResource::collection($observation);
        $total_row      = $data->total();
        $result         = [
            'total'         => (int) $total_row,
            'limit'         => $limit,
            'observation'   => $data
        ];
        return $result;
    }
    public function findById(string $observation_id){
        $observation    = $this->model->findOrFail($observation_id);
        $data           = $this->__observation($observation);
        return $data;
    }
    public function byIdPasien(string $id_patient, int $limit){
        $observation    = $this->model->where([
            'id_pasien'     => $id_patient
        ])->paginate($limit);
        $data = ObservationResource::collection($observation);
        $total_row      = $data->total();
        $result         = [
            'total'         => (int) $total_row,
            'limit'         => $limit,
            'observation'   => $data
        ];
        return $result;
    }
    public function observasiPasien(string $code, string $id_patient, int $limit){
        $observation    = $this->model->where([
            'coding.code'   => $code,
            'id_pasien'     => $id_patient
            ])->paginate($limit);
        $data = ObservationResource::collection($observation);
        $total_row      = $data->total();
        $result         = [
            'total'         => (int) $total_row,
            'limit'         => $limit,
            'observation'   => $data
        ];
        return $result;
    }
    private function __observation(object $observation){
        $data_user = [
            'id'            => $observation->_id,
            'value'         => $observation->value,
            'unit'          => $observation->unit,
            'time'          => $observation->time,
            'id_pasien'     => $observation->id_pasien,
            'id_pemeriksa'  => $observation->id_petugas,
            'coding'        => $observation->coding,
            'tempat_pemeriksaan'    => $observation->atm_sehat['owner'],
            'atm_sehat'     => $observation->atm_sehat['code'],
            'interpretation'=> $observation->interpretation,
            'base_line'     => $observation->base_line
        ];
        return $data_user;
    }

    // Write something awesome :)
}
