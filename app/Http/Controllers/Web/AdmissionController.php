<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Customer;
use App\Models\Question;
use App\Models\Service;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmissionController extends Controller
{
    public function index($id)
    {
        $admissions = Admission::where('faskes.id', $id)->get();
        $data = [
            "title"         => "Admission List",
            "class"         => "Admission",
            "sub_class"     => "list",
            "content"       => "layout.admin",
            "admissions"    => $admissions,
        ];

        return view('user.admission.index', $data);
    }
    public function kunjungan($id_user, $id_customer)
    {
        $user = User::find($id_user);
        $customer = Customer::find($id_customer);
        $data = [
            "title"     => "Admission List",
            "class"     => "Admission",
            "sub_class" => "list",
            "content"   => "layout.admin",
            "user"      => $user,
            "customer"  => $customer
        ];
        return view('user.admission.create', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_faskes' => 'required',
            'id_pasien' => 'required',
            'date'      => 'date'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $data_post = [
                'id_faskes' => $request->id_faskes,
                'id_pasien' => $request->id_pasien,
                'date'      => $request->date,
            ];
            $api_ext    = env('APP_API_EXTERNAL');
            $url        = $api_ext."/v1/auth/forgotpassword";
            $client     = new Client();
            $response   = $client->post($url, [
                'form_params' => $data_post
            ]);
            $statusCode = $response->getStatusCode();
            if($statusCode == 200){
                session()->flash('success', 'Admission Created');
                return back();
            }
        }
    }
}
