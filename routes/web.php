<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\GuestPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestPageController::class, 'home'])->name('home');
Route::get('/about', [GuestPageController::class, 'about'])->name('about');
Route::get('/contact', [GuestPageController::class, 'contact'])->name('contact');
Route::get('/programs', [GuestPageController::class, 'programs'])->name('programs');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/login', [GuestPageController::class, 'login'])->name('login');

Route::get('/coach', [CoachController::class, 'index'])->name('coach.index');
Route::get('/coach/blog/create', [CoachController::class, 'createBlog'])->name('coach.blog.create');
Route::post('/coach/blog', [BlogController::class, 'store'])->name('coach.blog.store');
Route::get('/coach/clients', [CoachController::class, 'clients'])->name('coach.clients');
