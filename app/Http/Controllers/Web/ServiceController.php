<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Service;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $data = [
            "title"     => "Service List",
            "class"     => "Service",
            "sub_class" => "list",
            "content"   => "layout.admin",
            "services"  => $services
        ];
        return view('user.service.index', $data);
    }
    public function faskes($id)
    {
        $services = Service::where('id_faskes', $id)->get();
        $data = [
            "title"     => "Service List",
            "class"     => "Service",
            "sub_class" => "list",
            "content"   => "layout.admin",
            "services"  => $services
        ];
        return view('user.service.faskes', $data);
    }

    public function create()
    {
        $service_category   = Code::where('category.code', 'service')->where('code', '!=','service')->get();
        $service = new Service();
        $data = [
            "title"     => "Create New Service",
            "class"     => "Service",
            "sub_class" => "Create",
            "content"   => "layout.admin",
            "service"   => $service,
            "service_category"  => $service_category
        ];
        return view('user.service.create', $data);
    }

    public function show($id)
    {
        $service            = Service::find($id);
        $service_category   = Code::where('category.code', 'service')->where('code', '!=','service')->get();
        $data = [
            "title"     => "Service List",
            "class"     => "Service",
            "sub_class" => "list",
            "content"   => "layout.admin",
            "service"   => $service,
            "service_category"  => $service_category
        ];
        return view('user.service.show', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_faskes'         => 'required',
            'service_name'      => 'required',
            'service_category'  => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('service.create')
                ->withErrors($validator)
                ->withInput();
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
                session()->flash('success', 'Service created');
                return back();
            }
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_faskes'         => 'required',
            'service_name'      => 'required',
            'service_category'  => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
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
            $service    = Service::find($id);
            $update     = $service->update($data_input);
            if($update){
                session()->flash('success', 'Service updated');
                return back();
            }
        }
    }

}
