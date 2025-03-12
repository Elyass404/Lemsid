<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\V1\CourseController;
use App\Http\Controllers\api\V1\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::group(["prefix"=>"V1"],function (){

    Route::apiResource('Course',CourseController::class);

    Route::apiResource('Categories',CategoryController::class);
    
    // Route::apiResource('Tags',TagController::class);
});
