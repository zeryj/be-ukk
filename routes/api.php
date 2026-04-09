<?php

use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/index',[AspirasiController::class, 'index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// aspirasi
Route::prefix('aspirasi')->middleware([ 'role:student','auth:sanctum'])->group(function(){
    Route::post('/store', [AspirasiController::class, 'create'])->middleware('auth:sanctum');
    Route::post('/update/{id}', [AspirasiController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/delete/{id}', [AspirasiController::class, 'delete'])->middleware('auth:sanctum');
    Route::post('/destroy/{id}', [AspirasiController::class, 'forcedelete'])->middleware('auth:sanctum');
    Route::post('/force/{id}', [AspirasiController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::get('/category', [CategoryController::class, 'index']);
Route::prefix('category')->middleware('role:admin','auth:sanctum')->group(function(){
    Route::post('/store', [CategoryController::class, 'store']);
    Route::post('/update', [CategoryController::class, 'update']);
    Route::post('/store', [CategoryController::class, 'store']);
});
//auth
Route::prefix('auth')->group(function(){
     Route::post('/Login', [AuthController::class, 'login']);
     Route::get('/users', [AuthController::class, 'index']);
     Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
