<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::group([
//    'as' => 'passport.',
//    'prefix' => config('passport.path', 'oauth'),
//    'namespace' => 'Laravel\Passport\Http\Controllers',
//], function () {
//    // Passport routes...
//});
Route::get('notAuthorised', function (){
    $data = [
        "success"   => false,
        "message"   => "Not Authorise",
        "data"      => []
    ];
    return response($data, 401);

    ; })->name('notAuthorised');
