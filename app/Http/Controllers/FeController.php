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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Dashboard()
    {
        return view('m-dashboard/dashboard');
    }
    public function UserMgmt()
    {
        return view('m-user-mgmt/list-user-mgmt');
    }
    public function FamilyTree()
    {
        return view('m-family-tree/list-family-tree');
    }
    public function DetailFamilyTree()
    {
        return view('m-family-tree/detail-family-tree');
    }
    public function FamilyManagement()
    {
        return view('m-family-mgmt/list-family-mgmt');
    }
    public function AddFamilyMgmt()
    {
        return view('m-family-mgmt/add-family-mgmt');
    }
    public function EditFamilyMgmt()
    {
        return view('m-family-mgmt/update-family-mgmt');
    }


    public function Mastercity()
    {
        return view('m-master-data/m-city-mgmt/m-city-mgmt');
    }
    public function Masterdegree()
    {
        return view('m-master-data/m-degree-mgmt/m-degree-mgmt');
    }
    public function Masterdistrict()
    {
        return view('m-master-data/m-district-mgmt/m-district-mgmt');
    }
    public function Masterethnic()
    {
        return view('m-master-data/m-ethnic-mgmt/m-ethnic-mgmt');
    }
    public function Masterjob()
    {
        return view('m-master-data/m-job-mgmt/m-job-mgmt');
    }
    public function Masterprovince()
    {
        return view('m-master-data/m-province-mgmt/m-province-mgmt');
    }
    public function Mastervillage()
    {
        return view('m-master-data/m-village-mgmt/m-village-mgmt');
    }
}