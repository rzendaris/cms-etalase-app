<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Response;

use App\User;
use App\Model\Tables\Village;
use App\Model\Tables\District;
use App\Model\Tables\City;
use App\Model\Tables\Province;

class VillageManController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Master Data Kelurahan Ditolak!');
            }
            return $next($request);
        });
        
    }

    public function VillageInit(Request $request)
    {
        $paginate = 15;
        if (isset($request->query()['search'])){
            $search = $request->query()['search'];
            $village = Village::where('status', 1)
                ->where('name', 'like', "%" . $search. "%")
                ->with(['district', 'district.city', 'district.city.province'])
                ->simplePaginate($paginate);
            $village->appends(['search' => $search]);
        } else {
            $village = Village::with(['district', 'district.city', 'district.city.province'])->where('status', 1)->simplePaginate($paginate);
        }
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $no = 1 + (($village->currentPage() - 1) * $paginate);
        foreach($village as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'village' => $village,
            'list_province' => $province
        );
        return view('m-master-data/m-village-mgmt/m-village-mgmt')->with('data', $data);
    }

    public function VillageInsert(Request $request)
    {
        $village = Village::where('name', $request->name)->where('district_id', $request->district_id)->first();
        if(empty($village)){
            $district = District::where('id', $request->district_id)->where('status', 1)->get();
            if(!empty($district)){
                Village::create([
                    'name' => $request->name,
                    'district_id' => $request->district_id,
                    'created_by' => Auth::user()->email,
                    'status' => 1,
                ]);
                return redirect('master/village')->with('suc_message', 'Data baru berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('err_message', 'Kecamatan tidak terdaftar! Tambahkan Kecamatan terlebih dahulu');
            }
        } else {
            return redirect()->back()->with('err_message', 'Kelurahan telah terdaftar!');
        }
    }

    public function VillageUpdate(Request $request)
    {
        $village = Village::where('id', $request->id)->first();
        if(!empty($village)){
            $check_name = Village::where('name', $request->name)->where('district_id', $request->district_id)->first();
            if (empty($check_name)){
                Village::where('id', $request->id)
                  ->update([
                      'name' => $request->name,
                      'updated_by' => Auth::user()->email,
                      ]
                    );
                return redirect('master/village')->with('suc_message', 'Data telah diperbarui!');
            } else {
                return redirect()->back()->with('err_message', 'Kelurahan di Kecamatan tersebut telah terdaftar!');
            }
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function VillageDelete(Request $request)
    {
        $village = Village::where('id', $request->id)->first();
        if(!empty($village)){
            Village::where('id', $request->id)->update(['status' => 0]);
            return redirect('master/village')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function GetListDistrict($city_id)
    {
        $district = District::where('city_id', $city_id)->where('status', 1)->orderBy('name', 'asc')->get();
        return $district->toJson();
    }

    public function GetListVillage($district_id)
    {
        $village = Village::where('district_id', $district_id)->where('status', 1)->orderBy('name', 'asc')->get();
        return $village->toJson();
    }
}