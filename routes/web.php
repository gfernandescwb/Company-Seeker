<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DownloadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return view('home');
    }
})->name("home");

Route::get('/dashboard/search-results', function () {
    return view('search-results');
})->name("searchResults");

Route::prefix('auth')->group(function () {
    Route::get('/login', [UserController::class, 'loginForm'])->name('login.form')->middleware('guest');
    Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
    Route::get('/sign-up', [UserController::class, 'signupForm'])->name('signup.form')->middleware('guest');
    Route::post('/sign-up', [UserController::class, 'signup'])->name('signup')->middleware('guest');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard/company/create', function () {
        return view('create-company');
    })->name("createCompany");
});
