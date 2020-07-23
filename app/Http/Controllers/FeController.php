<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function Register()
    {
        return view('auth/register-page');
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