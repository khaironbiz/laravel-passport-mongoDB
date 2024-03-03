<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Kit;
use App\Models\Observation;
use App\Models\User;
use App\Services\Code\CodeService;
use App\Services\Observation\ObservationService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HemoGlobinController extends Controller
{
    private ObservationService $observationService;
    private UserService $userService;

    private CodeService $codeService;

    public function __construct(ObservationService $observationService,  UserService $userService, CodeService $codeService) {
        $this->observationService = $observationService;
        $this->userService= $userService;
        $this->codeService= $codeService;
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
        $code_observation   = "718-7";
        $data               = $this->observationService->observasiPasien($code_observation, $id_pasien, $limit, $page);
        $max_page           = $data['max_page'];

        if($page > $max_page){
            return $this->sendError('page melebihi batas');
        }else{
            $data['current_page']   = (int) $page;
            return $this->sendResponse($data,'success');
        }

    }
    public function getBynik(Request $request){
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16',
        ]);
        if ($validator->fails()) {
            return  $this->validationError("Gagal Validasi",$validator->errors());
        }
        $limit  = $request->limit< 1 ? 5 : $request->limit;
        $page   = $request->page< 1 ? 1 : $request->page;
        $nik    = (int) $request->nik;
        $pasien         = User::where('nik', $nik)->first();
        if(empty($pasien)){
            return $this->sendError('Pasien tidak ditemukan');
        }
        $id_pasien          = $pasien->_id;
        $code_observation   = "718-7";
        $data               = $this->observationService->observasiPasien($code_observation, $id_pasien, $limit, $page);
        $max_page           = $data['max_page'];

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
            'value'         => 'required|numeric|between:10,100',
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
        if($pasien->lahir != null){
            $usia_pasien    = $this->userService->usia($pasien->lahir['tanggal']);
        }else{
            $usia_pasien = null;
        }
        $data_pasien    = [
            'id'        => $pasien->_id,
            'nama'      => $pasien->nama,
            'gender'    => $pasien->gender,
            'nik'       => (int) $pasien->nik,
            'lahir'     => $pasien->lahir,
            'usia'      => $usia_pasien->original,
            'parent'    => $pasien->parent
        ];
        $code_observation   = "718-7";
        $code               = $this->codeService->findByCode($code_observation);
        $kit_code           = $petugas['kit']['kit_code'];
        $kit                = Kit::where('code', $kit_code)->first();
        $atm_sehat  = [
            'code'  => $kit->code,
            'name'  => $kit->name,
            'owner' => $kit->owner,
        ];
        $coding = [
            'code'      => $code->code,
            'display'   => $code->display,
            'system'    => $code->system
        ];
        $input          = [
            'value'         => $data['value'],
            'unit'          => $code['unit'],
            'id_pasien'     => $id_pasien,
            'pasien'        => $data_pasien,
            'id_petugas'    => $id_petugas,
            'atm_sehat'     => $atm_sehat,
            'time'          => time(),
            'coding'        => $coding,
            'category'      => $code['category'],
            'base_line'     => '',
            'interpretation'=> '',
        ];
        $create_observation = $this->observationService->simpan($input);
        if (empty($create_observation)){
            return $this->sendError('Gagal menyimpan data');
        }else{
            return $this->sendResponse($create_observation, 'success');
        }
    }

    public function null_pasien(){
        $time           = time()-(15*(24*60*60));
        $pasien         = Observation::where('time','>', $time)->orderBy('time', 'DESC')->get();
        $data_pbservasi = [
            'count'     => $pasien->count(),
            'data'      => $pasien
        ];
        return $data_pbservasi;
    }
    public function null_unit(){

        $pasien         = Observation::where('unit.display',null)->orderBy('time', 'DESC')->get();
        $data_pbservasi = [
            'count'     => $pasien->count(),
            'data'      => $pasien
        ];
        return $data_pbservasi;
    }
}
