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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('v1/login', 'API\v1\APIAuthController@login');
Route::post('v1/register', 'API\v1\APIAuthController@register');
Route::post('v1/forgot-password', 'API\v1\APIAuthController@forgotPassword');

Route::group(['middleware' => 'auth.api'], function() {
    /**
     * API Version 1
     */
    Route::group(['prefix' => 'v1'], function () {
        Route::get('logout', 'API\v1\APIAuthController@logout');
        Route::get('user', 'API\v1\APIAuthController@user');
    });
});
