<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kit\StoreKitRequest;
use App\Models\Customer;
use App\Models\Kit;
use App\Models\Religion;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KitController extends Controller
{
    public function index(){
        $kit = Kit::all();
        $data = [
            "title"     => "Kits List",
            "class"     => "Kit",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "kits"      => $kit
        ];
        return view('user.kits.index', $data);
    }
    public function create(){
        $customer       = Customer::where('is_distributor', '!=', true)->get();
        $distributor    = Customer::where('is_distributor', true)->get();
        $kits           = new Kit();
        $data = [
            "title"     => "Kits List",
            "class"     => "Kit",
            "sub_class" => "Get All",
            "content"   => "layout.admin",
            "customer"  => $customer,
            "distributor"   => $distributor,
            "kits"          => $kits
        ];
        return view('user.kits.create', $data);
    }
    public function store(StoreKitRequest $request){
        $session_token  = decrypt(session('web_token'));
        $url            = env('APP_API_EXTERNAL'). "/v1/kits";
        $header = [
            'Authorization' => "Bearer $session_token",
        ];
        $post = [
            'kit_code'          => $request->code,
            'kit_name'          => $request->name,
            'owner_code'        => $request->owner,
            'distributor_code'  => $request->distributor
        ];
        $client     = new Client();
        try {
            $response   = $client->post($url, [
                'headers'       => $header,
                'form_params'   => $post
            ]);

            // Periksa status kode respons
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                session()->flash('success', $data['message']);
                return back();
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
                if ($response->getStatusCode() === 404) {
                    $data = json_decode($response->getBody(), true);
                    session()->flash('danger', $data['message']);
                    return redirect()->back()->withInput();
                } else {
                    // Handle kesalahan lainnya di sini
                }
            } else {
                // Tangani kesalahan ketika tidak ada respons dari API
                echo "Tidak ada respons";
            }
        }

    }

}
