<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Coach\ExerciseController;
use App\Http\Controllers\Coach\ProgramController;
use App\Http\Controllers\Coach\WorkoutController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\GuestPageController;
use App\Http\Controllers\NotificationController;
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
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// Client routes (authenticated clients only)
Route::middleware(['auth', 'client', 'no-cache'])->group(function () {
    Route::get('/client', ClientController::class)->name('client.index');
    Route::get('/client/program', [ClientController::class, 'program'])->name('client.program');
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::put('/client/profile', [ClientController::class, 'updateProfile'])->name('client.profile.update');
    Route::get('/client/booked-slots', [ClientController::class, 'bookedSlots'])->name('client.booked-slots');
    Route::post('/client/apply', [ClientController::class, 'apply'])->name('client.apply');
});

// Coach routes (authenticated coaches only)
Route::middleware(['auth', 'coach', 'no-cache'])->group(function () {
    Route::get('/coach', [CoachController::class, 'index'])->name('coach.index');
    Route::get('/coach/profile', [CoachController::class, 'profile'])->name('coach.profile');
    Route::put('/coach/profile', [CoachController::class, 'updateProfile'])->name('coach.profile.update');
    Route::put('/coach/workout-styles', [CoachController::class, 'updateWorkoutStyles'])->name('coach.workout-styles.update');
    Route::get('/coach/blog/create', [CoachController::class, 'createBlog'])->name('coach.blog.create');
    Route::get('/coach/blog/{blog}/edit', [CoachController::class, 'editBlog'])->name('coach.blog.edit');
    Route::put('/coach/blog/{blog}', [BlogController::class, 'update'])->name('coach.blog.update');
    Route::delete('/coach/blog/{blog}', [BlogController::class, 'destroy'])->name('coach.blog.destroy');
    Route::post('/coach/blog', [BlogController::class, 'store'])->name('coach.blog.store');
    Route::get('/coach/clients', [CoachController::class, 'clients'])->name('coach.clients');
    Route::get('/coach/clients/{user}', [CoachController::class, 'showClient'])->name('coach.clients.show');
    Route::post('/coach/clients/{user}/assign-program', [CoachController::class, 'assignProgram'])->name('coach.clients.assign-program');
    Route::post('/coach/clients/{user}/promote', [CoachController::class, 'promoteClient'])->name('coach.clients.promote');
    Route::post('/coach/clients/{user}/finish', [CoachController::class, 'finishClient'])->name('coach.clients.finish');
    Route::post('/coach/clients/{user}/revert', [CoachController::class, 'revertToLead'])->name('coach.clients.revert');
    Route::get('/coach/programs', [ProgramController::class, 'index'])->name('coach.programs');
    Route::get('/coach/programs/create', [ProgramController::class, 'create'])->name('coach.programs.create');
    Route::post('/coach/programs', [ProgramController::class, 'store'])->name('coach.programs.store');
    Route::get('/coach/programs/{program}', [ProgramController::class, 'show'])->name('coach.programs.show');
    Route::get('/coach/programs/{program}/edit', [ProgramController::class, 'edit'])->name('coach.programs.edit');
    Route::put('/coach/programs/{program}', [ProgramController::class, 'update'])->name('coach.programs.update');
    Route::delete('/coach/programs/{program}', [ProgramController::class, 'destroy'])->name('coach.programs.destroy');
    Route::post('/coach/programs/{program}/workouts', [WorkoutController::class, 'store'])->name('coach.programs.workouts.store');
    Route::put('/coach/programs/{program}/workouts/{workout}', [WorkoutController::class, 'update'])->name('coach.programs.workouts.update');
    Route::delete('/coach/programs/{program}/workouts/{workout}', [WorkoutController::class, 'destroy'])->name('coach.programs.workouts.destroy');
    Route::post('/coach/workouts/{workout}/exercises', [ExerciseController::class, 'store'])->name('coach.workouts.exercises.store');
    Route::delete('/coach/workouts/{workout}/exercises/{exercise}', [ExerciseController::class, 'destroy'])->name('coach.workouts.exercises.destroy');
});
