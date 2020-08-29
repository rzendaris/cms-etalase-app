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
    if (env('ENV') == 'ADMIN'){
        /**
         * End Content Management Routes
         */
        /**
         * Cms User Etalase Routes
        */
        //user admin
        Route::get('user-management', 'Cms\UserManController@UserMgmtInit');
        Route::post('insert-user', 'Cms\UserManController@UserMgmtInsert');
        Route::post('update-user', 'Cms\UserManController@UserMgmtUpdate');
        Route::post('reset-pass-user', 'Cms\UserManController@UserMgmtResetPass');

        //user setting
        Route::get('profile', 'Cms\UserManController@UserMgmtProfile');
        Route::get('profile-admin', 'Cms\UserManController@UserMgmtProfileAdmin');
        Route::get('profile-password', 'Cms\UserManController@UserMgmtProfilePassword');
        Route::post('update-profile-user', 'Cms\UserManController@UserMgmtUpdateProfile');
        //end user
        Route::get('end-user-management', 'Cms\EndUserManController@EndUserMgmtInit');
        Route::get('add-end-user', 'Cms\EndUserManController@UserMgmtAddEndUser');
        Route::get('edit-end-user/{id}', 'Cms\EndUserManController@UserMgmtEditEndUser');
        Route::get('detail-end-user/{id}', 'Cms\EndUserManController@UserMgmtDetailEndUser');
        Route::post('insert-end-user', 'Cms\EndUserManController@UserMgmtInsert');
        Route::post('update-end-user', 'Cms\EndUserManController@UserMgmtUpdate');

        Route::post('delete-user', 'Cms\UserManController@UserMgmtDelete');
        Route::post('block-user', 'Cms\UserManController@UserMgmtBlock');
        Route::post('unblock-user', 'Cms\UserManController@UserMgmtUnBlock');
        Route::post('change-pass-user', 'Cms\UserManController@UserMgmtChangePass'); // change pass by user login
        //dev management
        Route::get('developer-management', 'Cms\DeveloperController@DeveloperInit');
        Route::get('add-developer-management', 'Cms\DeveloperController@DeveloperAdd');
        Route::get('save-add-apps', 'Cms\DeveloperController@SaveAddApps');
        Route::get('edit-developer-management/{id}', 'Cms\DeveloperController@DeveloperChangeInfo');
        Route::get('detail-developer-management/{id}', 'Cms\DeveloperController@DeveloperDetailInfo');
        Route::post('insert-developer-management', 'Cms\DeveloperController@DeveloperInsert');
        Route::post('update-developer-management', 'Cms\DeveloperController@DeveloperUpdate');
        //apps management
        Route::get('apps-management', 'Cms\AppsManController@AppsManInit');
        Route::get('partnership-apps-management', 'Cms\AppsManController@PartnershipIndex');
        Route::get('detail-apps-management/{id}', 'Cms\AppsManController@AppsManDetailInfo');
        Route::post('block-apps', 'Cms\AppsManController@AppsManBlock');
        Route::post('unblock-apps', 'Cms\AppsManController@AppsManUnBlock');
        Route::get('review-info/{id}', 'Cms\RatingController@RatingInit');
        Route::get('edit-apps-management/{id}', 'Cms\AppsManController@AppsManEdit');
        Route::post('update-apps-management', 'Cms\AppsManController@AppsManUpdate');
        Route::get('download-app/{id}', 'Cms\AppsManController@getDownload');
        //create app
        Route::get('add-app', 'Cms\AppsManController@AddApps');

        Route::post('create-apps', 'Cms\AppsManController@CreateApps');
        //view upload file
        Route::get('upload-media/{id}', 'Cms\AppsManController@UploadMedia');
        Route::get('upload-app/{id}', 'Cms\AppsManController@UploadApp');
        Route::get('upload-expansion/{id}', 'Cms\AppsManController@UploadExpansion');
        // upload file
        Route::post('create-media', 'Cms\AppsManController@CreateMedia');
        Route::post('created-app', 'Cms\AppsManController@CreatedApp');
        Route::post('create-expansion', 'Cms\AppsManController@CreateExpansion');
        //view updated file
        Route::get('edit-media/{id}', 'Cms\AppsManController@EditMedia');
        Route::get('edit-app/{id}', 'Cms\AppsManController@EditApp');
        Route::get('edit-expansion/{id}', 'Cms\AppsManController@EditExpansion');
        // updated file
        Route::post('update-media', 'Cms\AppsManController@UpdateMedia');
        Route::post('update-app', 'Cms\AppsManController@UpdateApp');
        Route::post('update-expansion', 'Cms\AppsManController@UpdateExpansion');

        Route::get('edit-apps-partnership/{id}', 'Cms\AppsManController@EditAppsPartnership'); //not used
        Route::get('add-apps-partnership', 'Cms\AppsManController@AddAppsPartnership'); //not used
        Route::post('create-apps-partnership', 'Cms\AppsManController@CreateAppsPartnership'); //not used
        Route::get('edit-apps-partnership', 'Cms\AppsManController@EditAppsPartnership'); //not used
        Route::post('update-apps-partnership', 'Cms\AppsManController@UpdateAppsPartnership');//not used

        Route::post('delete-apps', 'Cms\AppsManController@AppsManDelete');
        Route::get('approval-apps/{id}', 'Cms\AppsManController@ApprovalApps');
        Route::post('approved-apps', 'Cms\AppsManController@Approved');
        Route::post('rejected-apps', 'Cms\AppsManController@Rejected');
    } else if (env('ENV') == 'DEVELOPER'){
        /**
         * PUT endpoint for CMS of developer here
         */
         Route::get('profile', 'Cms\UserManController@UserMgmtProfile');
         Route::get('profile-password', 'Cms\UserManController@UserMgmtProfilePassword');
         Route::post('change-pass-user', 'Cms\UserManController@UserMgmtChangePass'); // change pass by user login
         Route::post('update-profile-user', 'Cms\UserManController@UserMgmtUpdateProfile');

         Route::get('download-app/{id}', 'DevInterface\AppsDeveloperController@getDownload');

         Route::get('apps-developer', 'DevInterface\AppsDeveloperController@AppsDevInit');
         Route::get('detail-apps-dev/{id}', 'DevInterface\AppsDeveloperController@AppsDevDetailInfo');
         Route::get('edit-apps-dev/{id}', 'DevInterface\AppsDeveloperController@AppsDevEdit');
         Route::post('update-apps-dev', 'DevInterface\AppsDeveloperController@AppsDevUpdate');
         Route::get('add-apps-dev', 'DevInterface\AppsDeveloperController@AddApps');

         Route::post('create-apps-dev', 'DevInterface\AppsDeveloperController@CreateApps');
         //view upload file
         Route::get('upload-media-dev/{id}', 'DevInterface\AppsDeveloperController@UploadMedia');
         Route::get('upload-app-dev/{id}', 'DevInterface\AppsDeveloperController@UploadApp');
         Route::get('upload-expansion-dev/{id}', 'DevInterface\AppsDeveloperController@UploadExpansion');
         // upload file
         Route::post('create-media-dev', 'DevInterface\AppsDeveloperController@CreateMedia');
         Route::post('created-app-dev', 'DevInterface\AppsDeveloperController@CreatedApp');
         Route::post('create-expansion-dev', 'DevInterface\AppsDeveloperController@CreateExpansion');
         //view updated file
         Route::get('edit-media-dev/{id}', 'DevInterface\AppsDeveloperController@EditMedia');
         Route::get('edit-app-dev/{id}', 'DevInterface\AppsDeveloperController@EditApp');
         Route::get('edit-expansion-dev/{id}', 'DevInterface\AppsDeveloperController@EditExpansion');
         // updated file
         Route::post('update-media-dev', 'DevInterface\AppsDeveloperController@UpdateMedia');
         Route::post('update-app-dev', 'DevInterface\AppsDeveloperController@UpdateApp');
         Route::post('update-expansion-dev', 'DevInterface\AppsDeveloperController@UpdateExpansion');
         Route::post('block-apps-dev', 'DevInterface\AppsDeveloperController@AppsDevBlock');
         Route::post('unblock-apps-dev', 'DevInterface\AppsDeveloperController@AppsDevUnBlock');
         Route::post('delete-apps', 'DevInterface\AppsDeveloperController@AppsDevDelete');\

         Route::get('review-info/{id}', 'DevInterface\FeedbacksController@RatingInit');
         Route::get('feedbacks-and-reply', 'DevInterface\FeedbacksController@FeedbacksInit');
         Route::post('reply-feedbacks', 'DevInterface\FeedbacksController@ReplyFeedbacks');
    }
});
Route::get('under-construction', 'HomeController@underConstruction');
Route::get('forgot-password', 'Auth\ForgotPasswordController@forgotPasswordInit');
Route::post('forgot-password-send-email', 'Auth\ForgotPasswordController@forgotPassword');
Route::get('forgot-password-verify/{token}', 'Auth\ForgotPasswordController@forgotPasswordVerify');
Route::post('change-password', 'Auth\ForgotPasswordController@changePassword');
Route::get('verify-account/{token}', 'HomeController@VerifyEmail');

// Route::get('user-management-cms', 'Cms\UserManController@UserMgmtInit');
// Route::post('user-management-cms/reset', 'Cms\UserManController@UserMgmtResetPass');
// Route::get('user-management-cms/profile', 'Cms\UserManController@UserMgmtProfile');
Route::get('register-dev', 'Auth\RegisterController@getRegister');
// FE Route Dummy Route::get('register-page', 'FeController@Register');
// Route::get('feedbacks-and-reply', 'FeController@Feedbacks');
// Route::get('add-application-developer', 'FeController@DevAdd');
// Route::get('edit-application-developer', 'FeController@DevEdit');
// Route::get('detail-application-developer', 'FeController@DevDetail');
