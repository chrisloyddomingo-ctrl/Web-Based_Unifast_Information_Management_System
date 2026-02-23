<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApplicationViewController;
use App\Http\Controllers\GranteeListController;
use App\Http\Controllers\MenuController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ PUBLIC APPLY ROUTES (NO LOGIN REQUIRED)
Route::get('/apply', [ApplicationController::class, 'create'])->name('apply.create');
Route::post('/apply', [ApplicationController::class, 'store'])->name('apply.store');
Route::get('/apply/submitted', [ApplicationController::class, 'submitted'])->name('apply.submitted');

Auth::routes();

// ✅ AUTH ONLY ROUTES
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Menu Management (Unifast)
    Route::get('/menu_pagination', [MenuController::class, 'index'])->name('menu_pagination');

    // Post Management
    Route::get('/post_management_pagination', [HomeController::class, 'post_management_pagination'])->name('post_management_pagination');

    // Application Management (ADMIN SIDE)
    Route::get('/applications', [ApplicationViewController::class, 'index'])->name('applications.index');
    Route::post('/applications/store', [ApplicationViewController::class, 'store'])->name('applications.store');
    Route::get('/applications/{id}/edit', [ApplicationViewController::class, 'edit'])->name('applications.edit');
    Route::get('/applications/{id}/show', [ApplicationViewController::class, 'show'])->name('applications.show');
    Route::post('/applications/update', [ApplicationViewController::class, 'update'])->name('applications.update');
    Route::post('/applications/destroy', [ApplicationViewController::class, 'destroy'])->name('applications.destroy');
    // approve / reject actions
    Route::post('/applications/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/reject', [ApplicationController::class, 'reject'])->name('applications.reject');

    Route::get('/registration_pagination', [HomeController::class, 'registration_pagination'])->name('registration_pagination');
    Route::get('/fileupload_pagination', [HomeController::class, 'fileupload_pagination'])->name('fileupload_pagination');
    Route::post('/users/store', [HomeController::class, 'store'])->name('users.store');

    // Grantees List
    Route::get('/grantees', [GranteeListController::class, 'index'])->name('grantees.index');
});