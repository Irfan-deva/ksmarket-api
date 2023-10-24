<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//PUBLIC ROUTES
Route::post('/register', [AuthController::class, 'register']);
Route::get('/products', [ProductController::class, 'index']);



//PROTECTED ROUTES
Route::group(['middleware' => ['auth:sanctum']], function () {
});
