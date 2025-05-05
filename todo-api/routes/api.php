<?php

use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('registration', [\App\Http\Controllers\Api\AuthController::class, 'signup']);
Route::post('login', [\App\Http\Controllers\Api\AuthController::class,'login']);

Route::middleware( Admin::class)->group(function () {

    Route::get('/info',[\App\Http\Controllers\Api\User\UserController::class,'info']);
    Route::group(['prefix'=>'todo'], function(){
        Route::get('/get/list', [App\Http\Controllers\Api\TodoController::class,'index']);
        Route::post('/insert/update', [App\Http\Controllers\Api\TodoController::class, 'dataInfoAddOrUpdate']);
        Route::post('/delete', [App\Http\Controllers\Api\TodoController::class, 'dataInfoDelete']);
        Route::post('/toggle-complete', [App\Http\Controllers\Api\TodoController::class, 'toggleComplete']);

        
    });

});