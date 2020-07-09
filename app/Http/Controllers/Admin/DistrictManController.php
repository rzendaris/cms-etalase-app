<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Response;

use App\User;
use App\Model\Tables\District;
use App\Model\Tables\City;
use App\Model\Tables\Province;

class DistrictManController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Master Data Kecamatan Ditolak!');
            }
            return $next($request);
        });
        
    }
    
    public function DistrictInit(Request $request)
    {
        $paginate = 15;
        if (isset($request->query()['search'])){
            $search = $request->query()['search'];
            $district = District::where('name', 'like', "%" . $search. "%")->where('status', 1)->with(
                ['city', 'city.province']
            )->simplePaginate($paginate);
            $district->appends(['search' => $search]);
        } else {
            $district = District::with(['city', 'city.province'])->where('status', 1)->simplePaginate($paginate);
        }
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $no = 1 + (($district->currentPage() - 1) * $paginate);

        foreach($district as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'district' => $district,
            'list_province' => $province
        );
        return view('m-master-data/m-district-mgmt/m-district-mgmt')->with('data', $data);
    }

    public function DistrictInsert(Request $request)
    {
        $district = District::where('name', $request->name)->first();
        if(empty($district)){
            $city = City::where('id', $request->city_id)->where('status', 1)->get();
            if(!empty($city)){
                District::create([
                    'name' => $request->name,
                    'city_id' => $request->city_id,
                    'created_by' => Auth::user()->email,
                    'status' => 1,
                ]);
                return redirect('master/district')->with('suc_message', 'Data baru berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('err_message', 'Kota tidak terdaftar! Tambahkan Kota terlebih dahulu');
            }
        } else {
            return redirect()->back()->with('err_message', 'Kota telah terdaftar!');
        }
    }

    public function DistrictUpdate(Request $request)
    {
        $district = District::where('id', $request->id)->first();
        if(!empty($district)){
            $check_name = District::where('name', $request->name)->where('city_id', $request->city_id)->first();
            if (empty($check_name)){
                District::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'updated_by' => Auth::user()->email,
                    ]
                    );
                return redirect('master/district')->with('suc_message', 'Data telah diperbarui!');
            } else {
                return redirect()->back()->with('err_message', 'Kecamatan di Kota tersebut telah terdaftar!');
            }
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function DistrictDelete(Request $request)
    {
        $district = District::where('id', $request->id)->first();
        if(!empty($district)){
            District::where('id', $request->id)->update(['status' => 0]);
            return redirect('master/district')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function GetListCity($province_id)
    {
        $city = City::where('province_id', $province_id)->where('status', 1)->orderBy('name', 'asc')->get();
        return $city->toJson();
    }
}