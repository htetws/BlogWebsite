<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\User\PostViewController;
use Illuminate\Support\Facades\Route;

// Authentication

Route::middleware('authMiddleware')->group(function () {
    Route::get('login-page', [AuthController::class, 'login'])->name('login#page');
    Route::get('register-page', [AuthController::class, 'register'])->name('register#page');
});

//Post
Route::get('/', [PostViewController::class, 'post'])->name('post#home');
Route::get('category/{slug}', [PostViewController::class, 'categoryFilter'])->name('category#search');
Route::get('tag/{slug}', [PostViewController::class, 'tagFilter'])->name('tag#search');

Route::middleware('auth')->group(function () {

    //admin routes
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('admin#dashboard');
        //category routes
        Route::prefix('category')->group(function () {
            Route::get('list', [CategoryController::class, 'categoryList'])->name('admin#category');
            Route::post('create', [CategoryController::class, 'categoryCreate'])->name('admin#category#create');
            Route::delete('delete', [CategoryController::class, 'categoryDelete'])->name('admin#category#delete');
            Route::post('edit', [CategoryController::class, 'categoryEdit'])->name('admin#category#edit');
        });
        //tag routes
        Route::prefix('tag')->group(function () {
            Route::get('list', [TagController::class, 'tagList'])->name('admin#tag');
            Route::post('create', [TagController::class, 'tagCreate'])->name('admin#tag#create');
            Route::delete('delete', [TagController::class, 'tagDelete'])->name('admin#tag#delete');
            Route::post('edit', [TagController::class, 'tagEdit'])->name('admin#tag#edit');
        });
        //post routes
        Route::prefix('post')->group(function () {
            Route::get('list', [PostController::class, 'postList'])->name('admin#post#list');
            Route::get('create', [PostController::class, 'postCreatePage'])->name('admin#post#create#page');
            Route::post('create', [PostController::class, 'postCreate'])->name('admin#post#create');
            Route::get('view/{id}', [PostController::class, 'postView'])->name('admin#post#view');
            Route::get('edit/{id}', [PostController::class, 'postEditPage'])->name('admin#post#edit#page');
            Route::post('edit', [PostController::class, 'postEdit'])->name('admin#post#update');
        });
    });
});
