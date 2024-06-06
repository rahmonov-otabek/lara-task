<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;


Route::post('login', [AuthController::class, 'login']); 

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::middleware(['role:moderator|super-admin'])->group(function () {
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
    }); 

    Route::middleware(['role:super-admin'])->group(function () {
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });
});
