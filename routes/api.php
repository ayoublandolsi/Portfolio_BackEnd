<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LikeController;



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
Route::post('/messages/{user_id}', [App\Http\Controllers\ChatController::class, 'sendMessage']);
Route::post('/contacts', [App\Http\Controllers\ContactController::class, 'store']);
Route::resource('/projects', ProjectController::class);
Route::resource('/coment', CommentController::class);
Route::get('/alluser', [CommentController::class,'getAllUsers']);

Route::post('/likes/create', [LikeController::class, 'create']);
Route::delete('/likes/delete', [LikeController::class, 'delete']);
Route::get('/likes/count', [LikeController::class, 'count']);





Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
