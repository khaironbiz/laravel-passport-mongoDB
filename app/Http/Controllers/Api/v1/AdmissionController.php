<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\UserResource;
use App\Models\Admission;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $admission      = Admission::all();
        $data_admission = AdmissionResource::collection($admission);
        $data   = [
            "status"        => "success",
            "status_code"   => 200,
            "time"          => time(),
            "data"          => [
                'count'         => $data_admission->count(),
                'admissions'    => $data_admission
            ]
        ];
        return response()->json($data,200);
    }
    public function store(Request $request)
    {
        $validator          = Validator::make($request->all(), [
            'id_faskes'     => 'required',
            'id_pasien'     => 'required',
            'id_service'    => 'required',
            'date'          => 'required'
        ]);
        if ($validator->fails()){
            $status         = "Gagal Validasi";
            $status_code    = 203;
            $message        = "Gagal Validasi";
            $data           = [
                "error"     => $validator->errors()
            ];
        }else{
            $user       = User::find($request->id_pasien);
            $customer   = Customer::find($request->id_faskes);
            $service    = Service::find($request->id_service);
            $data_input = [
                'pasien'        => [
                    'id'        => $user->_id,
                    'nama'      => $user->nama,
                    'lahir'     => $user->lahir,
                    'gender'    => $user->gender,
                    'nik'       => $user->nik,
                    'kontak'    => $user->kontak
                ],
                'faskes'        => [
                    'id'        => $customer->id,
                    'name'      => $customer->name
                ],
                'service'       => [
                    'id'        => $service->_id,
                    'name'      => $service->name,
                    'category'  => $service->category
                ],
                'date'          => $request->date,
                'status'        => 'pending'
            ];
            $admission = new Admission();
            $create     = $admission->create($data_input);
            if($create){
                $status         = "success";
                $status_code    = 200;
                $message        = "Admission created";
                $data           = [
                    "admission"     => $data_input
                ];
            }else{
                $status         = "Un success";
                $status_code    = 204;
                $message        = "Admission not created";
                $data           = [
                    "admission"     => $data_input
                ];
            }
        }
        $data   = [
            "status"        => $status,
            "status_code"   => $status_code,
            "time"          => time(),
            "data"          => $data
        ];
        return response()->json($data,$status_code);
    }
}
