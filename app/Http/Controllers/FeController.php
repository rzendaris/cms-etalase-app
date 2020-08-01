<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Table\MstCountry;

class FeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function Register()
    {
        $country = MstCountry::all();
        $data = [
            'country' => $country
        ];
        return view('auth/register-page')->with($data);
    }
    public function Profile()
    {
        return view('auth/profile');
    }
    public function ProfilePassword()
    {
        return view('auth/profile-password');
    }
    public function EndUserManagement()
    {
        return view('end-user-management/index');
    }
    public function AddEndUser()
    {
        return view('end-user-management/add');
    }
    public function EditEndUser()
    {
        return view('end-user-management/edit');
    }
    public function DetailEndUser()
    {
        return view('end-user-management/detail');
    }

    public function DeveloperManagement()
    {
        return view('developer-management/index');
    }
    public function AddDeveloperManagement()
    {
        return view('developer-management/add');
    }
    public function EditDeveloperManagement()
    {
        return view('developer-management/edit');
    }
    public function DetailDeveloperManagement()
    {
        return view('developer-management/detail');
    }

    public function AppsManagement()
    {
        return view('apps-management/index');
    }
    public function AddAppsManagement()
    {
        return view('apps-management/add');
    }
    public function EditAppsManagement()
    {
        return view('apps-management/edit');
    }
    public function DetailAppsManagement()
    {
        return view('apps-management/detail');
    }
    public function ReviewInfo()
    {
        return view('apps-management/reviewinfo');
    }
    public function Approval()
    {
        return view('apps-management/approval');
    }
    public function PartnershipIndex()
    {
        return view('apps-management/index-partnership');
    }
    public function AddAppsPartnership()
    {
        return view('apps-management/add-apps-partnership');
    }
    public function EditAppsPartnership()
    {
        return view('apps-management/edit-apps-partnership');
    }
}