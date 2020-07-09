<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\User;
use App\Model\Tables\Ethnic;

class EthnicManController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Master Data Etnis Ditolak!');
            }
            return $next($request);
        });
        
    }
    
    public function EthnicInit()
    {
        $ethnic = Ethnic::where('status', 1)->get();
        $no = 1;
        foreach($ethnic as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'ethnic' => $ethnic
        );
        return view('m-master-data/m-ethnic-mgmt/m-ethnic-mgmt')->with('data', $data);
    }

    public function EthnicInsert(Request $request)
    {
        $ethnic = Ethnic::where('name', $request->name)->first();
        if(empty($ethnic)){
            Ethnic::create([
                'name' => $request->name,
                'created_by' => Auth::user()->email,
                'status' => 1,
            ]);
            return redirect('master/ethnic')->with('suc_message', 'Data baru berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('err_message', 'Nama suku telah terdaftar!');
        }
    }

    public function EthnicUpdate(Request $request)
    {
        $ethnic = Ethnic::where('id', $request->id)->first();
        if(!empty($ethnic)){
            Ethnic::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'updated_by' => Auth::user()->email,
                  ]
                );
            return redirect('master/ethnic')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function EthnicDelete(Request $request)
    {
        $ethnic = Ethnic::where('id', $request->id)->first();
        if(!empty($ethnic)){
            Ethnic::where('id', $request->id)->update(['status' => 0]);
            return redirect('master/ethnic')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}