<?php

use App\Http\Controllers\Courses;
use App\Http\Controllers\Lessons;
use App\Http\Controllers\Levels;
use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\ResetAuthentication;
use App\Http\Controllers\Sections;
use App\Http\Controllers\User;
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

Route::post('/login', Login::class);

Route::post('/{action}/{type}', ResetAuthentication::class)
    ->where("type", "email|password")
    ->where("action", "send_token|verify_token|reset")
    ->name('reset-auth');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('is_admin')->prefix('admin')->group(function () {

        Route::get("/user/{action?}", User::class)
            ->where("action", "show")
            ->name("user");

        Route::post("/user/{action}", User::class)
            ->where("action", "update|store")
            ->name("user");

        // Courses
        Route::get("/course/{action?}", Courses::class)
            ->where("action", "show|levels")
            ->name("user");

        Route::post("/course/{action}", Courses::class)
            ->where("action", "update|store")
            ->name("user");

        // Sections
        Route::get("/sections/{action?}", Sections::class)
            ->where("action", "show")
            ->name("user");

        Route::post("/sections/{action}", Sections::class)
            ->where("action", "update|store|bulk_update")
            ->name("user");

        // Lessons
        Route::get("/lessons/{action?}", Lessons::class)
            ->where("action", "show")
            ->name("user");

        Route::post("/lessons/{action}", Lessons::class)
            ->where("action", "update|store")
            ->name("user");

        // Levels
        Route::get("/levels/{action?}", Levels::class)
            ->where("action", "show")
            ->name("user");

        Route::post("/levels/{action}", Levels::class)
            ->where("action", "update|store|delete")
            ->name("user");

    });

    Route::post('/logout', Logout::class);
});
