<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::all();
        dd($employee);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'   => 'required'
        ]);
        $user = User::where('nik', (int) $request->nik)->first();
        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }elseif($user == null){
            $status_code    = 404;
            $message        = "Not Found";
            $data = [
                'user' => $user,
            ];
        }else{
            $status_code    = 200;
            $message        = "success";
            $data = [
                'user' => $user,
            ];
        }
        $data_json = [
            "status_code"   => $status_code,
            "message"       => $message,
            "data"          => $data
        ];
        return response()->json($data_json, $status_code);
    }
}
