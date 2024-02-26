<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [\App\Http\Controllers\Api\v1\UserController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('login', [AuthController::class, 'notAuthorised'])->name('login');
Route::post('create', [\App\Http\Controllers\Api\v1\ClientController::class, 'store']);

Route::middleware('auth:api')->group( function () {
    Route::resource('products', ProductController::class);
    Route::get('client', [\App\Http\Controllers\Api\v1\ClientController::class, 'index']);

    //users
    Route::post('users', [\App\Http\Controllers\Api\v1\UserController::class, 'register']);
    Route::get('user/profile', [\App\Http\Controllers\Api\v1\UserController::class, 'profile']);
    Route::post('user/find/email', [\App\Http\Controllers\Api\v1\UserController::class, 'findByEmail']);
    Route::post('user/find/nik', [\App\Http\Controllers\Api\v1\UserController::class, 'findByNIK']);

    //client
    Route::get('client/mine', [\App\Http\Controllers\Api\v1\ClientController::class, 'mine']);
    Route::get('client', [\App\Http\Controllers\Api\v1\ClientController::class, 'index']);

    //token
    Route::post('token/revoke', [AuthController::class,'revoke']);

    //observation
    Route::get('observations', [\App\Http\Controllers\Api\v1\ObservationController::class, 'index']);
    Route::get('observation', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'show']);
    Route::get('observation', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'show']);
    Route::get('observation', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'show']);

    //diastole
    Route::get('diastole/patient', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'get_systole']);
    Route::get('diastole/show', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'show']);
    Route::post('diastole', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'store']);
});
