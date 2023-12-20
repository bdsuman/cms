<?php

use App\Http\Controllers\Api\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
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

Route::post('/user-login',[UserController::class,'UserLogin']);
Route::get('/article-list',[ArticleController::class,'ArticleList']);
Route::get('/article/{slug}',[ArticleController::class,'ArticleBySlug']);
Route::get("/article/category/{id}",[ArticleController::class,'ArticleByCategoryID']);
Route::group(['prefix' => '', 'middleware' => ['jwt-auth']], function() {
    Route::get('/article/user/list',[ArticleController::class,'ArticleListByUser']);
    Route::post("/create-article",[ArticleController::class,'CreateArticle']);
    Route::post("/delete-article",[ArticleController::class,'DeleteArticle']);
    Route::post("/update-article",[ArticleController::class,'UpdateArticle']);
    Route::post("/article-by-id",[ArticleController::class,'ArticleByID']);
});

Route::fallback(function() {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});