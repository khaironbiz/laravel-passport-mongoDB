<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCategoryResource;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $id_faskes = $request->id_faskes;
        if(! empty($id_faskes)){
            $services = Service::where('faskes.id', $id_faskes)->get();
        }else{
            $services = Service::all();
        }
        if($services->count() < 1){
            $status_code    = 404;
            $message        = "Not Found";
            $data           = [
                "services"     => $services,
                "id_faskes"     => $id_faskes
            ];
        }else{
            $status_code    = 200;
            $message        = "Success";
            $data           = [
                "services"     => $services,
                "id_faskes"     => $id_faskes
            ];
        }
        $data_respons   = [
            "status_code"   => $status_code,
            "message"       => $message,
            "time"          => time(),
            "data"          => $data
        ];
        return response()->json($data_respons,$status_code);
    }
    public function service_category()
    {
        $code           = Code::where('category.code', 'service')->where('code', '!=', 'service')->get();
        $data_code      = ServiceCategoryResource::collection($code);
        $status_code    = 200;
        $message        = "Success";
        $data           = [
            "services_category"     => $data_code,
        ];

        $data_respons   = [
        "status_code"   => $status_code,
        "message"       => $message,
        "time"          => time(),
        "data"          => $data
        ];
        return response()->json($data_respons,$status_code);

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_faskes'         => 'required',
            'service_name'      => 'required',
            'service_category'  => 'required'
        ]);
        if ($validator->fails()) {
            $status_code = 422;
            $message = "Gagal validasi";
            $data = [
                "errors" => $validator->errors(),
                "input" => $request->all(),
            ];
        }else{
            $service_category = Code::where('code',$request->service_category)->first();
            $data_category  = [
                'code'      => $service_category->code,
                'system'    => $service_category->system,
                'display'   => $service_category->display
            ];
            $customer = Customer::find($request->id_faskes);
            $data_customer = [
                'id'    => $customer->_id,
                'name'  => $customer->name
            ];
            $data_input = [
                'faskes'    => $data_customer,
                'name'      => $request->service_name,
                'category'  => $data_category
            ];
            $service = new Service();
            $add = $service->create($data_input);
            if($add){
                $status_code = 200;
                $message = "Success";
                $data = [
                    "errors" => $validator->errors(),
                    "input" => $request->all(),
                ];
            }else{
                $status_code = 422;
                $message = "Gagal Save";
                $data = [
                    "errors" => $validator->errors(),
                    "input" => $request->all(),
                ];
            }
        }
        $data_respons   = [
            "status_code"   => $status_code,
            "message"       => $message,
            "time"          => time(),
            "data"          => $data
        ];
        return response()->json($data_respons,$status_code);
    }
}
