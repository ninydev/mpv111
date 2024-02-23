<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('auth/register', RegisterController::class)
    ->name('api.auth.register');
Route::post('auth/login', LoginController::class)
    ->name('api.auth.login');



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
