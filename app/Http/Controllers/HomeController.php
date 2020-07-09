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
            return redirect('dashboard');
        } else {
            return redirect('family-tree');
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
            return redirect('dashboard');
        } else {
            return redirect('family-tree');
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
}
