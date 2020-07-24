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
}
