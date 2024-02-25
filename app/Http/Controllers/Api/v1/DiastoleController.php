<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Kit;
use App\Models\User;
use App\Services\Code\CodeService;
use App\Services\Observation\ObservationService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiastoleController extends Controller
{

    private ObservationService $observationService;
    private UserService $userService;

    private CodeService $codeService;

    public function __construct(ObservationService $observationService,  UserService $userService, CodeService $codeService) {
        $this->observationService = $observationService;
        $this->userService= $userService;
        $this->codeService= $codeService;
    }
    public function index(){

    }
    public function show(Request $request){
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
    public function get_systole(Request $request){
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
        $code_systole   = "8462-4";
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
    public function store(Request $request){
        $data       = $request->all();
        $validator  = Validator::make($data, [
            'value'         => 'required|numeric',
            'id_pasien'     => 'required|string|max:255',
            'id_petugas'    => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return $this->validationError('Gagal Validasi', $validator->errors());
        }
        $id_pasien  = $request->id_pasien;
        $id_petugas = $request->id_petugas;
        $pasien     = User::find($id_pasien);
        $petugas    = User::find($id_petugas);
        if(empty($pasien)){
            return $this->sendError("Pasien tidak ditemukan", $pasien);
        }elseif (empty($petugas)){
            return $this->sendError("Petugas tidak ditemukan", $petugas);
        }
        $code_diastole = "8462-4";
        $code       = $this->codeService->findByCode($code_diastole);
        $kit_code   = $petugas['kit']['kit_code'];
        $kit        = Kit::where('code', $kit_code)->first();
        return $kit;
        $coding = [
            'code'      => $code->code,
            'display'   => $code->display,
            'system'    => $code->system
        ];
        $input          = [
            'value'         => $data['value'],
            'unit'          => $code['unit'],
            'id_pasien'     => $id_pasien,
            'id_petugas'    => $id_petugas,
            'atm_sehat'     => $petugas['kit'],
            'time'          => time(),
            'coding'        => $coding,
            'category'      => $code['category'],
            'base_line'     => 'badse',
            'interpretation'=> 'imp',
        ];
        $create_observation = $this->observationService->simpan($input);
        if (empty($create_observation)){
            return $this->sendError('Gagal menyimpan data');
        }else{
            return $this->sendResponse($create_observation, 'success');
        }


    }
}
