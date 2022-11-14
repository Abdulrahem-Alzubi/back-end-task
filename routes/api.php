<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ChangePasswordController;

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

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('chang-password', [ChangePasswordController::class, 'changPassword'])
        ->middleware('auth:sanctum');
});

Route::prefix('user')->group(function () {
    Route::middleware('check_admin')->group(function () {
        Route::post('add', [UserController::class, 'store']);
        Route::put('update/{user}', [UserController::class, 'update']);
        Route::delete('delete/{user}', [UserController::class, 'delete']);
    });
   Route::get('profile', [UserController::class, 'profile']);
   Route::get('show-my-product', [UserController::class, 'showHisProduct']);
});


Route::prefix('product')->group(function () {
    Route::middleware('check_admin')->group(function () {
        Route::get('all', [ProductController::class, 'index']);
        Route::post('add', [ProductController::class, 'store']);
        Route::put('update/{product}', [ProductController::class, 'update']);
        Route::delete('delete/{product}', [ProductController::class, 'delete']);
        Route::post('assign-products-to-user/{user}', [ProductController::class, 'assignProductToUser']);
        Route::get('view-user-products/{user}', [ProductController::class, 'viewUserProducts']);
    });
});
