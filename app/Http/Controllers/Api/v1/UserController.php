<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_depan'    => 'required',
            'nama_belakang' => 'required',
            'email'         => 'required|email|unique:users,kontak.email',
            'password'      => 'required',
            'c_password'    => 'required|same:password',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        if($validator->fails()){
            return $this->validationError('Validation Error.', $validator->errors());
        }
        $user = $this->userService->register($request);
        return $this->sendResponse($user, 'User register successfully.');
    }
    public function findByEmail(Request $request){
        $email  = $request->email;
        $result = $this->userService->findByEmail($email);
        return $this->sendResponse($result, 'success');
    }
    public function findByNIK(Request $request){
        $nik    = $request->nik;
        $result = $this->userService->findByNIK($nik);
        return $this->sendResponse($result, 'success');
    }
    public function profile(){
        $user_id = Auth::id();
        $user = $this->userService->profile($user_id);
        return $this->sendResponse($user, 'success');
    }

}
