<?php

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
