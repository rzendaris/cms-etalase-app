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

    /**
     * API Version 1
     */
Route::group(['prefix' => 'v1'], function () {

    Route::group(['middleware' => 'auth.api'], function() {
            Route::get('logout', 'API\v1\APIAuthController@logout');
            Route::get('user-info', 'API\v1\APIAuthController@user');
            Route::post('user-info/update-profile', 'API\v1\APIAuthController@updateProfile');
            Route::post('user-info/change-password', 'API\v1\APIAuthController@changePassword');
            
            Route::get('apps/action/{action}/{apps_id}', 'API\v1\AppsController@AppsAction');
            Route::get('apps/list-category', 'API\v1\AppsController@GetAppsCategory');
            Route::get('apps', 'API\v1\AppsController@GetAllApps');
            Route::get('apps/{id}/detail', 'API\v1\AppsController@AppDetail');
            Route::get('apps/{id}/review-feedback', 'API\v1\AppsController@GetAppReview');
            Route::post('apps/review', 'API\v1\AppsController@PostAppReview');
            Route::put('apps/review', 'API\v1\AppsController@PutAppReview');
            Route::delete('apps/review', 'API\v1\AppsController@DeleteAppReview');

            /**
             * Ads Management
             */
            Route::get('ads', 'API\v1\AdsController@GetAllAds');
    });
});
Route::any('{path}', function() {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
})->where('path', '.*');
