<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      if (Auth::user()->role_id == 1){
          return redirect('end-user-management');
      } else {
          // return redirect('family-tree');
          echo "developer";
      }
    }

    /**
     * Show the application after login.
     *
     * @return redirect to @url(`under-construction`)
     */
    public function main()
    {
        if (Auth::user()->role_id == 1){
            return redirect('end-user-management');
        } else {
            // return redirect('family-tree');
            echo "login developer";
        }
    }

    /**
     * Show the application under construction.
     *
     * @return view(`under-construction`)
     */
    public function underConstruction()
    {
        return view('under-construction');
    }

    public function forgotPassword(Request $request)
    {
        dd($request);
        $validate = $request->validate([
            'email' => 'required|string',
            'CaptchaCode' => 'required|valid_captcha',
        ]);
        return redirect('login')->with('suc_message', 'Periksa email anda!');
    }
    public function register(Request $request)
    {
      // if($request->photo_master){
      //     $file_extention = $request->photo_master->getClientOriginalExtension();
      //     $file_name = $request->email.'image_profile.'.$file_extention;
      //     $file_path = $request->photo_master->move(public_path().'/pictures',$file_name);
      // }
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dev_web' => $request->website,
            'dev_country_id' => $request->country,
            'dev_address' => $request->address,
            'role_id' => 2,
            'is_blocked' => 1,
            'picture' => $request->photo_master,
            'password' => Hash::make($request->password),
        ]);
      echo "ok";
    }
}
