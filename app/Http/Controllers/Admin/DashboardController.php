<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Model\Views\PopulationPerProvince;
use App\Model\Views\PopulationPerCity;
use App\Model\Views\PopulationPerDistrict;
use App\Model\Views\PopulationPerVillage;
class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function Dashboard()
    {
        if (Auth::user()->role_id == 1){
            $per_province = PopulationPerProvince::get();
            $per_city = PopulationPerCity::get();
            $per_district = PopulationPerDistrict::get();
            $per_village = PopulationPerVillage::get();
    
            $data = array(
                'province' => $per_province,
                'city' => $per_city,
                'district' => $per_district,
                'village' => $per_village,
            );
            return view('m-dashboard/dashboard')->with('data', $data);
        } else {
            return redirect('family-tree')->with('access_message', 'Akses untuk Menu Dashboard Ditolak!');
        }
    }
}
