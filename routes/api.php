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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'LoginControllerAPI@login')->name('login');
Route::middleware('auth:api')->post('logout','LoginControllerAPI@logout');



Route::get('home', 'HomeControllerAPI@index')->name('home');


//Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
//Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myprofile');

Route::middleware('auth:api')->put('users/updateProfile','UserControllerAPI@update');
Route::middleware('auth:api')->patch('users/password','UserControllerAPI@changePassword');

//Route::post('users/updatePhoto/{id}','UserControllerAPI@changePhoto');
//Route::post('users/updatePhotoRegister/{id}','UserControllerAPI@changePhotoRegister');



//us6

//Route::put('users/{id}','UserControllerAPI@update');

//us1
Route::get('home', 'WalletControllerAPI@index');
Route::middleware('auth:api')->get('getAuthUser','UserControllerAPI@getAuthUser');
//us2
Route::post('registerUser', 'RegisterControllerAPI@create');
Route::post('api/users/updatePhoto/', 'RegisterControllerAPI@changePhoto');
