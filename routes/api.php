<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DelegationController;


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


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//users
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'delete']);
//delegations
Route::get('delegations', [DelegationController::class, 'index']);
Route::get('delegations/{id}', [DelegationController::class, 'show']);
Route::post('delegations', [DelegationController::class, 'store']);
Route::put('delegations/{id}', [DelegationController::class, 'update']);
Route::delete('delegations/{id}', [DelegationController::class, 'delete']);
//countries
Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/{id}', [CountryController::class, 'show']);
Route::post('countries', [CountryController::class, 'store']);
Route::put('countries/{id}', [CountryController::class, 'update']);
Route::delete('countries/{id}', [CountryController::class, 'delete']);