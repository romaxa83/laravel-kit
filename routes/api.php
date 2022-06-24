<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('info', function(Request $request){
    return phpinfo();
})->name('api.v1.dealerships');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
