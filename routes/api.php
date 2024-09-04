<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login', 'App\Http\Controllers\Auth\AuthController@login')->name('login.api');
Route::post('/register','App\Http\Controllers\Auth\AuthController@register')->name('register.api');
Route::middleware('auth:sanctum')->post('/logout', 'App\Http\Controllers\Auth\AuthController@logout')->name('logout.api');
Route::post('/forgot', 'App\Http\Controllers\Auth\AuthController@forgot')->name('forgot.api');
Route::post('/reset', 'App\Http\Controllers\Auth\AuthController@reset')->name('reset.api');
Route::apiResource('users', 'App\Http\Controllers\UserController')->middleware('auth:sanctum');
Route::delete('/removeToCart/{user}', 'App\Http\Controllers\UserController@removeToCart')->name('removeToCart.api');
Route::get('/usersInCart', 'App\Http\Controllers\UserController@usersInCart')->name('usersInCart.api');
Route::patch('/recoverFromCart/{user}', 'App\Http\Controllers\UserController@recoverFromCart')->withTrashed()->name('recoverFromCart.api');
Route::delete('/removeToCartGroup', 'App\Http\Controllers\UserController@removeToCartGroup')->name('removeToCartGroup.api');
Route::delete('/deleteGroup', 'App\Http\Controllers\UserController@deleteGroup')->name('deleteGroup.api');
Route::patch('/recoverGroupFromCart', 'App\Http\Controllers\UserController@recoverGroupFromCart')->withTrashed()->name('recoverGroupFromCart.api');
