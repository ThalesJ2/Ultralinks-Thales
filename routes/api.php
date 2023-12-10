<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserProtected;


Route::post("/user",[UserController::class,"create"]);
Route::post("auth", [UserController::class,"login"]);



Route::group(['middleware'=>[UserProtected::class]],function(){
    Route::post("/user/deposit",[UserController::class,"deposit"]);
    Route::get("/user",[UserController::class,"index"]);
});

Route::get("/",function(){
    return response()->json([
        'message'=> "sucesso"
    ]);
});


