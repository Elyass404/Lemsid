<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\V1\TagController;
use App\Http\Controllers\api\V2\AuthController;
use App\Http\Controllers\api\V1\CourseController;
use App\Http\Controllers\api\V1\CategoryController;
use App\Http\Controllers\api\V2\EnrollmentController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::group(["prefix"=>"V1"],function (){

    Route::apiResource('Course',CourseController::class);

    Route::apiResource('Categories',CategoryController::class);
    
    Route::apiResource('Tags',TagController::class);
});

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/auth/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    // Route::get('/auth/login', [AuthController::class, 'index'])->name("login");

Route::group(["prefix"=>"V2",'middleware' => ['auth:sanctum']],function (){
    
    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('Categories', CategoryController::class);
        Route::apiResource('Tags', TagController::class);
    });
    // Admin and mentor routes
    Route::middleware('role:admin, mentor')->group(function () {
        Route::apiResource('Course', CourseController::class);
    });

    // student only routes
    Route::middleware('role:student')->group(function () {
        Route::get('Course', [CourseController::class, 'index']);
        Route::post('Enroll', [EnrollmentController::class, 'store']);
        
    
    });

    Route::post('auth/refresh',[AuthController::class, "refreshToken"]);
    
});