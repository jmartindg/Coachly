<?php

use App\Http\Controllers\GuestPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestPageController::class, 'home']);
Route::get('/about', [GuestPageController::class, 'about']);
Route::get('/contact', [GuestPageController::class, 'contact']);
Route::get('/programs', [GuestPageController::class, 'programs']);
Route::get('/blog', [GuestPageController::class, 'blog']);
Route::get('/login', [GuestPageController::class, 'login']);
