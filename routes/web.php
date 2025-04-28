<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesenvolvedorController;
use App\Http\Controllers\ArtigoController;

Route::redirect('/dashboard', '/artigos')->name('dashboard');
Route::redirect('/', '/artigos');

Route::resource('artigos', ArtigoController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/admin')->middleware(App\Http\Middleware\AdminMiddleware::class)->group(function () {

    Route::resource('desenvolvedores', DesenvolvedorController::class)
        ->parameters(['desenvolvedores' => 'desenvolvedor']);
});

require __DIR__ . '/auth.php';
