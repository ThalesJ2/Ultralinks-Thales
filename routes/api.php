<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get("/user",[UserController::class,"index"]);
Route::post("/user",[UserController::class,"create"]);

Route::get("/",function(){
    return response()->json([
        'message'=> "sucesso"
    ]);
});

