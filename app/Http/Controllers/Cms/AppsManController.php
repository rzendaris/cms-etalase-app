<?php

namespace App\Http\Controllers\Cms;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Model\Table\Apps;
use App\Model\Table\MstCategories;
use App\Model\Table\Ratings;
use App\Model\View\AvgRatings;
use App\Model\Table\MstSdk;
use App\Model\Table\MstCountry;

class AppsManController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id != 1){
                return redirect('/')->with('access_message', 'Akses untuk Menu User Management Ditolak!');
            }
            return $next($request);
        });

    }

    public function AppsManInit()
    {
        $appsapprove = AvgRatings::with(['categories'])->where('is_approve', 1)->get();
        $apps = AvgRatings::with(['categories'])->get();
        $no = 1;
        foreach($apps as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'appsapprove' => $appsapprove,
            'apps' => $apps,
        );
        return view('apps-management/index')->with('data', $data);
    }
    public function AppsManAdd()
    {
        $country = MstCountry::all();
        $data = [
            'country' => $country
        ];
        return view('apps-management/add')->with($data);
    }
    public function AppsManEdit($id)
    {
        $apps = AvgRatings::with(['categories','skds'])->where('id', $id)->first();
        $category = MstCategories::all();
        $sdk = MstSdk::all();
        $data = array(
            'apps' => $apps,
            'category' => $category,
            'sdk' => $sdk
        );
        return view('apps-management/edit')->with('data', $data);
    }
    public function ApprovalApps($id)
    {
        $apps = AvgRatings::with(['categories','skds'])->where('id', $id)->first();
        $category = MstCategories::all();
        $sdk = MstSdk::all();
        $data = array(
            'apps' => $apps,
            'category' => $category,
            'sdk' => $sdk
        );
        return view('apps-management/approval')->with('data', $data);
    }
    public function AppsManDetailInfo($id)
    {
        $apps = AvgRatings::with(['categories','ratings','skds'])->where('id', $id)->first();
        $user = User::with(['countrys'])->where('id', $apps->developer_id)->first();
        $sdk = MstSdk::all();
        $data = array(
            'user' => $user,
            'apps' => $apps,
            'sdk' => $sdk
        );
        return view('apps-management/detail')->with('data', $data);
    }
    public function PartnershipIndex()
    {
        $apps = Apps::with(['categories','ratings'])->where('is_partnership', 1)->get();
        $no = 1;
        foreach($apps as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'apps' => $apps,
        );
        return view('apps-management/index-partnership')->with('data', $data);
    }
    public function AddAppsPartnership()
    {
      $category = MstCategories::all();
      $sdk = MstSdk::all();
      $dev = User::with(['countrys'])->where('role_id', 2)->get();
      $data = array(
          'category' => $category,
          'sdk' => $sdk,
          'dev' => $dev
      );
        return view('apps-management/add-apps-partnership')->with('data', $data);
    }
    public function CreateAppsPartnership(Request $request)
    {
      $apps = Apps::where('id', $request->id)->first();
        if(empty($apps)){
          if($request->photo){
              $file_extention = $request->photo->getClientOriginalExtension();
              $file_name = 'app_icon_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->photo->move(public_path().'/apps',$file_name);
          }else{
            $file_name="Photo not exists";
          }
          if($request->apk_file){
              $file_extention = $request->apk_file->getClientOriginalExtension();
              $apk_name = 'apk_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->apk_file->move(public_path().'/apk',$apk_name);
          }else{
            $apk_name="APK File not exists";
          }
          if($request->exp_file){
              $file_extention = $request->exp_file->getClientOriginalExtension();
              $expfile_name = 'exp_file_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->exp_file->move(public_path().'/exp_file',$expfile_name);
          }else{
            $expfile_name="Exp File not exists";
          }
            Apps::create([
                  'name' => $request->name,
                  'type' => $request->type,
                  'app_icon' => $file_name,
                  'sdk_target_id' => $request->sdk,
                  'category_id' => $request->category,
                  'rate' => $request->rate,
                  'version' => $request->version,
                  'file_size' => '',
                  'apk_file' => $apk_name,
                  'expansion_file' => $expfile_name,
                  'description' => $request->description,
                  'updates_description' => $request->updates_description,
                  'developer_id'=>$request->developer,
                  'is_active'=>1,
                  'is_approve'=>0,
                  'is_partnership'=>1,
                  'created_at' => date('Y-m-d H:i:s'),
                  'created_by' => Auth::user()->email
                  ]
                );

            return redirect('apps-management')->with('suc_message', 'Apps telah ditambahkan!');
        } else {
          return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');
        }
    }
    public function EditAppsPartnership($id)
    {
      $apps = Apps::with(['categories','ratings','skds'])->where('id', $id)->first();
      $category = MstCategories::all();
      $sdk = MstSdk::all();
      $dev = User::with(['countrys'])->where('role_id', 2)->get();
      $data = array(
          'apps' => $apps,
          'category' => $category,
          'sdk' => $sdk,
          'dev' => $dev
      );
        return view('apps-management/edit-apps-partnership')->with('data', $data);
    }
    public function UpdateAppsPartnership(Request $request)
    {
      $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
          if($request->photo){
              $file_extention = $request->photo->getClientOriginalExtension();
              $file_name = 'app_icon_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->photo->move(public_path().'/apps',$file_name);
          }else{
            $file_name=$apps->app_icon;
          }
          if($request->apk_file){
              $file_extention = $request->apk_file->getClientOriginalExtension();
              $apk_name = 'apk_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->apk_file->move(public_path().'/apk',$apk_name);
          }else{
            $apk_name=$apps->app_icon;
          }
          if($request->exp_file){
              $file_extention = $request->exp_file->getClientOriginalExtension();
              $expfile_name = 'exp_file_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->exp_file->move(public_path().'/exp_file',$expfile_name);
          }else{
            $expfile_name=$apps->app_icon;
          }
            Apps::where('id', $request->id)->update([
                  'name' => $request->name,
                  'type' => $request->type,
                  'app_icon' => $file_name,
                  'sdk_target_id' => $request->sdk,
                  'category_id' => $request->category,
                  'rate' => $request->rate,
                  'version' => $request->version,
                  'file_size' => '',
                  'apk_file' => $apk_name,
                  'expansion_file' => $expfile_name,
                  'description' => $request->description,
                  'updates_description' => $request->updates_description,
                  'developer_id'=>$request->developer,
                  'updated_at' => date('Y-m-d H:i:s'),
                  'updated_by' => Auth::user()->email
                  ]
                );

            return redirect('apps-management')->with('suc_message', 'Apps telah ditambahkan!');
        } else {
          return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');
        }
    }
    public function AppsManInsert(Request $request)
    {
      $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
          if($request->photo){
              $file_extention = $request->photo->getClientOriginalExtension();
              $file_name = 'app_icon_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->photo->move(public_path().'/apps',$file_name);
          }else{
            $file_name=$apps->app_icon;
          }
          if($request->apk_file){
              $file_extention = $request->apk_file->getClientOriginalExtension();
              $apk_name = 'apk_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->photo->move(public_path().'/apk',$apk_name);
          }else{
            $apk_name=$apps->app_icon;
          }
          if($request->exp_file){
              $file_extention = $request->exp_file->getClientOriginalExtension();
              $expfile_name = 'exp_file_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->photo->move(public_path().'/exp_file',$expfile_name);
          }else{
            $expfile_name=$apps->app_icon;
          }
            Apps::create([
                'name' => $request->name,
                'type' => $request->type,
                'app_icon' => $file_name,
                'sdk_target_id' => $request->sdk,
                'category_id' => $request->category,
                'rate' => $request->rate,
                'version' => $request->version,
                  'file_size' => '',
                  'apk_file' => $apk_name,
                  'expansion_file' => $expfile_name,
                  'description' => $request->description,
                  'updates_description' => $request->updates_description,
                  'developer_id'=>33,
                  'is_partnership'=>1,
                  'created_at' => date('Y-m-d H:i:s'),
                  'created_by' => Auth::user()->email
                  ]
                );

            return redirect('apps-management')->with('suc_message', 'Apps telah diperbarui!');
        } else {
          return redirect()->back()->with('err_message', 'Email telah digunakan! Gunakan alamat email yang belum terdaftar!');
        }
    }
    public function AppsManUpdate(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
          if($request->photo){
              $file_extention = $request->photo->getClientOriginalExtension();
              $file_name = 'app_icon_'.$request->name.'_'.$request->id.'.'.$file_extention;
              $file_path = $request->photo->move(public_path().'/apps',$file_name);
          }else{
            $file_name=$apps->app_icon;
          }
            Apps::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'type' => $request->type,
                  'app_icon' => $file_name,
                  'sdk_target_id' => $request->sdk,
                  'category_id' => $request->category,
                  'rate' => $request->rate,
                  'version' => $request->version,
                  'file_size' => $request->file_size,
                  'description' => $request->description,
                  'updates_description' => $request->updates_description,
                  'link' => $request->link,
                  'updated_at' => date('Y-m-d H:i:s'),
                  'updated_by' => Auth::user()->email
                  ]
                );

            return redirect('apps-management')->with('suc_message', 'Apps telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
    public function AppsManBlock(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
            Apps::where('id', $request->id)
              ->update([
                    'is_active' => 0,
                  ]
                );

            return redirect()->back()->with('suc_message', 'Apps telah diblock!');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
    public function AppsManUnBlock(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
            Apps::where('id', $request->id)
              ->update([
                    'is_active' => 1,
                  ]
                );

            return redirect()->back()->with('suc_message', 'Apps telah diblock!');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
    public function Approved(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
            Apps::where('id', $request->id)
              ->update([
                    'is_approve' => 1,
                  ]
                );

            return redirect('apps-management')->with('suc_message', 'Apps Approved !');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
    public function Rejected(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
            Apps::where('id', $request->id)
              ->update([
                    'is_approve' => 2,
                    'description' => $request->reaseon
                  ]
                );

            return redirect('apps-management')->with('suc_message', 'Apps Rejected!');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
    public function AppsManDelete(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
            Apps::where('id', $request->id)->delete();
            return redirect()->back()->with('suc_message', 'Apps telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
}
