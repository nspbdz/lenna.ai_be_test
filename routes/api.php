<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ChatController;


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
  //API route for login user
  Route::post('/login', [AuthController::class, 'login']);
  Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Version 1
Route::prefix('v1')->group(function () {
    //API route for register new user
    Route::post('/register', [AuthController::class, 'register']);



Route::prefix('otp')->group(function () {
        Route::post('/send', [AuthController::class, 'sendOtp']);
        Route::post('/verify', [AuthController::class, 'verifyOtp']);
    });

    Route::prefix('forgot-password')->group(function () {
        Route::post('/', [AuthController::class, 'forgotPassword']);
        Route::post('/verify', [AuthController::class, 'verifyForgotPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });

    //Protecting Routes
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::prefix('profile')->group(function () {
            Route::get('/', [AuthController::class, 'profile']);
            Route::post('/change-password', [AuthController::class, 'changePassword']);
        });

        Route::get('/user/{id}', [UserController::class, 'findUserId']);
        Route::get('/users', [UserController::class, 'index']);

        // API route for logout user
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::post('/chat', [ChatController::class, 'chat']);
        Route::get('/chat', [ChatController::class, 'index']);
        Route::get('/chat/{id}', [ChatController::class, 'byId']);
        // Route::get('/chat/{id}', [ChatController::class, 'chat']);

    });
});

// Using api to clear cache, cookies, and sessions
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return Artisan::output();
});
