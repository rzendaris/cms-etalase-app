<?php

namespace App\Http\Controllers\Cms;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Model\Table\MstCountry;

class UserManController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id == 0){
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu User Management Ditolak!');
            }
            return $next($request);
        });

    }

    public function UserMgmtInit()
    {
        $user = User::with(['countrys'])->get();
        $country = MstCountry::get();
        $no = 1;
        foreach($user as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'user' => $user,
            'country' => $country
        );
        return view('v-user-mgmt/list-user-mgmt')->with('data', $data);
    }

    public function UserMgmtInsert(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(empty($user)){
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => 1,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make($request->password),
                // 'token' => Str::random(60),
            ]);
            return redirect('user-management-cms')->with('suc_message', 'Data baru berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('err_message', 'Email telah digunakan! Gunakan alamat email yang belum terdaftar!');
        }
    }

    public function UserMgmtUpdate(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if(!empty($user)){
            User::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'email' => $request->email
                  ]
                );
            if(!empty($request->password)){
                User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
            }
            return redirect('user-management-cms')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
    public function UserMgmtProfile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('v-user-mgmt/profile')->with('data', $user);
    }
    public function UserMgmtResetPass(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if(!empty($user)){
            User::where('id', $request->id)
              ->update([
                    'password' => Hash::make($request->password),
                  ]
                );
            if(!empty($request->password)){
                User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
            }
            return redirect('user-management-cms')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
    public function UserMgmtDelete(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if(!empty($user)){
            User::where('id', $request->id)->delete();
            return redirect('user-management-cms')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
    public function RegisterUser(Request $request)
    {
      $files = $request->file('picture');
        // $fileName =  $data['email'].".".$files->getClientOriginalExtension();
      // $request->validate([
      //     'picture' => 'required|mimes:jpg,jpeg,png|max:2048',
      // ]);
       // $request->file('picture')->move(public_path('pictures'), $fileName);
       echo $request->picture;
       echo $request->name.$files;
       $files = $request->file('picture');
       $request->validate([
           'picture' => 'required|mimes:pdf,xlx,csv,zip|max:2048',
       ]);
       $fileName = $files->getClientOriginalName();  // '.'.$request->foto->extension();

       $request->foto->move(public_path('uploads'), $fileName);
         echo "selesai";
      // $fileName = $files->getClientOriginalName();
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'dev_web' => $data['dev_web'],
        //     'dev_country_id' => $data['dev_country_id'],
        //     'dev_address' => $data['dev_address'],
        //     'role' => 2,
        //     'picture' => $data['picture'].$files,
        //     'password' => Hash::make($data['password']),
        // ]);

    }
}
