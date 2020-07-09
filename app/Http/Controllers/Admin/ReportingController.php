<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Storage;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

use App\User;
use App\Model\Tables\Family;
use App\Model\Tables\FamilyMember;
use App\Model\Tables\Member;
use App\Model\Tables\Province;
use App\Model\Tables\City;
use App\Model\Tables\District;
use App\Model\Tables\Village;
use App\Model\Tables\Marital;
use App\Model\Tables\Religion;
use App\Model\Tables\Education;
use App\Model\Tables\Job;
use App\Model\Tables\Ethnic;
use App\Model\Tables\TitleAdat;
use App\Model\Tables\MemberStatus;

class ReportingController extends Controller
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
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Report Ditolak!');
            }
            return $next($request);
        });
        
    }
    
    public function ReportInit(Request $request)
    {
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $city = City::where('status', 1)->orderBy('name', 'asc')->get();
        $title_adat = TitleAdat::where('status', 1)->orderBy('name', 'asc')->get();
        $member_status = MemberStatus::orderBy('id', 'asc')->get();
        $ethnic = Ethnic::where('status', 1)->orderBy('name', 'asc')->get();
        $job = Job::where('status', 1)->orderBy('name', 'asc')->get();
        $marital = Marital::orderBy('id', 'asc')->get();
        $data = array(
            'province' => $province,
            'city' => $city,
            'marital' => $marital,
            'ethnic' => $ethnic,
            'title_adat' => $title_adat,
            'member_status' => $member_status,
            'job' => $job
        );

        return view('reporting/reporting')->with('data', $data);
    }

    public function ReportFilter(Request $request, $type)
    {
        $member = $this->searchEngine($request);
        $excel = Excel::create('Reporting', function($excel) use ($member){
            $excel->sheet("Daftar Anggota", function($sheet) use ($member)
            {
                $sheet->cell('A1', function($cell) {$cell->setValue('No. KK')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('B1', function($cell) {$cell->setValue('No. KK Induk')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('C1', function($cell) {$cell->setValue('NIK')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('D1', function($cell) {$cell->setValue('Nama Lengkap')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('E1', function($cell) {$cell->setValue('Nama Panggilan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('F1', function($cell) {$cell->setValue('Tgl Lahir')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('G1', function($cell) {$cell->setValue('Jenis Kelamin')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('H1', function($cell) {$cell->setValue('Agama')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('I1', function($cell) {$cell->setValue('Provinsi')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('J1', function($cell) {$cell->setValue('Kota')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('K1', function($cell) {$cell->setValue('Kecamatan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('L1', function($cell) {$cell->setValue('Kelurahan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('M1', function($cell) {$cell->setValue('Kode Pos')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('N1', function($cell) {$cell->setValue('Gelar Adat')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('O1', function($cell) {$cell->setValue('Suku')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                // $sheet->cell('P1', function($cell) {$cell->setValue('Kewarganegaraan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('P1', function($cell) {$cell->setValue('Jenis Pekerjaan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('Q1', function($cell) {$cell->setValue('Nama Instansi/Usaha')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('R1', function($cell) {$cell->setValue('Status Pernikahan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('S1', function($cell) {$cell->setValue('Pendidikan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('T1', function($cell) {$cell->setValue('Nama Sekolah')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('U1', function($cell) {$cell->setValue('Kelulusan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('V1', function($cell) {$cell->setValue('Status Keluarga')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('W1', function($cell) {$cell->setValue('Keberadaan')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('X1', function($cell) {$cell->setValue('No. Telp')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                $sheet->cell('Y1', function($cell) {$cell->setValue('Alamat')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                if (isset($member[0])) {
                    foreach ($member as $key => $value) {
                        $a= $key+2;
                        $sheet->cell('A'.$a, function($cell) use ($value) {$cell->setValue($value->family_member->family->family_no)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('B'.$a, function($cell) use ($value) {$cell->setValue($value->family_member->family->inherit_no)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('C'.$a, function($cell) use ($value) {$cell->setValue($value->nik)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('D'.$a, function($cell) use ($value) {$cell->setValue($value->full_name)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('E'.$a, function($cell) use ($value) {$cell->setValue($value->sur_name)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('F'.$a, function($cell) use ($value) {$cell->setValue($value->birthday)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('G'.$a, function($cell) use ($value) {$cell->setValue($value->gender_status)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('H'.$a, function($cell) use ($value) {$cell->setValue(isset($value->religion) ? $value->religion->name : '-')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('I'.$a, function($cell) use ($value) {$cell->setValue($value->province->name)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('J'.$a, function($cell) use ($value) {$cell->setValue($value->city->name)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('K'.$a, function($cell) use ($value) {$cell->setValue($value->district->name)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('L'.$a, function($cell) use ($value) {$cell->setValue($value->village->name)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('M'.$a, function($cell) use ($value) {$cell->setValue($value->family_member->family->post_code)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('N'.$a, function($cell) use ($value) {$cell->setValue(isset($value->title_adat) ? $value->title_adat->name : '-')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('O'.$a, function($cell) use ($value) {$cell->setValue(isset($value->ethnic) ? $value->ethnic->name : '-')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        // $sheet->cell('P'.$a, function($cell) use ($value) {$cell->setValue('Indonesia')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('P'.$a, function($cell) use ($value) {$cell->setValue(isset($value->job) ? $value->job->name : '-')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('Q'.$a, function($cell) use ($value) {$cell->setValue($value->instance_name)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('R'.$a, function($cell) use ($value) {$cell->setValue(isset($value->marital) ? $value->marital->name : '-')->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('S'.$a, function($cell) use ($value) {$cell->setValue(isset($value->education) ? $value->education->name : '-')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('T'.$a, function($cell) use ($value) {$cell->setValue($value->school_name)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('U'.$a, function($cell) use ($value) {$cell->setValue($value->graduation_year)->setBorder('thin', 'thin', 'thin', 'thin');   });
                        $sheet->cell('V'.$a, function($cell) use ($value) {$cell->setValue(isset($value->member_status) ? $value->member_status->name : '-')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('W'.$a, function($cell) use ($value) {$cell->setValue($value->is_life == 1 ? 'Hidup' : 'Mati')->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('X'.$a, function($cell) use ($value) {$cell->setValue($value->phone_number)->setBorder('thin', 'thin', 'thin', 'thin')->setAlignment('center');   });
                        $sheet->cell('Y'.$a, function($cell) use ($value) {$cell->setValue($value->address)->setBorder('thin', 'thin', 'thin', 'thin');   });
                    }
                }
                
            });
            
        });
        return $excel->download($type);
    }

    protected function searchEngine($request){
        $member = Member::where('status', 1);
        if (isset($request->province_id)){
            $member = $member->where('province_id', $request->province_id);
        }
        if (isset($request->city_id)){
            $member = $member->where('city_id', $request->city_id);
        }
        if (isset($request->member_status_id)){
            $member = $member->where('member_status_id', $request->member_status_id);
        }
        if (isset($request->marital_id)){
            $member = $member->where('marital_id', $request->marital_id);
        }
        if (isset($request->ethnic_id)){
            $member = $member->where('ethnic_id', $request->ethnic_id);
        }
        if (isset($request->is_life)){
            $member = $member->where('is_life', $request->is_life);
        }
        if (isset($request->title_adat_id)){
            $member = $member->where('title_adat_id', $request->title_adat_id);
        }
        if (isset($request->job_id)){
            $member = $member->where('job_id', $request->job_id);
        }

        $return = $member->get();
        return $return;
    }
}