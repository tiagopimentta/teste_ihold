<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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

//Route::middleware('api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/', function(){
    return view('welcome');
});

Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::group(['middleware' => ['apiJwt']], function() {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    /**
     * Orders
     */
    Route::resource('/orders', OrderController::class);

    /**
     * Order Items
     */
    Route::group(['prefix' => '/orders/{orderId}/'], function() {
        Route::resource('items', OrderItemController::class)
            ->only('index', 'store', 'destroy');
    });
});
