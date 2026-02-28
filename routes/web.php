<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cv', function () {
    return view('cv');
})->name('cv');

Route::get('/project', [ProjectController::class, 'index'])->name('project');
Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');
Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
