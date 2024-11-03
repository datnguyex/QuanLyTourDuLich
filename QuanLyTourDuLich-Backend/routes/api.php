<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\PaymentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Api router tour
Route::prefix('tours')->controller(TourController::class)->group(function () {
    Route::get('/list', 'index');
    Route::get('{id}', 'show');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'destroy');
    Route::patch('deleteAll', 'destroyTours');
    Route::post('/', 'store');
    Route::get('/search/{key}', 'findByLocation');
    Route::get('/category/{key}', 'findByCategory');
    Route::get('total/count', 'countTours');
    Route::put('/{id}/status', 'updateStatus');
    Route::get('/sort={key}', 'sortTours');
});
/**Group api payment */
Route::prefix('payments')->controller(PaymentController::class)->group(function () {
    Route::get('/list', 'index');
    Route::get('{id}', 'show');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'destroy');
    Route::patch('deleteAll', 'destroyPayment');
    Route::post('/', 'store');
    Route::get('/search/{key}', 'findByLocation');
    Route::get('/category/{key}', 'findByCategory');
    Route::get('total/count', 'countPayment');
    Route::put('/{id}/status', 'updateStatus');
    Route::get('/sort={key}', 'sortPayment');
    Route::post('/momo_payment', 'momo_payment');
    Route::post('/momo/ipn', 'momoIPN');
});