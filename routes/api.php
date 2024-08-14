<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductControllerAPI;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;


Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::middleware(['auth:sanctum', 'request.log',])->group(function() {
    Route::apiResource('/products', ProductControllerAPI::class)->names('api.products');
    Route::apiResource('/stores', StoreController::class)->names('api.stores')->middleware('admin');
    Route::apiResource('/brands', BrandController::class)->names('api.brands');
    Route::apiResource('/categories', CategoryController::class)->names('api.categories');
    Route::post('/logout', [UserController::class, 'logout']);
});




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


