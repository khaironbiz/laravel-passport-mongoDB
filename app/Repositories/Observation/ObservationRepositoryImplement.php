<?php

namespace App\Repositories\Observation;

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
    public function findById(string $observation_id){
        $observation    = $this->model->where('_id', $observation_id)->first();
        $data           = $this->__observation($observation);
        return $data;
    }
    private function __observation(object $observation){
        $data_user = [
            'id'            => $observation->_id,
            'value'         => $observation->value,
            'unit'          => $observation->unit,
            'time'          => $observation->time
        ];
        return $data_user;
    }

    // Write something awesome :)
}
