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

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/menu');
})->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
});
