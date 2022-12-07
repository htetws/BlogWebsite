<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\User\PostViewController;
use Illuminate\Support\Facades\Route;

// Authentication

//socialite
Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login#google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('login/github', [AuthController::class, 'redirectToGithub'])->name('login#github');
Route::get('/auth/github/callback', [AuthController::class, 'handleGithubCallback']);

//custom auth
Route::middleware('authMiddleware')->group(function () {
    Route::get('login-page', [AuthController::class, 'login'])->name('login#page');
    Route::get('register-page', [AuthController::class, 'register'])->name('register#page');
});

//Post
Route::get('/', [PostViewController::class, 'post'])->name('post#home');

//Blog All Post
Route::get('blog', [PostViewController::class, 'blog'])->name('blog#all');

//filter Routes
Route::get('category/{slug}', [PostViewController::class, 'categoryFilter'])->name('category#search');
Route::get('tag/{slug}', [PostViewController::class, 'tagFilter'])->name('tag#search');
Route::get('user/{name}', [PostViewController::class, 'userFilter'])->name('user#search');

//ajax search and sorting
Route::get('ajax/search', [PostViewController::class, 'searchKeyon'])->name('search#ajax');
Route::get('ajax/sorting', [PostViewController::class, 'sortMulti'])->name('sort#ajax');

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

    //user detail route with auth
    Route::get('p/{slug}', [PostViewController::class, 'detail'])->name('post#detail');

    //bookmark pages
    Route::get('bookmark', [PostViewController::class, 'bookmarkPage'])->name('bookmark#page');

    //ajax methods
    Route::post('ajax/count', [PostViewController::class, 'ViewCount'])->name('view#count');

    //Bookmark Ajax
    Route::post('ajax/bookmark', [PostViewController::class, 'Bookmark'])->name('view#bookmark');
    Route::get('ajax/search/bookmark', [PostViewController::class, 'BookmarkSearch'])->name('ajax#search#bookmark');
    Route::get('ajax/sorting/bookmark', [PostViewController::class, 'BookmarkSorting'])->name('ajax#sorting#bookmark');
    Route::get('ajax/clear/bookmark', [PostViewController::class, 'clearBookmark'])->name('ajax#clear');
    Route::get('ajax/remove/bookmark', [PostViewController::class, 'removeBookmark'])->name('ajax#remove');

    //Save Ajax
    Route::post('ajax/love', [PostViewController::class, 'LovePost'])->name('ajax#love');
});
