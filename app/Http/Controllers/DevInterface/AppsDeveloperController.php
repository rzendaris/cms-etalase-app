<?php

namespace App\Http\Controllers\DevInterface;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use App\User;
use App\Model\Table\Apps;
use App\Model\Table\MstCategories;
use App\Model\Table\Ratings;
use App\Model\View\AvgRatings;
use App\Model\Table\MstSdk;
use App\Model\Table\MstCountry;

class AppsDeveloperController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


    }

    public function AppsDevInit()
    {
        $appsapprove = AvgRatings::with(['categories'])->where('is_approve', 1)->get();
        $apps = AvgRatings::with(['categories'])->get();
        $no = 1;
        foreach($apps as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'appsapprove' => $appsapprove,
            'apps' => $apps,
        );
        return view('apps-developer/index')->with('data', $data);
    }
    public function getDownload($id)
    {
        $apps = Apps::where('id', $id)->first();
        //PDF file is stored under project/public/download/info.pdf
        $file= $this->MapPublicPath(). "apk/".$apps->apk_file;
        $name = $apps->name.".apk";
        $headers = array(
                  'Content-Type: application/apk',
                );
        return response()->download($file, $name, $headers);
    }
}
