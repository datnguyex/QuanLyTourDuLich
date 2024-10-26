<?php


use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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


Route::prefix('tours')->controller(TourController::class)->group(function () {
    Route::get('list', 'index');
    Route::get('{id}', 'show');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'destroy');
    Route::patch('deleteAll', 'destroyTours');
    Route::post('/', 'store');
});

Route::post('login', [AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function(){
    Route::get('inforCurrentUser', [AuthController::class,'inforCurrentUser']);
});

Route::post('RegistermoreInfomation', [AuthController::class,'RegistermoreInfomation']);
Route::post('sendCode', [AuthController::class,'sendCode']);
Route::post('registerMainInfo', [AuthController::class,'registerMainInfo']);
Route::post('mainInformation', [AuthController::class,'mainInformation']);
Route::get('user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('users', [UserController::class, 'index']);
Route::get('users/create', [UserController::class, 'create']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{user}/edit', [UserController::class, 'edit']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);


