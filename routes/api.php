<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;


Route::post('login', [AuthController::class, 'login']); 

# Categories  
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');

# Posts  
Route::get('/post', [PostController::class, 'index'])->name('post.index');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::middleware(['role:moderator|super-admin'])->group(function () {
        # Categories
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
       
        # Posts 
        Route::post('/post', [PostController::class, 'store'])->name('post.store');
        Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    }); 

    Route::middleware(['role:super-admin'])->group(function () {
        # Categories
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        
        # Posts 
        Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    });
});
