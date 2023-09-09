<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Kit;
use App\Models\Postal;
use App\Models\User;
use App\Models\Wilayah;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::all();
        $data = [
            "title"         => "List Customers",
            "class"         => "customer",
            "sub_class"     => "list",
            "content"       => "layout.admin",
            "customers"     => $customers
        ];
        return view('user.customer.index', $data);
    }
    public function create()
    {
        $customer  = new Customer();
        $data = [
            "title"         => "List Customers",
            "class"         => "customer",
            "sub_class"     => "list",
            "content"       => "layout.admin",
            "customer"      => $customer,

        ];
        return view('user.customer.create', $data);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code'      => 'required',
            'name'      => 'required',
            'nik_pic'   => 'required',
            'hp'        => 'required',
            'email'     => 'required',
            'alamat'    => 'required',
            'postal'    => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $user = User::where('nik', (int) $request->nik_pic)->first();
            if($user == null){
                session()->flash('danger', 'NIK '.$request->nik_pic.' tidak terdaftar');
                return redirect()->back()->withInput();
            }

            $data_input = [
                'customer_code' => $request->code,
                'customer_name' => $request->name,
                'email'         => $request->email,
                'hp'            => $request->hp,
                'customer_pic'  => $user->nama['nama_depan'],
                'alamat'        => $request->alamat
            ];
            $api_ext    = env('APP_API_EXTERNAL');
            $url        = $api_ext."/v1/customers";
            $session_token  = decrypt(session('web_token'));
            $header = [
                'Authorization' => "Bearer $session_token",
            ];
            $client     = new Client();
            try {
                $response   = $client->post($url, [
                    'headers'       => $header,
                    'form_params'   => $data_input
                ]);

                // Periksa status kode respons
                if ($response->getStatusCode() === 201) {
                    $data = json_decode($response->getBody(), true);
                    session()->flash('success', $data['message']);
                    return redirect()->back();
                } elseif ($response->getStatusCode() === 404) {
                    echo "Not Found";
                    // Respons dengan status 404 (Not Found)
                    // Handle kesalahan 404 di sini, misalnya, kembalikan pesan kesalahan atau lakukan tindakan lain yang sesuai
                } else {
                    // Respons dengan status kode lain
                    // Handle kesalahan lainnya di sini
                }
            } catch (RequestException $e) {
                // Tangani kesalahan permintaan seperti koneksi bermasalah atau API tidak tersedia
                if ($e->hasResponse()) {
                    // Ada respons dari API
                    $response = $e->getResponse();
                    if ($response->getStatusCode() === 422) {
                        $data = json_decode($response->getBody(), true);
                        session()->flash('danger', $data['message']);
                        return redirect()->back()->withInput();
                    } else {
                        $data = json_decode($response->getBody(), true);
                        session()->flash('danger', "tidak bisa diproses");
                        return redirect()->back()->withInput();
                    }
                } else {
                    echo "apa ini itu";
                    // Tangani kesalahan ketika tidak ada respons dari API
                }
            }
        }
    }
    public function show($id)
    {
        $customer   = Customer::where('_id', $id)->first();
        $kits       = Kit::where('owner.code', $customer->code)->get();
        $data = [
            "title"         => "List Customers",
            "class"         => "customer",
            "sub_class"     => "list",
            "content"       => "layout.admin",
            "customer"      => $customer,
            "kits"          => $kits
        ];

        return view('user.customer.show', $data);
    }
}
