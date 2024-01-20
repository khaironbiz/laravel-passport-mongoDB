<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    /**
     * Halaman yang memberikan informasi gagal authorisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function notAuthorised(){
        $status_code = 499;
        $data = [
            'status_code'   => $status_code,
            'message'       => 'Token Invalid ',
        ];
        return response()->json($data,$status_code);

    }


    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Username and password not match']);
        }
    }
    public function revoke(Request $request){
        $tokenId = $request->token_id;
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        // Revoke an access token...
        $revoke = $tokenRepository->revokeAccessToken($tokenId);
        // Revoke all of the token's refresh tokens...
//        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
        if($revoke){
            return $this->sendResponse('success','deleted');
        }
        return $this->sendError('failed','failed');

    }




}
