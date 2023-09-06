<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\WorkerController;

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

    Route::group([
        'middleware' => ['DbBackup'],
        'prefix' => 'admins'
    ], function ($router) {
        Route::post('/login', [AdminController::class, 'login']);
        Route::post('/register', [AdminController::class, 'register']);
        Route::post('/logout', [AdminController::class, 'logout']);
        Route::post('/refresh', [AdminController::class, 'refresh']);
        Route::get('/admin-profile', [AdminController::class, 'adminProfile']);    
    });


    Route::group([
        'middleware' => ['DbBackup'],
        'prefix' => 'workers'
    ], function ($router) {
        Route::post('/login', [WorkerController::class, 'login']);
        Route::post('/register', [WorkerController::class, 'register']);
        Route::post('/logout', [WorkerController::class, 'logout']);
        Route::post('/upload-photo/{worker}', [WorkerController::class, 'uploadPhoto']);
        Route::post('/refresh', [WorkerController::class, 'refresh']);
        Route::get('/worker-profile', [WorkerController::class, 'workerProfile']);    
    });

    Route::group([
        'middleware' => ['DbBackup'],
        'prefix' => 'clients'
    ], function ($router) {
        Route::post('/login', [ClientController::class, 'login']);
        Route::post('/register', [ClientController::class, 'register']);
        Route::post('/logout', [ClientController::class, 'logout']);
        Route::post('/upload-photo/{client}', [ClientController::class, 'uploadPhoto']);
        Route::post('/refresh', [ClientController::class, 'refresh']);
        Route::get('/client-profile', [ClientController::class, 'clientProfile']);    
    });

  
   
