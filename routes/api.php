<?php

use App\Http\Controllers\Api\V1\FileController;
use  App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\GroupController;
use App\Http\Controllers\Api\V1\OperationController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
//TODO::File mangement
Route::resource('files', FileController::class);

//TODO::Group mangement
Route::resource('groups', GroupController::class);
//TODO:: add one group public
Route::singleton('public', PasswordController::class);





//////////////////////////////Start Section Files///////////////////////////////
//TODO::Operation management
Route::controller(OperationController::class)->group(function () {
    Route::post('addfile/{file}', 'addFileToGroup')->name('groups.addfile');
});
//////////////////////////////End Section Files///////////////////////////////