<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\MenuBrowser;
use App\Livewire\Checkout;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/menu');
});

// Public menu routes
Route::get('/menu', function () {
    return view('menu.index');
})->name('menu');

Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
