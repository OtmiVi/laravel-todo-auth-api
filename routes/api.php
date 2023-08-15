<?php

use App\Http\Controllers\Api\AuthControllerInterface;
use App\Http\Controllers\Api\TaskControllerInterface;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('task', TaskControllerInterface::class);
    Route::post('task/change/{id}', [TaskControllerInterface::class, 'changeStatus']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/auth/register', [AuthControllerInterface::class, 'register']);
Route::post('/auth/login', [AuthControllerInterface::class, 'login']);
Route::post('/auth/logout', [AuthControllerInterface::class, 'logout'])->middleware('auth:sanctum');
