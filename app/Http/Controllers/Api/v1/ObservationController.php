<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObservationResource;
use App\Models\Kit;
use App\Models\User;
use App\Services\Code\CodeService;
use App\Services\Observation\ObservationService;
use App\Services\User\UserService;
use Database\Seeders\KitSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ObservationController extends Controller
{
    private ObservationService $observationService;
    private UserService $userService;

    private CodeService $codeService;

    public function __construct(ObservationService $observationService,  UserService $userService, CodeService $codeService) {
        $this->observationService = $observationService;
        $this->userService= $userService;
        $this->codeService= $codeService;
    }

    public function index(Request $request){
        $limit  = $request->limit< 1 ? 5 : $request->limit;
        $page   = $request->page< 1 ? 1 : $request->page;
        $data = $this->observationService->index($limit);
        $total_row      = $data['total'];
        $max_page       = round($total_row/$limit) ;
        if($page > $max_page){
            return $this->sendError('page melebihi batas');
        }else{
            $data['current_page']   = (int) $page;
            return $this->sendResponse($data,'success');
        }
    }
}
