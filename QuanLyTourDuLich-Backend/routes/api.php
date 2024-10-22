<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AuthController::class,'login']);
Route::post('RegistermoreInfomation', [AuthController::class,'RegistermoreInfomation']);
Route::post('sendCode', [AuthController::class,'sendCode']);
Route::post('registerMainInfo', [AuthController::class,'registerMainInfo']);
Route::post('mainInformation', [AuthController::class,'mainInformation']);
Route::get('user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});