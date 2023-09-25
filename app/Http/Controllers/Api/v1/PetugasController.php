<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    public function index()
    {
        $user_db = User::where('level', 'petugas')->get();
        $user   = UserResource::collection($user_db);
        $data   = [
            "status"        => "success",
            "status_code"   => 200,
            "time"          => time(),
            "data"          => [
                'count'     => $user_db->count(),
                'users'     => $user
            ]
        ];
        return response()->json($data,200);
    }
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'nik'           => 'required',
            'id_customer' => 'required',
        ]);
        if ($validator->fails()){
            $status         = "Gagal Validasi";
            $status_code    = 203;
            $message        = "Gagal Validasi";
            $data           = [
                "error"     => $validator->errors()
            ];
        }else{
            $user = User::where('nik', (int) $request->nik);
            $customer   = Customer::find($request->id_customer);
            if($user->count()<1){
                $status         = "Not Found";
                $status_code    = 404;
                $message        = "Not Found";
                $data           = [
                    'user'      => $user->first(),
                    'customer'  => $customer
                ];
            }elseif(empty($customer)) {
                $status         = "Not Found";
                $status_code    = 404;
                $message        = "Customer Not Found";
                $data           = [
                    'user'      => $user->first(),
                    'customer'  => $customer
                ];
            }else{
                    $data_update = [
                        'level'         => 'petugas',
                        'organisasi'    => [
                            'id'        => $customer->_id,
                            'name'      => $customer->name,
                            'status'    => 'active'
                    ]
                    ];
                    $update = $user->update($data_update);
                    if($update){
                        $status         = "Success";
                        $status_code    = 200;
                        $message        = "New Petugas Created";
                        $data           = [
                            'user'      => $user->first(),
                            'customer'  => $customer
                        ];
                    }else{
                        $status         = "Success";
                        $status_code    = 200;
                        $message        = "New Petugas Created";
                        $data           = [
                            'user'      => $user->first(),
                            'customer'  => $customer
                        ];
                    }
            }
        }
        $data = [
            'status'        => $status,
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($data,$status_code);
    }


}
