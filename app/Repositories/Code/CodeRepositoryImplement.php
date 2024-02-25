<?php

namespace App\Repositories\Code;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Code;

class CodeRepositoryImplement extends Eloquent implements CodeRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Code $model)
    {
        $this->model = $model;
    }
    public function findByCode(string $code){
        $code = $this->model->where('code', $code)->first();
        if(empty($code)){
            $data_code = null;
        }else{
            $data_code = $this->__code($code);
        }
        return $code;
    }
    private function __code(object $code){
        $data_code  = [
            'id'    => $code->_id,
        ];
        return $data_code;
    }
    private function __category(object $code){
        $data_code  = [
            'category'    => $code->category,
        ];
        return $data_code;
    }


    // Write something awesome :)
}
