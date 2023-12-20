<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;


// Web API Routes
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);


// User Logout
Route::get('/logout',[UserController::class,'UserLogout']);

// Page Routes
Route::get('/',[HomeController::class,'HomePage']);
Route::get('/documentation',function(){
    return '<h1>This is an Rest API Based CMS Project </h1><hr><a href="https://documenter.getpostman.com/view/27190127/2s9Ykq7LE6" target="_blank">Click On See Postman Documentation</a>
    <br><br><a href="https://github.com/bdsuman/cms" target="_blank">Click On See Source Code GitHub</a>
    ';
});

Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/articlePage',[ArticleController::class,'ArticlePage'])->middleware([TokenVerificationMiddleware::class]);
// Category API
Route::post("/create-category",[CategoryController::class,'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-category",[CategoryController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-category",[CategoryController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-category",[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/article-category-list",[CategoryController::class,'ArticleCategoryList'])->middleware([TokenVerificationMiddleware::class]);

// Article API
Route::post("/create-article",[ArticleController::class,'CreateArticle'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-article",[ArticleController::class,'DeleteArticle'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-article",[ArticleController::class,'UpdateArticle'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-article",[ArticleController::class,'ArticleList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/article-by-id",[ArticleController::class,'ArticleByID'])->middleware([TokenVerificationMiddleware::class]);
// SUMMARY
Route::get("/summary",[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);



