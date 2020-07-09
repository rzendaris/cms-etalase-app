<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Model\Tables\Role;

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
            if (Auth::user()->role_id != 1){
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu User Management Ditolak!');
            }
            return $next($request);
        });
        
    }

    public function UserMgmtInit()
    {
        $user = User::with(['role'])->where('status', 1)->get();
        $role = Role::get();
        $no = 1;
        foreach($user as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'user' => $user,
            'role' => $role
        );
        return view('m-user-mgmt/list-user-mgmt')->with('data', $data);
    }

    public function UserMgmtInsert(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(empty($user)){
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
                'status' => 1,
            ]);
            return redirect('user-management-fe')->with('suc_message', 'Data baru berhasil ditambahkan!');
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
                  'role_id' => $request->role_id
                  ]
                );
            if(!empty($request->password)){
                User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
            }
            return redirect('user-management-fe')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function UserMgmtDelete(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if(!empty($user)){
            User::where('id', $request->id)->delete();
            return redirect('user-management-fe')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}