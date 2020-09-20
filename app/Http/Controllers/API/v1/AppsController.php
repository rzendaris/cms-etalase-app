<?php
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use ApkParser\Parser;

use App\User;
use App\Model\Table\Apps;
use App\Model\Table\DownloadApps;
use App\Model\Table\MstCategories;
use App\Model\View\AvgRatings;
use App\Model\Table\Ratings;

class AppsController extends Controller
{
    public function GetAllApps(Request $request)
    {
        if (isset($request)){
            $apps = $this->searchEngine($request);
        } else {
            $apps = Apps::where('is_active', 1)->where('is_approve', 1)->get();
        }
        $temp_array_unset = array();
        foreach($apps as $key => $data){
            $apk_manifest = $this->CheckApkPackage($data->apk_file);
            if((int)$request->sdk_version < $apk_manifest['min_sdk_level']){
                array_push($temp_array_unset, $key);
            }
            $apps_status = 'DOWNLOAD';
            $download_at = '';
            $installed_apps = DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $data->id)->first();
            if(isset($installed_apps)){
                if($apk_manifest['version_code'] != (int)$data->version){
                    $apps_status = "UPDATE";
                } else {
                    $apps_status = "INSTALLED";
                }
                $download_at = $installed_apps->clicked_at;
            }
            $data->download_at = $download_at;
            $data->apps_status = $apps_status;
            $data->developers = $this->getDevelopers($data->developer_id);
        }
        foreach($temp_array_unset as $key){
            $apps->forget($key);
        }
        $data = array();
        foreach($apps as $app){
            if($app->media != NULL){
                $media = (array)json_decode($app->media);
                $temp_array_media = array();
                for($i = 1; $i < 20; $i++){
                    if(isset($media['media'.$i])){
                        array_push($temp_array_media, "media/".$media['media'.$i]);
                    } else {
                        break;
                    }
                }
                $app->media = $temp_array_media;
            }
            $apps_detail = AvgRatings::where('id', $app->id)->where('is_active', 1)->where('is_approve', 1)->first();
            $avg_ratings = 0;
            if($apps_detail->avg_ratings != NULL){
                $avg_ratings = $apps_detail->avg_ratings;
            }
            $rating = array(
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
            );
            for($x = 1; $x <= 5; $x++){
                $rating[$x] = Ratings::where('apps_id', $app->id)->where('ratings', $x)->count();
            }
            $app->rate_details = $rating;
            $app->avg_ratings = $avg_ratings;
            array_push($data, $app);
        }
        return $this->appResponse(100, 200, $data);
    }

    public function GetAppInstalled(Request $request)
    {
        $request->validate([
            "data" => "required|array",
            'data.*.package_name' => 'required|string',
            'data.*.version' => 'required|string',
        ]);
        $temp_array = array();
        foreach($request->data as $list_app){
            $apps = Apps::where('package_name', $list_app['package_name'])->where('is_active', 1)->where('is_approve', 1)->first();
            if(isset($apps)){
                if($list_app['version'] != $apps->version){
                    $apps_status = "UPDATE";
                } else {
                    $apps_status = "INSTALLED";
                }
                $apps->apps_status = $apps_status;
                if($apps->media != NULL){
                    $media = (array)json_decode($apps->media);
                    $temp_array_media = array();
                    for($i = 1; $i < 20; $i++){
                        if(isset($media['media'.$i])){
                            array_push($temp_array_media, "media/".$media['media'.$i]);
                        } else {
                            break;
                        }
                    }
                    $apps->media = $temp_array_media;
                }
                $apps->developers = $this->getDevelopers($apps->developer_id);

                $apps_detail = AvgRatings::where('id', $apps->id)->where('is_active', 1)->where('is_approve', 1)->first();
                $avg_ratings = 0;
                if($apps_detail->avg_ratings != NULL){
                    $avg_ratings = $apps_detail->avg_ratings;
                }
                $rating = array(
                    '1' => 0,
                    '2' => 0,
                    '3' => 0,
                    '4' => 0,
                    '5' => 0,
                );
                for($x = 1; $x <= 5; $x++){
                    $rating[$x] = Ratings::where('apps_id', $apps->id)->where('ratings', $x)->count();
                }
                $apps->rate_details = $rating;
                $apps->avg_ratings = $avg_ratings;
                array_push($temp_array, $apps);
            }
        }
        // if (isset($request)){
        //     $apps = $this->searchEngine($request);
        // } else {
        //     $apps = Apps::where('is_active', 1)->where('is_approve', 1)->get();
        // }
        // $temp_array_unset = array();
        // foreach($apps as $key => $data){
        //     $apk_manifest = $this->CheckApkPackage($data->apk_file);
        //     if((int)$request->sdk_version < $apk_manifest['min_sdk_level']){
        //         array_push($temp_array_unset, $key);
        //     }
        //     $download_at = '';
        //     $installed_apps = DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $data->id)->first();
        //     if(isset($installed_apps)){
        //         if($apk_manifest['version_code'] != (int)$data->version){
        //             $apps_status = "UPDATE";
        //         } else {
        //             $apps_status = "INSTALLED";
        //         }
        //         $download_at = $installed_apps->clicked_at;
        //         $data->download_at = $download_at;
        //         $data->apps_status = $apps_status;
        //     } else {
        //         array_push($temp_array_unset, $key);
        //     }
        // }
        // foreach($temp_array_unset as $key){
        //     $apps->forget($key);
        // }
        // $data = array();
        // foreach($apps as $app){
        //     array_push($data, $app);
        // }
        return $this->appResponse(100, 200, $temp_array);
    }

    public function AppDetail(Request $request, $id)
    {
        $apps = Apps::where('package_name', $request->package_name)->where('is_active', 1)->where('is_approve', 1)->first();
        if(isset($apps)){
            $apps_status = "DOWNLOAD";
            if($request->version != '0'){
                if($request->version != $apps->version){
                    $apps_status = "UPDATE";
                } else {
                    $apps_status = "INSTALLED";
                }
            }
            $apps->apps_status = $apps_status;
            if($apps->media != NULL){
                $media = (array)json_decode($apps->media);
                $temp_array_media = array();
                for($i = 1; $i < 20; $i++){
                    if(isset($media['media'.$i])){
                        array_push($temp_array_media, "media/".$media['media'.$i]);
                    } else {
                        break;
                    }
                }
                $apps->media = $temp_array_media;
            }
            $apps->developers = $this->getDevelopers($apps->developer_id);

            $apps_detail = AvgRatings::where('id', $apps->id)->where('is_active', 1)->where('is_approve', 1)->first();
            $avg_ratings = 0;
            if($apps_detail->avg_ratings != NULL){
                $avg_ratings = $apps_detail->avg_ratings;
            }
            $rating = array(
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
            );
            for($x = 1; $x <= 5; $x++){
                $rating[$x] = Ratings::where('apps_id', $apps->id)->where('ratings', $x)->count();
            }
            $apps->rate_details = $rating;
            $apps->avg_ratings = $avg_ratings;

            $review = Ratings::with(['endusers'=>function($query){
                $query->select('id','name','email','picture');
            }])->where('apps_id', $apps->id)->get();

            $user_active = array();
            $all_user = array();
            foreach($review as $app_review){
                $app_review->endusers->picture = "pictures/".$app_review->endusers->picture;
                if($app_review->endusers->id == $request->user_id){
                    array_push($user_active, $app_review);
                } else {
                    array_push($all_user, $app_review);
                }
            }
            $apps->review = array_merge($user_active, $all_user);
            return $this->appResponse(100, 200, $apps);
        } else {
            return $this->appResponse(104, 200);
        }
    }

    public function AppsAction(Request $request, $action, $apps_id)
    {
        $data = "Action > ".$action." --- "."Apps Id > ".$apps_id;
        $apps = Apps::where('id', $apps_id)->where('is_active', 1)->where('is_approve', 1)->first();
        if(isset($apps)){
            $installed_apps = DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $apps->id)->first();
            if($action == "DOWNLOAD"){
                $apk_manifest = $this->CheckApkPackage($apps->apk_file);
                $apps_download = new DownloadApps([
                    'end_users_id' => $request->user_id,
                    'apps_id' => $apps->id,
                    'version' => $apk_manifest['version_code']
                ]);
                $apps_download->save();
                $return = array(
                    'path_file' => "apk/".$apps->apk_file
                );
                return $this->appResponse(200, 200, $return);

            } else if($action == "UPDATE"){

                if(isset($installed_apps)){
                    $apk_manifest = $this->CheckApkPackage($apps->apk_file);
                    DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $apps->id)->update(['version' => $apk_manifest['version_code']]);
                    $return = array(
                        'path_file' => "apk/".$apps->apk_file
                    );
                    return $this->appResponse(200, 200, $return);
                } else {
                    return $this->appResponse(104, 200, "Please Download before!");
                }

            } else {
                return $this->appResponse(104, 200, "ACTION NOT FOUND");
            }
        } else {
            return $this->appResponse(104, 200);
        }
    }
    public function PostAppDownloaded(Request $request)
    {
        $request->validate([
            'apps_id' => 'required|integer',
        ]);
        $apps = Apps::where('id', $request->apps_id)->where('is_active', 1)->where('is_approve', 1)->first();
        if(isset($apps)){
            $installed_apps = DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $apps->id)->first();
            if(empty($installed_apps)){
                $apk_manifest = $this->CheckApkPackage($apps->apk_file);
                $apps_download = new DownloadApps([
                    'end_users_id' => $request->user_id,
                    'apps_id' => $apps->id,
                    'version' => $apk_manifest['version_code']
                ]);
                $apps_download->save();
                $return = array(
                    'path_file' => "apk/".$apps->apk_file
                );
            }
            $installed_apps_return = DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $apps->id)->first();
            $installed_apps_return->download_at = $installed_apps_return->clicked_at;
            return $this->appResponse(200, 200, $installed_apps_return);
        } else {
            return $this->appResponse(104, 200);
        }
    }

    public function GetAppsCategory(Request $request)
    {
        if (isset($request->type_apps)){
            $select_apps_category = Apps::select(['category_id'])->where('type', $request->type_apps)->where('is_active', 1)->where('is_approve', 1)->groupBy('category_id')->get();
        } else {
            $select_apps_category = Apps::select(['category_id'])->where('is_active', 1)->where('is_approve', 1)->groupBy('category_id')->get();
        }
        $apps_category = MstCategories::whereIn('id', $select_apps_category)->get();
        foreach($apps_category as $app_category){
            $app_category->icon = "icon_category/".$app_category->icon;
        }
        return $this->appResponse(100, 200, $apps_category);
    }

    public function GetAppReview(Request $request, $apps_id){
        $apps = AvgRatings::where('id', $apps_id)->where('is_active', 1)->where('is_approve', 1)->first();
        if(empty($apps)){
            return $this->appResponse(104, 200, "App ID Not Found!");
        }
        if($apps->avg_ratings == NULL){
            $apps->avg_ratings = 0;
        }
        $rating = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        );
        for($x = 1; $x <= 5; $x++){
            $rating[$x] = Ratings::where('apps_id', $apps->id)->where('ratings', $x)->count();
        }
        $apps->rate_details = $rating;

        $review = Ratings::with(['endusers'=>function($query){
            $query->select('id','name','email','picture');
        }])->where('apps_id', $apps->id)->get();

        $user_active = array();
        $all_user = array();
        foreach($review as $app_review){
            $app_review->endusers->picture = "pictures/".$app_review->endusers->picture;
            if($app_review->endusers->id == $request->user_id){
                array_push($user_active, $app_review);
            } else {
                array_push($all_user, $app_review);
            }
        }
        $apps->review = array_merge($user_active, $all_user);
        return $this->appResponse(100, 200, $apps);
    }

    public function PostAppReview(Request $request){
        $request->validate([
            'app_id' => 'required|integer',
            'comment' => 'required|string',
            'ratings' => 'required|integer',
        ]);
        $apps = Apps::where('id', $request->app_id)->where('is_active', 1)->where('is_approve', 1)->first();
        if(empty($apps)){
            return $this->appResponse(104, 200, "App ID Not Found!");
        }
        $user_review = Ratings::where('apps_id', $apps->id)->where('end_users_id', $request->user_id)->first();
        if(isset($user_review)){
            return $this->appResponse(505, 200);
        }
        $apps_review = new Ratings([
            'apps_id' => $request->app_id,
            'end_users_id' => $request->user_id,
            'ratings' => $request->ratings,
            'comment' => $request->comment,
            'users_dev_id' => $apps->developer_id,
        ]);
        $apps_review->save();
        return $this->appResponse(500, 200);
    }

    public function PutAppReview(Request $request){
        $request->validate([
            'app_id' => 'required|integer',
            'comment' => 'required|string',
            'ratings' => 'required|integer',
        ]);
        $apps = Apps::where('id', $request->app_id)->where('is_active', 1)->where('is_approve', 1)->first();
        if(empty($apps)){
            return $this->appResponse(104, 200, "App ID Not Found!");
        }
        $user_review = Ratings::where('apps_id', $apps->id)->where('end_users_id', $request->user_id)->first();
        if(empty($user_review)){
            return $this->appResponse(104, 200, 'Please give your review first!');
        }
        Ratings::where('apps_id', $apps->id)->where('end_users_id', $request->user_id)->update([
            'ratings' => $request->ratings,
            'comment' => $request->comment,
        ]);
        return $this->appResponse(501, 200);
    }

    public function DeleteAppReview(Request $request){
        $request->validate([
            'app_id' => 'required|integer',
        ]);
        $apps = Apps::where('id', $request->app_id)->where('is_active', 1)->where('is_approve', 1)->first();
        if(empty($apps)){
            return $this->appResponse(104, 200, "App ID Not Found!");
        }
        $user_review = Ratings::where('apps_id', $apps->id)->where('end_users_id', $request->user_id)->first();
        if(empty($user_review)){
            return $this->appResponse(104, 200, 'Please give your review first!');
        }
        Ratings::where('apps_id', $apps->id)->where('end_users_id', $request->user_id)->delete();
        return $this->appResponse(502, 200);
    }

    protected function searchEngine($request){
        $apps = Apps::where('is_active', 1)->where('is_approve', 1);
        if (isset($request->category_id)){
            $apps = $apps->where('category_id', $request->category_id);
        }
        if (isset($request->type_apps)){
            $apps = $apps->where('type', $request->type_apps);
        }
        if (isset($request->search)){
            $apps = $apps->where('name', 'LIKE', "%{$request->search}%");
        }

        $return = $apps->get();
        return $return;
    }

    protected function getDevelopers($developer_id){
        $developer = User::select(['name', 'email', 'picture', 'dev_web'])->where('id', $developer_id)->first();
        $developer->picture = 'picture/'.$developer->picture;
        return $developer;
    }
}