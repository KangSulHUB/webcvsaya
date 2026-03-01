<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cv', function () {
    return view('cv');
})->name('cv');

Route::get('/project', [ProjectController::class, 'index'])->name('project');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin.session')->prefix('admin')->group(function () {
    Route::get('/projects', [ProjectController::class, 'adminIndex'])->name('admin.projects');
    Route::post('/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
