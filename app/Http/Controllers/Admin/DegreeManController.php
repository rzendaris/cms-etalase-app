<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\User;
use App\Model\Tables\TitleAdat;

class DegreeManController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Master Data Gelar Ditolak!');
            }
            return $next($request);
        });
        
    }
    
    public function DegreeInit()
    {
        $degree = TitleAdat::where('status', 1)->get();
        $no = 1;
        foreach($degree as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'degree' => $degree
        );
        return view('m-master-data/m-degree-mgmt/m-degree-mgmt')->with('data', $data);
    }

    public function DegreeInsert(Request $request)
    {
        $degree = TitleAdat::where('name', $request->name)->first();
        if(empty($degree)){
            TitleAdat::create([
                'name' => $request->name,
                'created_by' => Auth::user()->email,
                'status' => 1,
            ]);
            return redirect('master/degree')->with('suc_message', 'Data baru berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('err_message', 'Title Adat telah terdaftar!');
        }
    }

    public function DegreeUpdate(Request $request)
    {
        $degree = TitleAdat::where('id', $request->id)->first();
        if(!empty($degree)){
            TitleAdat::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'updated_by' => Auth::user()->email,
                  ]
                );
            return redirect('master/degree')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function DegreeDelete(Request $request)
    {
        $degree = TitleAdat::where('id', $request->id)->first();
        if(!empty($degree)){
            TitleAdat::where('id', $request->id)->update(['status' => 0]);
            return redirect('master/degree')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}