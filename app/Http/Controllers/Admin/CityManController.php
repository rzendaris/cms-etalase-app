<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\User;
use App\Model\Tables\City;
use App\Model\Tables\Province;

class CityManController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Master Data Kota/Kab Ditolak!');
            }
            return $next($request);
        });
        
    }
    
    public function CityInit()
    {
        $city = City::with(['province'])->where('status', 1)->get()->sortBy('province.name');
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $no = 1;
        foreach($city as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'city' => $city,
            'list_province' => $province
        );
        return view('m-master-data/m-city-mgmt/m-city-mgmt')->with('data', $data);
    }

    public function CityInsert(Request $request)
    {
        $city = City::where('name', $request->name)->first();
        if(empty($city)){
            $province = Province::where('id', $request->province_id)->where('status', 1)->get();
            if(!empty($province)){
                City::create([
                    'name' => $request->name,
                    'province_id' => $request->province_id,
                    'created_by' => Auth::user()->email,
                    'status' => 1,
                ]);
                return redirect('master/city')->with('suc_message', 'Data baru berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('err_message', 'Provinsi tidak terdaftar! Tambahkan Provinsi terlebih dahulu');
            }
        } else {
            return redirect()->back()->with('err_message', 'Kota telah terdaftar!');
        }
    }

    public function CityUpdate(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        if(!empty($city)){
            City::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'updated_by' => Auth::user()->email,
                  ]
                );
            return redirect('master/city')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function CityDelete(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        if(!empty($city)){
            City::where('id', $request->id)->update(['status' => 0]);
            return redirect('master/city')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}