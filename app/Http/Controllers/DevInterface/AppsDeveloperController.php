<?php

namespace App\Http\Controllers\DevInterface;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use App\User;
use App\Model\Table\Apps;
use App\Model\Table\MstCategories;
use App\Model\Table\Ratings;
use App\Model\View\AvgRatings;
use App\Model\Table\MstSdk;
use App\Model\Table\MstCountry;

class AppsDeveloperController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


    }

    public function AppsDevInit(Request $request)
    {
        $paginate = 15;
        if (isset($request->query()['search'])){
            $search = $request->query()['search'];
            $appsapprove = AvgRatings::with(['categories'])->where('name', 'like', "%" . $search. "%")->where('developer_id', Auth::user()->id)->where('is_approve', 1)->orderBy('name', 'asc')->simplePaginate($paginate);
            $apps = AvgRatings::with(['categories'])->where('name', 'like', "%" . $search. "%")->where('developer_id', Auth::user()->id)->orderBy('name', 'asc')->simplePaginate($paginate);
            $apps->appends(['search' => $search]);
            $appsapprove->appends(['search' => $search]);
        } else {
          $appsapprove = AvgRatings::with(['categories'])->where('is_approve', 1)->where('developer_id', Auth::user()->id)->orderBy('name', 'asc')->simplePaginate($paginate);
          $apps = AvgRatings::with(['categories'])->where('developer_id', Auth::user()->id)->orderBy('name', 'asc')->simplePaginate($paginate);
        }
        $no = 1;
        foreach($apps as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'appsapprove' => $appsapprove,
            'apps' => $apps,
        );
        return view('apps-developer/index')->with('data', $data);
    }
    public function getDownload($id)
    {
        $apps = Apps::where('id', $id)->first();
        //PDF file is stored under project/public/download/info.pdf
        $file= $this->MapPublicPath(). "apk/".$apps->apk_file;
        $name = $apps->name.".apk";
        $headers = array(
                  'Content-Type: application/apk',
                );
        return response()->download($file, $name, $headers);
    }
    public function AppsDevEdit($id)
    {
        $apps = AvgRatings::with(['categories'])->where('id', $id)->first();
        $category = MstCategories::all();
        $data = array(
            'apps' => $apps,
            'category' => $category
        );
        return view('apps-developer/edit')->with('data', $data);
    }
    public function AppsDevDetailInfo($id)
    {
        $apps = AvgRatings::with(['categories','ratings'])->where('id', $id)->first();
        $user = User::with(['countrys'])->where('id', $apps->developer_id)->first();
        $data = array(
            'user' => $user,
            'apps' => $apps
        );
        return view('apps-developer/detail')->with('data', $data);
    }

    public function AddApps()
    {
      $category = MstCategories::all();
      $dev = User::with(['countrys'])->where('id', Auth::user()->id)->get();
      $data = array(
          'category' => $category,
          'devid' => '',
          'dev' => $dev
      );
        return view('apps-developer/add-app')->with('data', $data);
    }
    public function CreateApps(Request $request)
    {
      $apps = Apps::where('id', $request->id)->first();
        if(empty($apps)){
          if($request->photo){
              $file_extention = $request->photo->getClientOriginalExtension();
              $file_name = 'app_icon_'.$request->id.'.'.$file_extention;
              $fileSize = $request->photo->getSize();
              $valid_extension = array("jpg","jpeg","png");
              $maxFileSize = 2097152;
              if(in_array(strtolower($file_extention),$valid_extension)){
                // Check file size
                if($fileSize <= $maxFileSize){
                  $file_path = $request->photo->move($this->MapPublicPath().'apps',$file_name);
                }else{
                  return redirect()->back()->with('err_message', 'File too large. File must be less than 2MB.');
                }
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
          }else{
            $file_name="Photo not exists";
          }
          // if($request->apk_file){
          //     $file_extention = $request->apk_file->getClientOriginalExtension();
          //     $apk_name = $request->name.'_'.$request->id.'.'.$file_extention;
          //     $file_path = $request->apk_file->move($this->MapPublicPath().'apk',$apk_name);
          //     // call function from Controller.php to get sdk package
          //     $cek_sdk = $this->CheckApkPackage($apk_name);
          //
          // }else{
          //   $apk_name="APK File not exists";
          //   $cek_sdk = $this->CheckApkPackage($apk_name);
          // }
          // if($request->exp_file){
          //     $file_extention = $request->exp_file->getClientOriginalExtension();
          //     $expfile_name = 'exp_file_'.$request->id.'.'.$file_extention;
          //     $file_path = $request->exp_file->move($this->MapPublicPath().'exp_file',$expfile_name);
          // }else{
          //   $expfile_name="Exp File not exists";
          // }
          $created =  Apps::create([
                  'name' => $request->name,
                  'type' => $request->type,
                  'app_icon' => $file_name,
                  // 'eu_sdk_version' => $cek_sdk['min_sdk_level'],
                  // 'package_name' => $cek_sdk['package_name'],
                  'category_id' => $request->category,
                  'rate' => $request->rate,
                  // 'version' => $cek_sdk['version_name'],
                  // 'file_size' => '',
                  // 'apk_file' => $apk_name,
                  // 'expansion_file' => $expfile_name,
                  'description' => $request->description,
                  'updates_description' => $request->updates_description,
                  'developer_id'=>$request->developer,
                  'is_active'=>1,
                  'is_approve'=>0,
                  // 'is_partnership'=>1,
                  'created_at' => date('Y-m-d H:i:s'),
                  'created_by' => Auth::user()->email
                  ]
                );
            // $apps = Apps::where('id', $request->id)->first();
            // if(!empty($apps)){
              return redirect('upload-media-dev/'.$created->id)->with('suc_message', 'Apps telah ditambahkan!');
            // }
        } else {
          return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');
        }
    }
    public function UploadMedia($id)
    {
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $data = array(
            'apps' => $apps,
        );
        return view('apps-developer/upload-media')->with('data', $data);
    }
    public function EditMedia($id)
    {
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $data = array(
            'apps' => $apps,
        );
        return view('apps-developer/edited-media')->with('data', $data);
    }
    public function UploadApp($id)
    {
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $data = array(
            'apps' => $apps,
        );
        return view('apps-developer/upload-app')->with('data', $data);
    }
    public function EditApp($id)
    {
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $data = array(
            'apps' => $apps,
        );
        return view('apps-developer/edited-app')->with('data', $data);
    }
    public function UploadExpansion($id)
    {
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $data = array(
            'apps' => $apps,
        );
        return view('apps-developer/upload-expansion')->with('data', $data);
    }
    public function EditExpansion($id)
    {
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $data = array(
            'apps' => $apps,
        );
        return view('apps-developer/edited-expansion')->with('data', $data);
    }
    public function CreateMedia(Request $request)
    {
      $apps = Apps::where('id', $request->id)->first();
      if(!empty($apps)){
        // $SumSize = array_sum(array($request->file('filename')));
        $SumSize=0;
        $maxFileSize = 10097152;
        foreach ($request->file('filename') as $img) {
          $SumSize = $SumSize+$img->getSize();
        }
        echo $SumSize;
        $no=0;
        if($SumSize <= $maxFileSize){
            foreach ($request->file('filename') as $image) {
              $no++;
              $file_extention = $image->getClientOriginalExtension();
              $name='media_'.$request->id.'_'.$no.'.'.$file_extention;
              $valid_extension = array("jpg","jpeg","png","mp4","mkv");
              if(in_array(strtolower($file_extention),$valid_extension)){
                  $image->move($this->MapPublicPath().'media',$name);
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
              $data["media".$no] = $name;
            }
        }else{
          return redirect()->back()->with('err_message', 'File too large. File must be less than 10MB.');
        }
        $updated = Apps::where('id', $request->id)->update([
              'media' => json_encode($data),
              'updated_at' => date('Y-m-d H:i:s'),
              'updated_by' => Auth::user()->email
              ]
            );
            return redirect('upload-app-dev/'.$apps->id)->with('suc_message', 'Apps Media telah diperbarui!');
      }else{
        return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');

      }
      // echo json_encode($data);
      // echo $SumSize;
    }
    public function UpdateMedia(Request $request)
    {
      $apps = Apps::where('id', $request->id)->first();
      if(!empty($apps)){
        // $SumSize = array_sum(array($request->file('filename')));
        $SumSize=0;
        $maxFileSize = 10097152;
        foreach ($request->file('filename') as $img) {
          $SumSize = $SumSize+$img->getSize();
        }
        echo $SumSize;
        $no=0;
        if($SumSize <= $maxFileSize){
            foreach ($request->file('filename') as $image) {
              $no++;
              $file_extention = $image->getClientOriginalExtension();
              $name='media_'.$request->id.'_'.$no.'.'.$file_extention;
              $valid_extension = array("jpg","jpeg","png","mp4","mkv");
              if(in_array(strtolower($file_extention),$valid_extension)){
                  $image->move($this->MapPublicPath().'media',$name);
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
              $data["media".$no] = $name;
            }
        }else{
          return redirect()->back()->with('err_message', 'File too large. File must be less than 10MB.'.$SumSize);
        }
        Apps::where('id', $request->id)->update([
              'media' => json_encode($data),
              'updated_at' => date('Y-m-d H:i:s'),
              'updated_by' => Auth::user()->email
              ]
            );
            return redirect('apps-developer')->with('suc_message', 'Apps Media telah diperbarui!');
      }else{
        return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');

      }
      // echo json_encode($data);
      // echo $SumSize;
    }
    public function CreatedApp(Request $request) // not used right now
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){

          if($request->apk_file){
              $file_extention = $request->apk_file->getClientOriginalExtension();
              $apk_name = 'apps_'.$request->id.'.'.$file_extention;
              $fileSize = $request->apk_file->getSize();
              $valid_extension = array("apk");
              $maxFileSize = 100097152;
              if(in_array(strtolower($file_extention),$valid_extension)){
                // Check file size
                if($fileSize <= $maxFileSize){
                  $file_path = $request->apk_file->move($this->MapPublicPath().'apk',$apk_name);
                  $cek_sdk = $this->CheckApkPackage($apk_name);
                  if ($cek_sdk['version_name'] <= $apps->version) {
                     return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan, Mohon Update Version Apps Lebih Tinggi!');
                  }
                }else{
                  return redirect()->back()->with('err_message', 'File too large. File must be less than 100MB.');
                }
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
              // call function from Controller.php to get sdk package

          }else{
            $apk_name="APK File not exists";
            $cek_sdk = $this->CheckApkPackage($apps->apk_file);
          }

            Apps::where('id', $request->id)->update([
                  'eu_sdk_version' => $cek_sdk['min_sdk_level'],
                  'package_name' => $cek_sdk['package_name'],
                  'file_size' => $fileSize,
                  'apk_file' => $apk_name,
                  'version' => $cek_sdk['version_name'],
                  'updated_at' => date('Y-m-d H:i:s'),
                  'updated_by' => Auth::user()->email
                  ]
                );

            return redirect('upload-expansion-dev/'.$apps->id)->with('suc_message', 'Apps telah diperbarui!');
        } else {
          return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');
        }
    }
    public function UpdateApp(Request $request) // not used right now
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){

          if($request->apk_file){
              $file_extention = $request->apk_file->getClientOriginalExtension();
              $apk_name = 'apps_'.$request->id.'.'.$file_extention;
              $fileSize = $request->apk_file->getSize();
              $valid_extension = array("apk");
              $maxFileSize = 100097152;
              if(in_array(strtolower($file_extention),$valid_extension)){
                // Check file size
                if($fileSize <= $maxFileSize){
                  $file_path = $request->apk_file->move($this->MapPublicPath().'apk',$apk_name);
                  $cek_sdk = $this->CheckApkPackage($apk_name);
                  if ($cek_sdk['version_name'] <= $apps->version) {
                     return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan, Mohon Update Version Apps Lebih Tinggi!');
                  }
                }else{
                  return redirect()->back()->with('err_message', 'File too large. File must be less than 100MB.');
                }
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
              // call function from Controller.php to get sdk package

          }else{
            $apk_name="APK File not exists";
            $cek_sdk = $this->CheckApkPackage($apps->apk_file);
          }

            Apps::where('id', $request->id)->update([
                  'eu_sdk_version' => $cek_sdk['min_sdk_level'],
                  'package_name' => $cek_sdk['package_name'],
                  'file_size' => $fileSize,
                  'apk_file' => $apk_name,
                  'version' => $cek_sdk['version_name'],
                  'updated_at' => date('Y-m-d H:i:s'),
                  'updated_by' => Auth::user()->email
                  ]
                );

            return redirect('apps-developer')->with('suc_message', 'Apps telah diperbarui!');
        } else {
          return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');
        }
    }
    public function UpdateExpansion(Request $request) // not used right now
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){

          if($request->exp_file){
              $file_extention = $request->exp_file->getClientOriginalExtension();
              $expfile_name = 'exp_file_apps'.$request->id.'.'.$file_extention;
              $fileSize = $request->exp_file->getSize();
              $valid_extension = array("obb");
              $maxFileSize = 100097152;
              if(in_array(strtolower($file_extention),$valid_extension)){
                // Check file size
                if($fileSize <= $maxFileSize){
                  $file_path = $request->exp_file->move($this->MapPublicPath().'exp_file',$expfile_name);

                }else{
                  return redirect()->back()->with('err_message', 'File too large. File must be less than 100MB.');
                }
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
              // call function from Controller.php to get sdk package

          }else{
            $expfile_name="APK File not exists";
          }

            Apps::where('id', $request->id)->update([
                  'expansion_file' => $expfile_name,
                  'updated_at' => date('Y-m-d H:i:s'),
                  'updated_by' => Auth::user()->email
                  ]
                );

            return redirect('apps-developer')->with('suc_message', 'Apps telah diperbarui!');
        } else {
          return redirect()->back()->with('err_message', 'Apps Gagal ditambahkan!');
        }
    }
    public function AppsDevUpdate(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
          if($request->photo){
              $file_extention = $request->photo->getClientOriginalExtension();
              $file_name = 'app_icon_'.$request->id.'.'.$file_extention;
              $fileSize = $request->photo->getSize();
              $valid_extension = array("jpg","jpeg","png");
              $maxFileSize = 2097152;
              if(in_array(strtolower($file_extention),$valid_extension)){
                // Check file size
                if($fileSize <= $maxFileSize){
                  $file_path = $request->photo->move($this->MapPublicPath().'apps',$file_name);
                }else{
                  return redirect()->back()->with('err_message', 'File too large. File must be less than 2MB.');
                }
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
          }else{
            $file_name=$apps->app_icon;
          }
            Apps::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'type' => $request->type,
                  'app_icon' => $file_name,
                  'category_id' => $request->category,
                  'rate' => $request->rate,
                  'file_size' => $request->file_size,
                  'description' => $request->description,
                  'updates_description' => $request->updates_description,
                  'link' => $request->link,
                  'updated_at' => date('Y-m-d H:i:s'),
                  'updated_by' => Auth::user()->email
                  ]
                );

            return redirect('apps-developer')->with('suc_message', 'Apps telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
    public function AppsDevBlock(Request $request)
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
    public function AppsDevUnBlock(Request $request)
    {
        $apps = Apps::where('id', $request->id)->first();
        if(!empty($apps)){
            Apps::where('id', $request->id)
              ->update([
                    'is_active' => 1,
                  ]
                );

            return redirect()->back()->with('suc_message', 'Apps telah diunblock!');
        } else {
            return redirect()->back()->with('err_message', 'Apps tidak ditemukan!');
        }
    }
    public function AppsDevDelete(Request $request)
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
