<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AudioTranslationController;

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


Route::get('/audio-translation/upload', [AudioTranslationController::class, 'upload'])->name('audio-translation.upload');
Route::post('/audio-translation/process', [AudioTranslationController::class, 'process'])->name('audio-translation.process');

Route::get('/dalle', [\App\Http\Controllers\DalleController::class, 'index'])->name('dalle');
// Ruta para enviar peticiones a DALL-E 3
Route::post('/dalle/generate', [\App\Http\Controllers\DalleController::class, 'generateImage'])->name('dalle.generate');