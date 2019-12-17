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

Route::middleware('auth:api')->put('users/updateProfile','UserControllerAPI@update');
Route::middleware('auth:api')->patch('users/password','UserControllerAPI@changePassword');

Route::middleware('auth:api')->get('users/myVirtualWallets','WalletControllerAPI@showVirtualWallet');
//Route::middleware(['auth:api','u'])->get('users/myVirtualWallets', 'WalletControllerAPI@movementsWithCategoriesandUsers');

//Route::get('wallets', 'WalletControllerAPI@index');
//Route::middleware(['auth:api'])->get('wallets/{id}', 'WalletControllerAPI@index');
//Route::middleware(['auth:api'])->get('wallets/{id}', 'WalletControllerAPI@myWallets');

//Route::post('users/updatePhoto/{id}','UserControllerAPI@changePhoto');
//Route::post('users/updatePhotoRegister/{id}','UserControllerAPI@changePhotoRegister');

Route::get('movements', 'MovementControllerAPI@index');
Route::get('users/movements/{id}', 'MovementControllerAPI@show');
Route::get('users/wallet/movements', 'MovementControllerAPI@list');

//us6
Route::post('operator/registerIncome','OperatorControllerAPI@registerIncome');
//Route::put('users/{id}','UserControllerAPI@update');

//us1
Route::get('home', 'WalletControllerAPI@index');
Route::middleware('auth:api')->get('users/me','UserControllerAPI@getAuthUser');
Route::middleware('auth:api')->get('getAuthUser','UserControllerAPI@getAuthUser');
//us2
Route::post('registerUser', 'RegisterControllerAPI@create');
//Route::get('register/activate/{token}', 'RegisterControllerAPI@accountValidate');
//Route::post('api/users/updatePhoto/', 'RegisterControllerAPI@changePhoto');

//7
Route::middleware('auth:api')->get('movements/{id}', 'MovementControllerAPI@getUserMovements');



Route::middleware('auth:api')->post('movements/credit', 'MovementControllerAPI@createCredit');
Route::middleware('auth:api')->post('movements/debit', 'MovementControllerAPI@createDebit');
Route::middleware('auth:api')->post('movements/filter', 'MovementControllerAPI@getFilteredMovements');
Route::middleware('auth:api')->put('movements/{id}', 'MovementControllerAPI@update');

//us 15 e 16
Route::middleware('auth:api')->post('createUser', 'UserControllerAPI@store');
Route::middleware('auth:api')->post('users/filter', 'UserControllerAPI@getFilteredUsers');
Route::middleware('auth:api')->put('users/deactivate/{id}', 'UserControllerAPI@deactivateUser');
Route::middleware('auth:api')->put('users/activate/{id}', 'UserControllerAPI@activateUser');
Route::middleware('auth:api')->delete('users/{id}', 'UserControllerAPI@destroy');
