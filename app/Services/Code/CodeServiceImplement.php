<?php

namespace App\Services\Code;

use LaravelEasyRepository\Service;
use App\Repositories\Code\CodeRepository;

class CodeServiceImplement extends Service implements CodeService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CodeRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function findByCode($code){
        $code = $this->mainRepository->findByCode($code);
        return $code;
    }

    // Define your custom methods :)
}
