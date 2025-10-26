<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Middleware untuk user yang belum login
Route::middleware('guest')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
   
});


// Middleware untuk user yang sudah login
Route::middleware('auth:sanctum')->group(function (){
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::resource('contact', ContactsController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('contacts', ContactsController::class);