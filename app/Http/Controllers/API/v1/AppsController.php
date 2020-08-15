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

class AppsController extends Controller
{
    public function GetAllApps(Request $request)
    {
        if (isset($request)){
            $apps = $this->searchEngine($request);
        } else {
            $apps = Apps::where('is_active', 1)->get();
        }

        foreach($apps as $key => $data){
            if(is_file($this->MapPublicPath().'apk/'.$data->apk_file)){
                $apk_manifest = $this->CheckApkPackage($data->apk_file);
                if((int)$request->sdk_version < $apk_manifest['min_sdk_level']){
                    unset($apps[$key]);
                }
                $apps_status = 'DOWNLOAD';
                $installed_apps = DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $data->id)->first();
                if(isset($installed_apps)){
                    if($apk_manifest['version_code'] != (int)$data->version){
                        $apps_status = "UPDATE";
                    } else {
                        $apps_status = "INSTALLED";
                    }
                }
                $data->apps_status = $apps_status;
            } else {
                unset($apps[$key]);
            }

        }
        return $this->appResponse(100, 200, $apps);
    }

    public function AppDetail($id)
    {
        $apps = Apps::where('id', $id)->first();
        if(isset($apps)){
            return $this->appResponse(100, 200, $apps);
        } else {
            return $this->appResponse(104, 200);
        }
    }

    public function AppsAction(Request $request, $action, $apps_id)
    {
        $data = "Action > ".$action." --- "."Apps Id > ".$apps_id;
        $apps = Apps::where('id', $apps_id)->first();
        if(isset($apps)){
            $installed_apps = DownloadApps::where('end_users_id', $request->user_id)->where('apps_id', $apps->id)->first();
            if($action == "DOWNLOAD"){

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
                    return $this->appResponse(200, 200, $return);
                } else {
                    return $this->appResponse(505, 200);
                }

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

    public function GetAppsCategory()
    {
        $select_apps_category = Apps::select(['category_id'])->where('is_active', 1)->groupBy('category_id')->get();
        $apps_category = MstCategories::whereIn('id', $select_apps_category)->get();
        return $this->appResponse(100, 200, $apps_category);
    }

    protected function searchEngine($request){
        $apps = Apps::where('is_active', 1);
        if (isset($request->category_id)){
            $apps = $apps->where('category_id', $request->category_id);
        }

        $return = $apps->get();
        return $return;
    }
}