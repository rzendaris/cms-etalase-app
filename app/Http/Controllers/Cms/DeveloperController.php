<?php

namespace App\Http\Controllers\Cms;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Model\Table\MstCountry;
use App\Model\Table\Apps;

class DeveloperController extends Controller
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

    public function DeveloperInit()
    {
        $user = User::with(['countrys'])->where('role_id', 2)->get();
        $country = MstCountry::get();
        $no = 1;
        foreach($user as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'user' => $user,
        );
        return view('developer-management/index')->with('data', $data);
    }
    public function DeveloperAdd()
    {
        $country = MstCountry::all();
        $data = [
            'country' => $country
        ];
        return view('developer-management/add')->with($data);
    }
    public function DeveloperChangeInfo($id)
    {
        $user = User::where('id', $id)->first();
        $country = MstCountry::get();
        $data = array(
            'user' => $user,
            'country' => $country
        );
        return view('developer-management/edit')->with('data', $data);
    }
    public function DeveloperDetailInfo($id)
    {
        $user = User::where('id', $id)->first();
        $apps = Apps::with(['categories'])->where('developer_id', $id)->get();
        $no = 1;
        foreach($apps as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'user' => $user,
            'apps' => $apps
        );
        return view('developer-management/detail')->with('data', $data);
    }
    public function DeveloperInsert(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($request->password != $request->re_password) {
          return redirect()->back()->with('err_message', 'Re-Type Password Not Match!');
        }else{
          if(empty($user)){
            if($request->photo){
                $file_extention = $request->photo->getClientOriginalExtension();
                $file_name = $request->email.'image_profile.'.$file_extention;
                $fileSize = $request->photo->getSize();
                $valid_extension = array("jpg","jpeg","png");
                $maxFileSize = 2097152;
                if(in_array(strtolower($file_extention),$valid_extension)){
                  // Check file size
                  if($fileSize <= $maxFileSize){
                    $file_path = $request->photo->move(public_path().'/pictures',$file_name);
                  }else{
                    return redirect()->back()->with('err_message', 'File too large. File must be less than 2MB.');
                  }
                }else{
                  return redirect()->back()->with('err_message', 'Invalid File Extension.');
                }
            }else{
              $file_name=$user->picture;
            }
              User::create([
                    'name' => $request->full_name,
                    'dev_web' => $request->website,
                    'dev_address' => $request->dev_address,
                    'dev_country_id' => $request->country,
                    'picture' => $file_name,
                    'email' => $request->email,
                    'role_id' => 2,
                    'is_blocked' => 1,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'password' => Hash::make($request->password)
                    ]
                  );
              if(!empty($request->password)){
                  User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
              }
              return redirect('developer-management')->with('suc_message', 'Data telah diperbarui!');
          } else {
            return redirect()->back()->with('err_message', 'Email telah digunakan! Gunakan alamat email yang belum terdaftar!');
          }
        }
    }
    public function DeveloperUpdate(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $email = User::where('email', $request->email)->first();
        if ($user->email == $request->email or empty($email)) {
          // echo "email sama dan ";  // save data
          if($request->photo){
              $file_extention = $request->photo->getClientOriginalExtension();
              $file_name = $request->email.'image_profile.'.$file_extention;
              $fileSize = $request->photo->getSize();
              $valid_extension = array("jpg","jpeg","png");
              $maxFileSize = 2097152;
              if(in_array(strtolower($file_extention),$valid_extension)){
                // Check file size
                if($fileSize <= $maxFileSize){
                  $file_path = $request->photo->move(public_path().'/pictures',$file_name);
                }else{
                  return redirect()->back()->with('err_message', 'File too large. File must be less than 2MB.');
                }
              }else{
                return redirect()->back()->with('err_message', 'Invalid File Extension.');
              }
          }else{
            $file_name=$user->picture;
          }
            User::where('id', $request->id)
              ->update([
                  'name' => $request->full_name,
                  'dev_web' => $request->website,
                  'dev_address' => $request->dev_address,
                  'dev_country_id' => $request->country,
                  'picture' => $file_name,
                  'email' => $request->email
                  ]
                );
            if(!empty($request->password)){
                User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
            }
            return redirect('developer-management')->with('suc_message', 'Data telah diperbarui!');
        }else if(!empty($email)){
          return redirect()->back()->with('err_message', 'Email telah digunakan! Gunakan alamat email yang belum terdaftar!');
        }else{
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}
