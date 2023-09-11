<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\Customer;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users      = User::all();
        $codes      = Code::all();
        $petugas    = User::where('level', 'petugas')->get();
        $observation= Observation::all();
        $vital_sign = Observation::where('category.code','vital-signs')->get();
        $laboratory = Observation::where('category.code','laboratory')->get();
        $customer   = Customer::all();
        $data   = [
            "title"         => "Dashboard",
            "class"         => "Dashboard",
            "sub_class"     => "Index",
            "content"       => "layout.customer",
            "users"         => $users,
            "codes"         => $codes,
            "petugas"       => $petugas,
            "observations"  => $observation,
            "vital_sign"    => $vital_sign,
            "laboratory"    => $laboratory,
            "customer"      => $customer
        ];
        return view('customer.dashboard.index', $data);
    }
}
