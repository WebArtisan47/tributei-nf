<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\middleware;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Inertia\Inertia;

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

Route::get('/login',[LoginController::class, 'Login'])->name('login');
Route::post('/auth', [LoginController::class, 'authenticate'])->name('auth');
Route::post('/sair', [LogoutController::class, 'logout'])->name('logout');
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/view/user/{id}', [UserController::class, 'show']);
