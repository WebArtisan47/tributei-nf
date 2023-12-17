<?php

use App\Http\Controllers\NFeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('cadastrar-request', [NFeController::class , 'createRequest']);
Route::post('emitir-nfe', [NFeController::class, 'EmitirFocus']);
Route::get('download', [NFeController::class, 'DownloadFile']);