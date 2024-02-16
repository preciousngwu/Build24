<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\ResetAuthentication;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', Login::class);

Route::post('/{action}/{type}', ResetAuthentication::class)
    ->where("type", "email|password")
    ->where("action", "send_token|verify_token|reset")
    ->name('reset-auth');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/', fn() => "D");

    Route::post('/logout', Logout::class);
});
