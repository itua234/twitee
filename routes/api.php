<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, 
    PostController,
    CommentController
};

Route::group(['prefix' => 'v1'], function () {
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post("/register", [AuthController::class, "store"]);
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/verify/code", [AuthController::class, "verifyUser"]);
        Route::post("/password-reset", [AuthController::class, "password_reset"]);
    });
});


//protected route using Laravel Sanctum
Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']],function(){
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post("/logout", [AuthController::class, "logout"]);
        Route::post("/refresh", [AuthController::class, "refresh"]);
        Route::post("/change-password", [AuthController::class, "change_password"]);
    });

    Route::group([
        'prefix' => 'post'
    ], function () {
        Route::post("/post", [PostController::class, "create"]);
        Route::get("/posts", [PostController::class, "getAll"]);
        Route::get("/post/{id}", [PostController::class, "getById"]);
        Route::delete("/post/{id}", [PostController::class, "delete"]);
    });

    Route::group([
        'prefix' => 'comment'
    ], function () {
        Route::post("/comment/{post_id}", [CommentController::class, "create"]);
        Route::delete("/comment/{post_id}/{id}", [CommentController::class, "delete"]);
    });

});
