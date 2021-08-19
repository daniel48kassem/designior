<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'auth:api'],function (){
    Route::post('/upload',[\App\Http\Controllers\ImageUploadController::class,'upload']);
});

Route::get('/images/{image}',[\App\Http\Controllers\ImageController::class,'previewImage']);

Route::get('/images/{image}/download',[\App\Http\Controllers\ImageUploadController::class,'resize']);
//Route::get('/designer/{user}/images',[\App\Http\Controllers\DesignerImageController::class,'index']);


//Auth passport
Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/register/designer',[\App\Http\Controllers\AuthController::class,'registerAsDesigner']);
Route::post('/register/customer',[\App\Http\Controllers\AuthController::class,'registerAsCustomer']);
