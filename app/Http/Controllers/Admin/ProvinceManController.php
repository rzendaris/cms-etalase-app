<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\User;
use App\Model\Tables\Province;

class ProvinceManController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Master Data Provinsi Ditolak!');
            }
            return $next($request);
        });
        
    }
    
    public function ProvinceInit()
    {
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $no = 1;
        foreach($province as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'province' => $province
        );
        return view('m-master-data/m-province-mgmt/m-province-mgmt')->with('data', $data);
    }

    public function ProvinceInsert(Request $request)
    {
        $province = Province::where('name', $request->name)->first();
        if(empty($province)){
            Province::create([
                'name' => $request->name,
                'created_by' => Auth::user()->email,
                'status' => 1,
            ]);
            return redirect('master/province')->with('suc_message', 'Data baru berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('err_message', 'Provinsi telah terdaftar!');
        }
    }

    public function ProvinceUpdate(Request $request)
    {
        $province = Province::where('id', $request->id)->first();
        if(!empty($province)){
            Province::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'updated_by' => Auth::user()->email,
                  ]
                );
            return redirect('master/province')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function ProvinceDelete(Request $request)
    {
        $province = Province::where('id', $request->id)->first();
        if(!empty($province)){
            Province::where('id', $request->id)->update(['status' => 0]);
            return redirect('master/province')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}