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
        $validator = Validator::make($request->all(), [
            'limit' => 'numeric',
            'page'  => 'numeric',
        ]);
        if ($validator->fails()) {
            return  $this->validationError("Gagal Validasi",$validator->errors());
        }
        $limit  = $request->limit< 1 ? 5 : $request->limit;
        $page   = $request->page< 1 ? 1 : $request->page;

        $data           = $this->observationService->index($limit);
        $total_row      = $data['total'];
        $max_page       = round($total_row/$limit)+1 ;
        if($page > $max_page){
            return $this->sendError('page melebihi batas');
        }else{
            $data['current_page']   = (int) $page;
            return $this->sendResponse($data,'success');
        }
    }
    public function show(Request $request){
        $data       = $request->all();
        $validator  = Validator::make($data, [
            'observation_id'         => 'required',
        ]);
        if ($validator->fails()) {
            return $this->validationError('Gagal Validasi', $validator->errors());
        }
        $observation_id = $request->observation_id;
        $observation    = $this->observationService->showById($observation_id);
        if(empty($observation)){
            return $this->sendError('Not Found', $observation);
        }
        $pasien     = $this->userService->findByIdShort($observation['id_pasien']);
        $pemeriksa  = $this->userService->findByIdShort($observation['id_pemeriksa']);

        if (empty($pasien)){
            return $this->sendError('Not Found', $pasien);
        }else if(empty($pemeriksa)){
            return $this->sendError('Not Found', $pemeriksa);
        }else{
            $result = [
                'pasien'        => $pasien,
                'pemeriksa'     => $pemeriksa,
                'observation'   => $observation
            ];
            return $this->sendResponse($result, 'success');
        }
    }
    public function getByIdPasien(Request $request){
        $validator = Validator::make($request->all(), [
            'id_pasien' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return  $this->validationError("Gagal Validasi",$validator->errors());
        }
        $limit  = $request->limit< 1 ? 5 : $request->limit;
        $page   = $request->page< 1 ? 1 : $request->page;
        $id_pasien      = $request->id_pasien;
        $pasien         = User::find($id_pasien);
        if(empty($pasien)){
            return $this->sendError('Pasien tidak ditemukan');
        }
        $code_systole   = "8867-4";
        $data           = $this->observationService->observasiPasien($code_systole, $id_pasien, $limit);
        $total_row      = $data['total'];
        $max_page       = round($total_row/$limit)+1 ;
        if($page > $max_page){
            return $this->sendError('page melebihi batas');
        }else{
            $data['current_page']   = (int) $page;
            return $this->sendResponse($data,'success');
        }

    }
}
