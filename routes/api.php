<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/lista', [ApiController::class, 'lista']);
Route::get('/get/{id}', [ApiController::class, 'get']);
Route::post('/add', [ApiController::class, 'add']);
Route::delete('/delete/{id}', [ApiController::class, 'delete']);
Route::post('/update/{id}', [ApiController::class, 'update']);
