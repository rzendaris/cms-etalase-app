<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\User;
use App\Model\Tables\Job;

class JobManController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Master Data Pekerjaan Ditolak!');
            }
            return $next($request);
        });
        
    }
    
    public function JobInit()
    {
        $job = Job::where('status', 1)->get();
        $no = 1;
        foreach($job as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'job' => $job
        );
        return view('m-master-data/m-job-mgmt/m-job-mgmt')->with('data', $data);
    }

    public function JobInsert(Request $request)
    {
        $job = Job::where('name', $request->name)->first();
        if(empty($job)){
            Job::create([
                'name' => $request->name,
                'created_by' => Auth::user()->email,
                'status' => 1,
            ]);
            return redirect('master/job')->with('suc_message', 'Data baru berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('err_message', 'Pekerjaan telah terdaftar!');
        }
    }

    public function JobUpdate(Request $request)
    {
        $job = Job::where('id', $request->id)->first();
        if(!empty($job)){
            Job::where('id', $request->id)
              ->update([
                  'name' => $request->name,
                  'updated_by' => Auth::user()->email,
                  ]
                );
            return redirect('master/job')->with('suc_message', 'Data telah diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function JobDelete(Request $request)
    {
        $job = Job::where('id', $request->id)->first();
        if(!empty($job)){
            Job::where('id', $request->id)->update(['status' => 0]);
            return redirect('master/job')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}