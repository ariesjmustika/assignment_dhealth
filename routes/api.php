<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    // Route::get('/show', [ProjectController::class, 'index']);
    Route::get('/email', [AuthController::class, 'checkEmail']);
});

Route::group(['middleware' => 'api','prefix' => 'project'], function ($router) {

    Route::get('/project', [ProjectController::class, 'project']);
    Route::get('/get-projects', [ProjectController::class, 'getProjects']);
    Route::post('/create', [ProjectController::class, 'store']);
    Route::post('/update', [ProjectController::class, 'update']);
    Route::post('/destroy', [ProjectController::class, 'destroy']);

    // Route::post('/deletetest', [ProjectController::class, 'destroy']);

});

Route::group(['middleware' => 'api','prefix' => 'client'], function ($router) {

    Route::get('/get-clients', [ClientController::class, 'getClients']);
});
