<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\GuestPageController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::view('/', [GuestPageController::class, 'home'])->name('home');
    Route::view('/about', [GuestPageController::class, 'about'])->name('about');
    Route::view('/contact', [GuestPageController::class, 'contact'])->name('contact');
    Route::view('/programs', [GuestPageController::class, 'programs'])->name('programs');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [GuestPageController::class, 'login'])->name('login');
    Route::post('/login', Login::class)->name('login');
    Route::get('/register', [GuestPageController::class, 'register'])->name('register');
    Route::post('/register', Register::class)->name('register');
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', Logout::class)->name('logout');
});

// Client routes (authenticated clients only)
Route::middleware(['auth', 'client', 'no-cache'])->group(function () {
    Route::get('/client', ClientController::class)->name('client.index');
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::put('/client/profile', [ClientController::class, 'updateProfile'])->name('client.profile.update');
});

// Coach routes (authenticated coaches only)
Route::middleware(['auth', 'coach', 'no-cache'])->group(function () {
    Route::get('/coach', [CoachController::class, 'index'])->name('coach.index');
    Route::get('/coach/blog/create', [CoachController::class, 'createBlog'])->name('coach.blog.create');
    Route::get('/coach/blog/{blog}/edit', [CoachController::class, 'editBlog'])->name('coach.blog.edit');
    Route::put('/coach/blog/{blog}', [BlogController::class, 'update'])->name('coach.blog.update');
    Route::delete('/coach/blog/{blog}', [BlogController::class, 'destroy'])->name('coach.blog.destroy');
    Route::post('/coach/blog', [BlogController::class, 'store'])->name('coach.blog.store');
    Route::get('/coach/clients', [CoachController::class, 'clients'])->name('coach.clients');
});
