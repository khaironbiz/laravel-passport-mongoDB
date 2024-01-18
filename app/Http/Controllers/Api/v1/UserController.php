<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\Consultant\ConsultantService;
use App\Service\HealthOverview\HealthOverviewService;
use App\Service\Users\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private UserService $userService;
    public function __construct() {
        $this->userService = new UserService();
    }
    public function findByEmail(Request $request){
        $email = $request->email;
        $user = $this->userService->findByEmail($email);
        return response()->json($user);
    }
}
