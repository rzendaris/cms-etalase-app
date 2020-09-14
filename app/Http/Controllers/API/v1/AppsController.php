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
                array_push($data, $app);
            }
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
                    array_push($temp_array, $apps);
                }
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

    public function AppDetail($id)
    {
        $apps = Apps::where('id', $id)->first();
        if(isset($apps)){
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

    public function GetAppsCategory()
    {
        $select_apps_category = Apps::select(['category_id'])->where('is_active', 1)->where('is_approve', 1)->groupBy('category_id')->get();
        $apps_category = MstCategories::whereIn('id', $select_apps_category)->get();
        return $this->appResponse(100, 200, $apps_category);
    }

    public function GetAppReview($apps_id){
        $apps = AvgRatings::where('id', $apps_id)->where('is_active', 1)->where('is_approve', 1)->first();
        if(empty($apps)){
            return $this->appResponse(104, 200, "App ID Not Found!");
        }
        if($apps->avg_ratings == NULL){
            $apps->avg_ratings = 0;
        }
        $apps->review = Ratings::with(['endusers'=>function($query){
            $query->select('id','name','email','picture');
        }])->where('apps_id', $apps->id)->get();
        foreach($apps->review as $app_review){
            $app_review->endusers->picture = "pictures/".$app_review->endusers->picture;
        }
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
        if (isset($request->search)){
            $apps = $apps->where('name', 'LIKE', "%{$request->search}%");
        }

        $return = $apps->get();
        return $return;
    }
}