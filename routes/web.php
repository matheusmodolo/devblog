<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DesenvolvedorController;
use App\Http\Controllers\IndexController;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/admin')->middleware(App\Http\Middleware\AdminMiddleware::class)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::resource('developers', DesenvolvedorController::class);
});


Route::get('/teste', function () {
   dd(Auth::user(), Auth::user()->is_admin);
});

require __DIR__.'/auth.php';
