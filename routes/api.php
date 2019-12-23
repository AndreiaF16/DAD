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

Route::get('movements', 'MovementControllerAPI@index');
Route::get('users/movements/{id}', 'MovementControllerAPI@show');
Route::get('users/wallet/movements', 'MovementControllerAPI@list');

//us6
Route::post('operator/registerIncome','OperatorControllerAPI@registerIncome');

//us1
Route::get('home', 'WalletControllerAPI@index');
Route::middleware('auth:api')->get('users/me','UserControllerAPI@getAuthUser');
Route::middleware('auth:api')->get('users/{email}','UserControllerAPI@getUser');
Route::middleware('auth:api')->get('getAuthUser','UserControllerAPI@getAuthUser');
//us2
Route::post('registerUser', 'RegisterControllerAPI@create');
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


Route::get('getphotobyemail/{email}','UserControllerAPI@getPhotoByEmail');
Route::post('users/email','UserControllerAPI@sendEmail');

//us 9
//Route::middleware('auth:api')->post('movements/debit', 'MovementControllerAPI@createDebit');

Route::middleware('auth:api')->get('categories/expense', 'CategoryControllerAPI@CategoriesExpense');
Route::middleware('auth:api')->get('categories', 'CategoryControllerAPI@Categories');