<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profiler;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//  Route::get('products', [ProductController::class, 'index']);
//  Route::post('store', [ProductController::class, 'store']);
//  Route::get('show/{id}', [ProductController::class, 'show']);
//  Route::post('update/{id}', [ProductController::class, 'update']);
//  Route::delete('products/{id}', [ProductController::class, 'destroy']);

Route::apiResource('id',ProductController::class);


