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
        $user       = User::find($request->id_pasien);
        $customer   = Customer::find($request->id_faskes);
        $service    = Service::find($request->id_service);
        if ($validator->fails()){
            $status_code    = 203;
            $message        = "Gagal Validasi";
            $data           = [
                "error"     => $validator->errors()
            ];
        }elseif(empty($user)) {
            $status_code    = 404;
            $message        = "Patient Not Found";
            $data           = [
                "input"     => $request->all()
            ];
        }elseif (empty($customer)) {
            $status_code    = 404;
            $message        = "Faskes Not Found";
            $data           = [
                "input"     => $request->all()
            ];
        }elseif(empty($service)) {
            $status_code    = 404;
            $message        = "Service Not Found";
            $data           = [
                "input"     => $request->all()
            ];
        }else{
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
                $status_code    = 200;
                $message        = "Admission created";
                $data           = [
                    "admission"     => $data_input
                ];
            }else{
                $status_code    = 204;
                $message        = "Admission not created";
                $data           = [
                    "admission"     => $data_input
                ];
            }
        }
        $data   = [
            "status_code"   => $status_code,
            "message"       => $message,
            "time"          => time(),
            "data"          => $data
        ];
        return response()->json($data,$status_code);
    }
}
