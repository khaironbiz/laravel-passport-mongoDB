<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class ClientController extends Controller
{
    public function index(){
        $client = Client::all();
        return $this->sendResponse(ClientResource::collection($client), 'Products retrieved successfully.');
    }
    public function createToken(Request $request){
        $post = $request->all();
        $client = \Laravel\Passport\Client::find($request->client_id);
        if(empty($client)){
            return $this->sendError('Invalid Client ID', 'Client Not Found');
        }elseif($client->secret != $request->client_secret){
            return $this->sendError('Invalid Secret Key', 'Invalid Secret Key');
        }else{
            $user               = User::find($client->user_id);
            if(empty($user)){
                $token['token'] = null;
                $message = "Anda tidak memiliki klien";
            }else{
                $token['token'] = $user->createToken('MyApp')-> accessToken;
                $message = "User login successfully";
            }
            return $this->sendResponse($token, $message);
        }

    }
}
