<?php

namespace App\Http\Controllers\Cms;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Model\Table\MstAds;
use App\Model\Table\MstCountry;

class AdsManController extends Controller
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
                return redirect('/')->with('access_message', 'Akses untuk Menu Ads Management Ditolak!');
            }
            return $next($request);
        });

    }

    public function AdsMgmtInit()
    {
        $user = MstAds::with(['countrys'])->where('role_id', 3)->get();
        $no = 1;
        foreach($user as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'user' => $user
        );
        return view('ads-management/index')->with('data', $data);
    }
    public function AdsMgmtInsert(Request $request)
    {
        // $user = MstAds::where('email', $request->email)->first();

            // if(empty($user)){
              if($request->photo){
                  $file_extention = $request->photo->getClientOriginalExtension();
                  $file_name = $request->email.'image_ads.'.$file_extention;
                  $file_path = $request->photo->move($this->MapPublicPath().'pictures',$file_name);
              }
              MstAds::create([
                  'name' => $request->name,
                  'link' => $request->link,
                  'orders' => $request->orders,
                  'picture' => $file_name,
                  'status' => 1,
                  'create_by' => Auth::user()->id,
                  // 'token' => Str::random(60),
              ]);
              return redirect('ads-management')->with('suc_message', 'Ads berhasil ditambahkan!');
          // } else {
          //     return redirect()->back()->with('err_message', 'Email telah digunakan! Gunakan alamat email yang belum terdaftar!');
          // }

    }

    public function AdsMgmtUpdate(Request $request)
    {
          $ads = MstAds::where('id', $request->id)->first();
          $ads = MstAds::where('id', $request->id)->first();
          if(!empty($ads)){
          if($request->photo){
            $file_extention = $request->photo->getClientOriginalExtension();
            $file_name = $request->email.'image_ads.'.$file_extention;
            $file_path = $request->photo->move($this->MapPublicPath().'pictures',$file_name);
          }else{
            $file_name=$ads->picture;
          }
            MstAds::where('id', $request->id)
              ->update([
                'name' => $request->name,
                'link' => $request->link,
                'orders' => $request->orders,
                'picture' => $file_name,
                'status' => 1,
                'create_by' => Auth::user()->id,
                  ]
                );
            return redirect('ads-management')->with('suc_message', 'Data telah diperbarui!');
          } else {
              return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
          }
    }
    public function AdsMgmtDelete(Request $request)
    {
        $ads = MstAds::where('id', $request->id)->first();
        if(!empty($ads)){
            MstAds::where('id', $request->id)->delete();
            return redirect()->back()->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }


}
