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
Route::post('login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login']);
Route::get('login', [\App\Http\Controllers\Api\v1\AuthController::class, 'notAuthorised'])->name('auth.login');
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
    Route::get('observation/show', [\App\Http\Controllers\Api\v1\ObservationController::class, 'show']);
    Route::get('observation/patient', [\App\Http\Controllers\Api\v1\ObservationController::class, 'getByIdPasien']);


    //systole
    Route::get('systole/patient/nik', [\App\Http\Controllers\Api\v1\SystoleController::class, 'getBynik']);
    Route::get('systole/patient', [\App\Http\Controllers\Api\v1\SystoleController::class, 'getByIdPasien']);
    Route::get('systole/show', [\App\Http\Controllers\Api\v1\SystoleController::class, 'show']);
    Route::post('systole', [\App\Http\Controllers\Api\v1\SystoleController::class, 'store']);

    //diastole
    Route::get('diastole/patient/nik', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'getBynik']);
    Route::get('diastole/patient', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'getByIdPasien']);
    Route::get('diastole/show', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'show']);
    Route::post('diastole', [\App\Http\Controllers\Api\v1\DiastoleController::class, 'store']);

    //Heart Rate
    Route::get('heartRate/patient/nik', [\App\Http\Controllers\Api\v1\HeartRateController::class, 'getBynik']);
    Route::get('heartRate/patient', [\App\Http\Controllers\Api\v1\HeartRateController::class, 'getByIdPasien']);
    Route::get('heartRate/show', [\App\Http\Controllers\Api\v1\HeartRateController::class, 'show']);
    Route::post('heartRate', [\App\Http\Controllers\Api\v1\HeartRateController::class, 'store']);
    Route::get('nullPasien', [\App\Http\Controllers\Api\v1\HeartRateController::class, 'null_pasien']);

    //Body Temperature
    Route::get('bodyTemperature/patient/nik', [\App\Http\Controllers\Api\v1\BodyTemperature::class, 'getBynik']);
    Route::get('bodyTemperature/patient', [\App\Http\Controllers\Api\v1\BodyTemperature::class, 'getByIdPasien']);
    Route::get('bodyTemperature/show', [\App\Http\Controllers\Api\v1\BodyTemperature::class, 'show']);
    Route::post('bodyTemperature', [\App\Http\Controllers\Api\v1\BodyTemperature::class, 'store']);

    //Body Weight
    Route::get('weight/patient/nik', [\App\Http\Controllers\Api\v1\WeightController::class, 'getBynik']);
    Route::get('weight/patient', [\App\Http\Controllers\Api\v1\WeightController::class, 'getByIdPasien']);
    Route::get('weight/show', [\App\Http\Controllers\Api\v1\WeightController::class, 'show']);
    Route::post('weight', [\App\Http\Controllers\Api\v1\WeightController::class, 'store']);

});
