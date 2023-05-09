<?php

use App\Http\Controllers\UserApiController;
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

//Get api for fetch user
Route::get('index/{id?}', [UserApiController::class, 'index']);
Route::post('create', [UserApiController::class, 'create']);
Route::post('createMultiple', [UserApiController::class, 'createMultiple']);
Route::put('edit/{id}', [UserApiController::class, 'edit']);
Route::patch('update/{id}', [UserApiController::class, 'update']);
Route::delete('destroy/{id}', [UserApiController::class, 'destroy']);
Route::delete('destroyWithJson', [UserApiController::class, 'destroyWithJson']);
Route::delete('destroyMultiple/{ids}', [UserApiController::class, 'destroyMultiple']);
Route::delete('destryMultipleWithJson', [UserApiController::class, 'destryMultipleWithJson']);