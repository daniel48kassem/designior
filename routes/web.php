<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/upload',[\App\Http\Controllers\ImageUploadController::class,'create'])
    ->name('upload-design');
Route::post('/upload',[\App\Http\Controllers\ImageUploadController::class,'upload']);
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

