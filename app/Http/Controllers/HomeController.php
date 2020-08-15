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
      $role = Auth::user()->role_id;
        if (env('ENV') == 'ADMIN' && $role=='1'){
          return redirect('user-management');
        }else if(env('ENV') == 'DEVELOPER' && $role=='2'){
          return redirect('apps-developer');
        }else{
          Auth::logout();
          return redirect('/')->with('err_message', 'Error Ga Boleh Masuk!');
        }
    }

    /**
     * Show the application after login.
     *
     * @return redirect to @url(`under-construction`)
     */
    public function main()
    {
      $role = Auth::user()->role_id;
      if (env('ENV') == 'ADMIN' && $role=='1'){
        return redirect('user-management');
      }else if(env('ENV') == 'DEVELOPER' && $role=='2'){
        return redirect('apps-developer');
      }else{
        Auth::logout();
        return redirect('/')->with('err_message', 'Error Ga Boleh Masuk!');
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
