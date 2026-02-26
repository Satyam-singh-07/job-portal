<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/jobs', function () {
    return view('jobs.index');
})->name('jobs.index');

Route::get('/job-detail', function () {
    return view('jobs.show');
})->name('jobs.show');

Route::get('/employers', function () {
    return view('employers.index');
})->name('employers.index');

Route::get('/employer/dashboard', function () {
    return view('employers.dashboard');
})->name('employer.dashboard');

Route::get('/company-detail', function () {
    return view('employers.show');
})->name('company.show');

Route::get('/employer/post-job', function () {
    return view('employer.post-job');
})->name('employer.post-job');


Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');
