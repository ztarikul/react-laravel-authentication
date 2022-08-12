<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/forgetpassword', [ForgetController::class, 'forgetpassword']);
Route::post('/resetpassword', [ResetController::class, 'resetpassword']);
Route::get('/user', [UserController::class, 'user'])->middleware('auth:api');
