<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@main')->middleware('verified');
Route::middleware('auth')->group(function() {

    Route::get('/', 'HomeController@main')->middleware('verified');
    Route::get('dashboard', 'Admin\DashboardController@Dashboard');

    Route::get('user-management-fe', 'Admin\UserManController@UserMgmtInit');
    Route::post('user-management-fe/insert', 'Admin\UserManController@UserMgmtInsert');
    Route::post('user-management-fe/update', 'Admin\UserManController@UserMgmtUpdate');
    Route::post('user-management-fe/delete', 'Admin\UserManController@UserMgmtDelete');

    Route::get('master/ethnic', 'Admin\EthnicManController@EthnicInit');
    Route::post('master/ethnic/insert', 'Admin\EthnicManController@EthnicInsert');
    Route::post('master/ethnic/update', 'Admin\EthnicManController@EthnicUpdate');
    Route::post('master/ethnic/delete', 'Admin\EthnicManController@EthnicDelete');

    Route::get('master/degree', 'Admin\DegreeManController@DegreeInit');
    Route::post('master/degree/insert', 'Admin\DegreeManController@DegreeInsert');
    Route::post('master/degree/update', 'Admin\DegreeManController@DegreeUpdate');
    Route::post('master/degree/delete', 'Admin\DegreeManController@DegreeDelete');

    Route::get('master/job', 'Admin\JobManController@JobInit');
    Route::post('master/job/insert', 'Admin\JobManController@JobInsert');
    Route::post('master/job/update', 'Admin\JobManController@JobUpdate');
    Route::post('master/job/delete', 'Admin\JobManController@JobDelete');

    Route::get('master/province', 'Admin\ProvinceManController@ProvinceInit');
    Route::post('master/province/insert', 'Admin\ProvinceManController@ProvinceInsert');
    Route::post('master/province/update', 'Admin\ProvinceManController@ProvinceUpdate');
    Route::post('master/province/delete', 'Admin\ProvinceManController@ProvinceDelete');

    Route::get('master/city', 'Admin\CityManController@CityInit');
    Route::post('master/city/insert', 'Admin\CityManController@CityInsert');
    Route::post('master/city/update', 'Admin\CityManController@CityUpdate');
    Route::post('master/city/delete', 'Admin\CityManController@CityDelete');

    Route::get('master/district', 'Admin\DistrictManController@DistrictInit');
    Route::post('master/district/insert', 'Admin\DistrictManController@DistrictInsert');
    Route::post('master/district/update', 'Admin\DistrictManController@DistrictUpdate');
    Route::post('master/district/delete', 'Admin\DistrictManController@DistrictDelete');
    Route::get('master/district/get-list-city/{province_id}', 'Admin\DistrictManController@GetListCity');

    Route::get('master/village', 'Admin\VillageManController@VillageInit');
    Route::post('master/village/insert', 'Admin\VillageManController@VillageInsert');
    Route::post('master/village/update', 'Admin\VillageManController@VillageUpdate');
    Route::post('master/village/delete', 'Admin\VillageManController@VillageDelete');
    Route::get('master/village/get-list-district/{city_id}', 'Admin\VillageManController@GetListDistrict');
    Route::get('master/village/get-list-village/{district_id}', 'Admin\VillageManController@GetListVillage');

    Route::get('family-management', 'Admin\FamilyManController@FamilyManInit');
    Route::get('family-management/add', 'Admin\FamilyManController@FamilyManAdd');
    Route::post('family-management/insert', 'Admin\FamilyManController@FamilyManInsert');
    Route::get('family-management/edit/{family_id}', 'Admin\FamilyManController@FamilyManEdit');
    Route::get('family-management/edit/family/{family_id}', 'Admin\FamilyManController@FamilyManEditFamily');
    Route::post('family-management/update', 'Admin\FamilyManController@FamilyManUpdate');
    Route::post('family-management/delete', 'Admin\FamilyManController@FamilyManDelete');
    Route::post('family-management/member/insert', 'Admin\FamilyManController@FamilyMemberInsert');
    Route::post('family-management/member/delete', 'Admin\FamilyManController@FamilyMemberDelete');
    Route::post('family-management/member/update', 'Admin\FamilyManController@FamilyMemberUpdate');
    Route::get('family-management/member/edit/{family_id}/{member_id}', 'Admin\FamilyManController@FamilyMemberEditView');

    Route::get('family-tree', 'Admin\FamilyTreeController@FamilyTreeInit');
    Route::get('family-tree-detail/{member_id}', 'Admin\FamilyTreeController@FamilyTreeDetail');

    Route::get('report', 'Admin\ReportingController@ReportInit');
    Route::get('report-filter/{type}', 'Admin\ReportingController@ReportFilter');
    /**
     * End Content Management Routes
     */
     /**
      * Cms User Etalase Routes
      */
     Route::get('profile', 'Cms\UserManController@UserMgmtProfile');
     Route::get('profile-password', 'Cms\UserManController@UserMgmtProfilePassword');
     Route::get('end-user-management', 'Cms\UserManController@UserMgmtInit');
     Route::get('add-end-user', 'Cms\UserManController@UserMgmtAddEndUser');
     Route::get('edit-end-user/{id}', 'Cms\UserManController@UserMgmtEditEndUser');
     Route::get('detail-end-user/{id}', 'Cms\UserManController@UserMgmtDetailEndUser');
     Route::post('insert-end-user', 'Cms\UserManController@UserMgmtInsert');
     Route::post('update-end-user', 'Cms\UserManController@UserMgmtUpdate');
     Route::post('update-profile-user', 'Cms\UserManController@UserMgmtUpdateProfile');
     Route::post('delete-end-user', 'Cms\UserManController@UserMgmtDelete');
     Route::post('block-end-user', 'Cms\UserManController@UserMgmtBlock');
     Route::post('unblock-end-user', 'Cms\UserManController@UserMgmtUnBlock');
     Route::post('change-pass-user', 'Cms\UserManController@UserMgmtChangePass'); // change pass by user login
     Route::post('reset-pass-user', 'Cms\UserManController@UserMgmtResetPass'); // change pass by id user
});
Route::get('under-construction', 'HomeController@underConstruction');
Route::get('forgot-password', 'Auth\ForgotPasswordController@forgotPasswordInit');
Route::post('forgot-password-send-email', 'Auth\ForgotPasswordController@forgotPassword');
Route::get('forgot-password-verify/{token}', 'Auth\ForgotPasswordController@forgotPasswordVerify');
Route::post('change-password', 'Auth\ForgotPasswordController@changePassword');

// Route::get('user-management-cms', 'Cms\UserManController@UserMgmtInit');
// Route::post('user-management-cms/reset', 'Cms\UserManController@UserMgmtResetPass');
// Route::get('user-management-cms/profile', 'Cms\UserManController@UserMgmtProfile');
// FE Route Dummy
Route::get('register-page', 'FeController@Register');
Route::get('register-dev', 'Auth\RegisterController@getRegister');
Route::get('developer-management', 'FeController@DeveloperManagement');
Route::get('add-developer-management', 'FeController@AddDeveloperManagement');
Route::get('edit-developer-management', 'FeController@EditDeveloperManagement');
Route::get('detail-developer-management', 'FeController@DetailDeveloperManagement');