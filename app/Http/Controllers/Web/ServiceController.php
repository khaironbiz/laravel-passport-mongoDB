<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;

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
        $services = Service::where('faskes_id', $id)->get();
        $data = [
            "title"     => "Service List",
            "class"     => "Service",
            "sub_class" => "list",
            "content"   => "layout.admin",
            "services"  => $services
        ];
        return view('user.service.faskes', $data);
    }
}
