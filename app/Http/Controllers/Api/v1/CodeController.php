<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CodeResource;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodeController extends Controller
{
    public function index()
    {
        $codes = CodeResource::collection(Code::all()) ;
        if(empty($codes))
        {
            return response()->json([
                'status_code'   => 404,
                'message'       => 'Not Found'
            ],404);
        }else{
            return response()->json([
                'status_code'   => 200,
                'message'       => 'success',
                'data'          => [
                    "codes"     => $codes
                ]
            ],200);
        }

    }
    public function show($id)
    {
        $code = Code::where('code', $id)->first();
        if(empty($code)){
            return response()->json([
                    'status_code'   => 404,
                    'message'       => 'Not Found'
                ],404);
        }else{
            return response()->json([
                'status_code'   => 200,
                'message'       => 'success',
                'data'       => [
                    'code'      => $code->code,
                    'system'    => $code->system,
                    'display'   => $code->display
                ]
            ],200);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'      => 'required|unique:codes,_id',
            'system'    => 'required',
            'display'   => 'required'
        ]);
        $input      = [
            'code'       => $request->code,
            'system'    => $request->system,
            'display'   => $request->display
        ];
        if($validator->fails()){
            return response()->json([
                'status_code'   => 422,
                'message'       => 'Gagal validasi',
                'data'          =>[
                    'errors'       => $validator->errors()
                ]

            ],422);
        }else{
            $code       = new Code();
            $create     = $code->insert($input);
            if($create){
                $data   = [
                    'status_code'   => 201,
                    'message'       => 'success'
                ];
                return response()->json($data, 200);
            }
        }
    }
    public function update(Request $request){
        $codes = Code::where('code', $request->code)->first();
        $data_update = [
            'code'      => $request->code,
            'display'   => $request->display,
            'system'    => $request->system,
            'category'  => $request->category,
            'unit'      => $request->unit,
        ];
        $update     = $codes->update($data_update);
        if($update){
            $status_code    = 200;
            $message        = "Success";
            $data           = [
                'code'      => $data_update
            ];
        }else{
            $status_code    = 400;
            $message        = "Bad request";
            $data           = [
                'code'      => $data_update
            ];
        }
        return response()->json([
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ]);

    }
}
