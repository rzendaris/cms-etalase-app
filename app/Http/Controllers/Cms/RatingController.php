<?php

namespace App\Http\Controllers\Cms;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Model\Table\Ratings;
use App\Model\Table\Apps;

class RatingController extends Controller
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
                return redirect('/')->with('access_message', 'Akses untuk Menu User Management Ditolak!');
            }
            return $next($request);
        });

    }

    public function RatingInit($id)
    {
        $ratings = Ratings::with(['endusers','apps'])->where('apps_id',$id)->get();
        $ratingsall = Ratings::with(['endusers','apps'])->get();
        $avgrating = Ratings::where('apps_id',$id)->avg('ratings');
        $apps = Apps::with(['categories','ratings','skds'])->where('id', $id)->first();
        $no = 1;
        foreach($ratings as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'ratings' => $ratings,
            'avgrating' => $avgrating,
            'ratingsall' => $ratingsall,
            'apps'=> $apps,
        );
        return view('apps-management/reviewinfo')->with('data', $data);
    }

}