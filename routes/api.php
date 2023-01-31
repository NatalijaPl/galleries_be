<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('register', 'AuthController@register');

    Route::get('galleries', 'GalleriesController@index');
    Route::get('galleries/{id}', 'GalleriesController@show');
    Route::post('galleries', 'GalleriesController@store');
    Route::put('galleries/{id}', 'GalleriesController@update');
    Route::delete('galleries/{id}', 'GalleriesController@destroy');

    Route::get('/galleries/{id}/comments', 'CommentsController@index');
    Route::post('/galleries/{id}/comments', 'CommentsController@store');
    Route::delete('/comments/{id}', 'CommentsController@destroy');

    Route::get('/user/{id}', 'UserController@show');
});
