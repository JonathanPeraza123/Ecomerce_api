<?php

use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\TypeController;
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


Route::apiResource('p', ProductController::class);

Route::post('variation/{product}', [ProductController::class, 'storeVariation'])
    ->name('api.v1.storeVariation.product');

Route::apiResource('categories', CategoryController::class);

Route::apiResource('brands', BrandController::class);

Route::get('categories/{category}/s/{type}', [TypeController::class, 'show'])->name('api.v1.show.type');
