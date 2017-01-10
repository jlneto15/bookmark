<?php

use Illuminate\Http\Request;

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

Route::post('/auth/login', 'AuthController@login');

Route::resource('/user', 'UserController', [
	'only' => ['index', 'show', 'store', 'update', 'destroy']
]);

Route::resource('/bookmark', 'BookmarkController', [
	'only' => ['index', 'show', 'store', 'update', 'destroy']
]);

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');