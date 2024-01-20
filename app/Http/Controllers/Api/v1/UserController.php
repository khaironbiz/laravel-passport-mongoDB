<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Service\Consultant\ConsultantService;
use App\Service\HealthOverview\HealthOverviewService;
use App\Service\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class UserController extends Controller
{


    private UserService $userService;
    public function __construct() {
        $this->userService = new UserService();
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
        $email = $request->email;
        $user = $this->userService->findByEmail($email);
        return response()->json($user);
    }
    public function profile(){
        $user = Auth::user();
        return response()->json($user);
    }

}
