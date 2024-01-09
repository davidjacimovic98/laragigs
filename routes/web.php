<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Common Resource Routes:
// index - Show all jobs
// show - Show single job
// create - Show form to create new job
// store - Store new job
// edit - Show form to edit job
// update - Update job
// destroy - Delete job

// All jobs
Route::get('/', [JobController::class, 'index']);

// Show create form
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');

// Store new job data
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');

// Show edit form
Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->middleware('auth');

// Update job
Route::put('/jobs/{job}', [JobController::class, 'update'])->middleware('auth');

// Remove job
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->middleware('auth');

// Manage jobs
Route::get('/jobs/manage', [JobController::class, 'manage'])->middleware('auth');

// Single job
Route::get('/jobs/{job}', [JobController::class, 'show']);

// Show register/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create new user
Route::post('/users', [UserController::class, 'store']);

// Log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log user in
Route::post('/users/authenticate', [UserController::class, 'authenticate']);