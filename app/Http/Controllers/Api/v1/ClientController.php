<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;

class ClientController extends Controller
{
    public function index(){
        $client = Client::all();
        return $this->sendResponse(ClientResource::collection($client), 'Products retrieved successfully.');
    }
    public function store(Request $request){
        $client = new Client();
        $client_secret = md5(uniqid());
        $user = User::find($request->user_id);
        if(empty($user)){
            return $this->sendError('Invalid User ID', 'User ID Not Found');
        }
        $data_client = [
            "user_id"       => $request->user_id,
            "name"          => $request->client_name,
            "secret"        => $client_secret,
            "provider"                  => "users",
            "redirect"                  => $request->redirect,
            "personal_access_client"    => false,
            "password_client"           => true,
            "revoked"                   => false
        ];
        $create_client = $client->create($data_client);
        if(empty($create_client)){
            return $this->sendError('Invalid Client ID', 'Client Not Found');
        }else{
            $message  = "Client created";
            return $this->sendResponse($create_client, $message);
        }

    }
    public function mine(){
        $user_id = Auth::id();
        $client = Client::where('user_id', $user_id)->get();
        return $this->sendResponse(ClientResource::collection($client), "success");
    }
}
