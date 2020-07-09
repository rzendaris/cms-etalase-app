<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Storage;
use DB;

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

class FamilyManController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id == 3){
                return redirect('family-tree')->with('access_message', 'Akses untuk Menu Family Management Ditolak!');
            }
            return $next($request);
        });
        
    }

    public function FamilyManInit(Request $request)
    {
        $paginate = 15;
        if (isset($request->query()['search'])){
            $search = $request->query()['search'];
            $family = Family::where('family_no', 'like', "%" . $search. "%")->where('status', 1)->orderBy('family_no', 'asc')->simplePaginate($paginate);
            $family->appends(['search' => $search]);
        } else {
            $family = Family::where('status', 1)->orderBy('family_no', 'asc')->simplePaginate($paginate);
        }
        $no = 1;
        foreach($family as $data){
            $member = FamilyMember::with(['member_belongs' => function ($query) {
                $query->where('member_status_id', 1)->where('status', 1);
            }])->where('family_id', $data->id)->get();
            $data->kepala_keluarga = "Kepala Keluarga tidak terdaftar!";
            foreach($member as $check_head_family){
                if(isset($check_head_family->member_belongs)){
                    $data->kepala_keluarga = $check_head_family->member_belongs->full_name;
                }
            }
            $get_family_member = FamilyMember::select('member_id')->where('family_id', $data->id)->get();
            $data->member = Member::whereIn('id', $get_family_member)->where('status', 1)->orderBy('member_status_id', 'asc')->get();
            $results = DB::select( DB::raw("SELECT
                    ROUND(
                        100-
                        (( 
                        SUM(ISNULL(f.id))+
                        SUM(ISNULL(f.inherit_no))+
                        SUM(ISNULL(f.photo))+
                        SUM(ISNULL(f.tlp_no))
                        )/COUNT(m.id)
                        +
                        (
                        SUM(ISNULL(m.job_id))+
                        SUM(ISNULL(m.education_id))+
                        SUM(ISNULL(m.ethnic_id))+
                        SUM(ISNULL(m.address))+
                        SUM(ISNULL(m.instance_name))+
                        SUM(ISNULL(m.school_name))+
                        SUM(ISNULL(m.title_adat_id))+
                        SUM(ISNULL(m.photo))+
                        SUM(ISNULL(m.sur_name))+
                        SUM(ISNULL(m.graduation_year))+
                        SUM(ISNULL(m.phone_number))
                        ))
                        /((COUNT(m.id)*22)+10)*100
                    , 1) AS completed_percentage
                FROM 
                    family AS f
                INNER JOIN family_member AS fm
                    ON f.id = fm.family_id
                INNER JOIN member AS m
                    ON m.id = fm.member_id
                WHERE f.family_no = '$data->family_no'") );
            $data->percentage_fill = 0;
            if(isset($results)){
                $data->percentage_fill = $results[0]->completed_percentage;
            }
            $data->no = $no;
            $no++;
        }
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $data = array(
            'family' => $family,
            'province' => $province
        );
        return view('m-family-mgmt/list-family-mgmt')->with('data', $data);
    }

    public function FamilyManAdd()
    {
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $city = City::where('status', 1)->orderBy('name', 'asc')->get();
        $district = District::where('status', 1)->orderBy('name', 'asc')->get();
        $village = Village::where('status', 1)->orderBy('name', 'asc')->get();
        $marital = Marital::orderBy('id', 'asc')->get();
        $religion = Religion::orderBy('id', 'asc')->get();
        $education = Education::orderBy('id', 'asc')->get();
        $ethnic = Ethnic::where('status', 1)->orderBy('name', 'asc')->get();
        $title_adat = TitleAdat::where('status', 1)->orderBy('name', 'asc')->get();
        $member_status = MemberStatus::where('id', 1)->orderBy('id', 'asc')->get();
        $job = Job::where('status', 1)->orderBy('name', 'asc')->get();
        $data = array(
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
            'marital' => $marital,
            'religion' => $religion,
            'education' => $education,
            'ethnic' => $ethnic,
            'title_adat' => $title_adat,
            'member_status' => $member_status,
            'job' => $job
        );
        return view('m-family-mgmt/add-family-mgmt')->with('data', $data);
    }

    public function FamilyManInsert(Request $request)
    {
        $family = Family::where('family_no', $request->family_no)->where('status', 1)->first();
        if(empty($family)){
            $check_member_nik = Member::where('nik', $request->nik)->where('status', 1)->first();
            if(empty($check_member_nik)){
                $photo_master = $request->file('photo_master');
                if (isset($photo_master)){
                    if($request->file('photo_master')->getSize() > 1000000){
                        return redirect()->back()->with('err_message', 'Foto Keluarga lebih besar dari 1 MB!');
                    }
                }
                $photo = $request->file('photo');
                if (isset($photo)){
                    if($request->file('photo')->getSize() > 1000000){
                        return redirect()->back()->with('err_message', 'Foto Anggota lebih besar dari 1 MB!');
                    }
                }
                $family = Family::create([
                    'family_no' => $request->family_no,
                    'inherit_no' => $request->inherit_no,
                    'address' => $request->address_master,
                    'province_id' => $request->province_id_master,
                    'city_id' => $request->city_id_master,
                    'district_id' => $request->district_id_master,
                    'village_id' => $request->village_id_master,
                    'post_code' => $request->post_code,
                    'tlp_no' => $request->tlp_no,
                    'created_by' => Auth::user()->email,
                    'status' => 1,
                ]);

                if (isset($photo_master)){
                    Family::where('id', $family->id)->update([
                        'photo' => $request->family_no.".".$photo_master->getClientOriginalExtension(),
                    ]);
                    $request->file('photo_master')->move(public_path("/photo/kk"), $request->family_no.".".$photo_master->getClientOriginalExtension());
                }

                $member = Member::create([
                    'full_name' => $request->full_name,
                    'sur_name' => $request->sur_name,
                    'nik' => $request->nik,
                    'birthday' => $request->birthday,
                    'religion_id' => $request->religion_id,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'education_id' => $request->education_id,
                    'job_id' => $request->job_id,
                    'marital_id' => $request->marital_id,
                    'ethnic_id' => $request->ethnic_id,
                    'title_adat_id' => $request->title_adat_id,
                    'school_name' => $request->school_name,
                    'graduation_year' => $request->graduation_year,
                    'member_status_id' => $request->member_status_id,
                    'instance_name' => $request->instance_name,
                    'is_life' => $request->is_life,
                    'gender_status' => $request->gender_status,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'created_by' => Auth::user()->email,
                    'status' => 1,
                ]);

                FamilyMember::create([
                    "family_id" => $family->id,
                    "member_id" => $member->id,
                ]);
                if (isset($photo)){
                    Member::where('id', $member->id)->update([
                        'photo' => $request->nik.".".$photo->getClientOriginalExtension(),
                    ]);
                    $request->file('photo')->move(public_path("/photo/member"), $member->nik.".".$photo->getClientOriginalExtension());
                }
                return redirect('family-management')->with('suc_message', 'Data baru berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('err_message', 'No NIK telah terdaftar!');
            }
        } else {
            return redirect()->back()->with('err_message', 'No KK telah terdaftar!');
        }
    }
    
    public function FamilyManEdit($family_id)
    {
        $family = Family::where('id', $family_id)
            ->where('status', 1)
            ->with([
                'family_member', 
                'family_member.member_belongs' => function ($query) {
                    $query->where('status', 1);
                },
                'family_member.member_belongs.member_status', 
                'family_member.member_belongs.ethnic'
                ])
            ->first();
        $get_family_member = FamilyMember::select('member_id')->where('family_id', $family->id)->get();
        $family->member = Member::whereIn('id', $get_family_member)->where('status', 1)->orderBy('member_status_id', 'asc')->get();
        $no_data_member = 1;
        $status_head_family = 0;
        foreach($family->member as $data_member){
            if($data_member->member_status_id == 1){
                $status_head_family = 1;
            }
            $data_member->no = $no_data_member;
            $no_data_member++;
        }
        
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $city = City::where('status', 1)->orderBy('name', 'asc')->get();
        $district = District::where('status', 1)->orderBy('name', 'asc')->get();
        $village = Village::where('status', 1)->orderBy('name', 'asc')->get();
        $marital = Marital::orderBy('id', 'asc')->get();
        $religion = Religion::orderBy('id', 'asc')->get();
        $education = Education::orderBy('id', 'asc')->get();
        $ethnic = Ethnic::where('status', 1)->orderBy('name', 'asc')->get();
        $title_adat = TitleAdat::where('status', 1)->orderBy('name', 'asc')->get();
        $member_status = MemberStatus::where('id', '!=', $status_head_family)->orderBy('id', 'asc')->get();
        $job = Job::where('status', 1)->orderBy('name', 'asc')->get();

        $data = array(
            'family' => $family,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
            'marital' => $marital,
            'religion' => $religion,
            'education' => $education,
            'ethnic' => $ethnic,
            'title_adat' => $title_adat,
            'member_status' => $member_status,
            'job' => $job
        );
        return view('m-family-mgmt/update-family-mgmt')->with('data', $data);
    }
    
    public function FamilyManEditFamily($family_id)
    {
        $family = Family::where('id', $family_id)
            ->where('status', 1)
            ->with([
                'family_member', 
                'family_member.member_belongs' => function ($query) {
                    $query->where('status', 1);
                },
                'family_member.member_belongs.member_status', 
                'family_member.member_belongs.ethnic'
                ])
            ->first();
        $get_family_member = FamilyMember::select('member_id')->where('family_id', $family->id)->get();
        $family->member = Member::whereIn('id', $get_family_member)->where('status', 1)->orderBy('member_status_id', 'asc')->get();
        $no_data_member = 1;
        $status_head_family = 0;
        foreach($family->member as $data_member){
            if($data_member->member_status_id == 1){
                $status_head_family = 1;
            }
            $data_member->no = $no_data_member;
            $no_data_member++;
        }
        
        $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
        $city = City::where('status', 1)->orderBy('name', 'asc')->get();
        $district = District::where('status', 1)->orderBy('name', 'asc')->get();
        $village = Village::where('status', 1)->orderBy('name', 'asc')->get();
        $marital = Marital::orderBy('id', 'asc')->get();
        $religion = Religion::orderBy('id', 'asc')->get();
        $education = Education::orderBy('id', 'asc')->get();
        $ethnic = Ethnic::where('status', 1)->orderBy('name', 'asc')->get();
        $title_adat = TitleAdat::where('status', 1)->orderBy('name', 'asc')->get();
        $member_status = MemberStatus::where('id', '!=', $status_head_family)->orderBy('id', 'asc')->get();
        $job = Job::where('status', 1)->orderBy('name', 'asc')->get();

        $data = array(
            'family' => $family,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
            'marital' => $marital,
            'religion' => $religion,
            'education' => $education,
            'ethnic' => $ethnic,
            'title_adat' => $title_adat,
            'member_status' => $member_status,
            'job' => $job
        );
        return view('m-family-mgmt/update-family-data')->with('data', $data);
    }

    public function FamilyManUpdate(Request $request)
    {
        $family = Family::where('id', $request->id)->first();
        if(!empty($family)){
            $photo_master = $request->file('photo');
            if (isset($photo_master)){
                if($request->file('photo')->getSize() > 1000000){
                    return redirect()->back()->with('err_message', 'Foto Keluarga lebih besar dari 1 MB!');
                }
            }
            Family::where('id', $family->id)->update([
                'family_no' => $request->family_no,
                'inherit_no' => $request->inherit_no,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'post_code' => $request->post_code,
                'tlp_no' => $request->tlp_no,
                'updated_by' => Auth::user()->email,
                'status' => 1,
            ]);

            if (isset($photo_master)){
                Family::where('id', $family->id)->update([
                    'photo' => $request->family_no.".".$photo_master->getClientOriginalExtension(),
                ]);
                $request->file('photo')->move(public_path("/photo/kk"), $request->family_no.".".$photo_master->getClientOriginalExtension());
            }
            return redirect('family-management')->with('suc_message', 'Data Berhasil Diperbarui!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function FamilyManDelete(Request $request)
    {
        $family = Family::where('id', $request->id)->first();
        if(!empty($family)){
            Family::where('id', $request->id)->update(['status' => 0]);
            return redirect('family-management')->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function FamilyMemberInsert(Request $request)
    {
        $family = Family::where('id', $request->family_id)->first();
        if(!empty($family)){
            $check_member_nik = Member::where('nik', $request->nik)->where('status', 1)->first();
            if(empty($check_member_nik)){
                $photo = $request->file('photo');
                if (isset($photo)){
                    if($request->file('photo')->getSize() > 1000000){
                        return redirect()->back()->with('err_message', 'Foto Anggota lebih besar dari 1 MB!');
                    }
                }
                $member = Member::create([
                    'full_name' => $request->full_name,
                    'sur_name' => $request->sur_name,
                    'nik' => $request->nik,
                    'birthday' => $request->birthday,
                    'religion_id' => $request->religion_id,
                    'province_id' => $request->province_id,
                    'city_id' => $request->city_id,
                    'district_id' => $request->district_id,
                    'village_id' => $request->village_id,
                    'education_id' => $request->education_id,
                    'job_id' => $request->job_id,
                    'marital_id' => $request->marital_id,
                    'ethnic_id' => $request->ethnic_id,
                    'title_adat_id' => $request->title_adat_id,
                    'school_name' => $request->school_name,
                    'graduation_year' => $request->graduation_year,
                    'member_status_id' => $request->member_status_id,
                    'instance_name' => $request->instance_name,
                    'is_life' => $request->is_life,
                    'gender_status' => $request->gender_status,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'created_by' => Auth::user()->email,
                    'status' => 1,
                ]);

                FamilyMember::create([
                    "family_id" => $family->id,
                    "member_id" => $member->id,
                ]);
                if (isset($photo)){
                    Member::where('id', $member->id)->update([
                        'photo' => $request->nik.".".$photo->getClientOriginalExtension()
                    ]);
                    $request->file('photo')->move(public_path("/photo/member"), $member->nik.".".$photo->getClientOriginalExtension());
                }
                return redirect('family-management/edit/'.$family->id)->with('suc_message', 'Data baru berhasil ditambahkan!');
            } else {
                return redirect()->back()->with('err_message', 'No NIK telah terdaftar!');
            }
        } else {
            return redirect()->back()->with('err_message', 'Data Keluarga Tidak Ditemukan!');
        }
    }

    public function FamilyMemberDelete(Request $request)
    {
        $member = Member::where('id', $request->id)->first();
        if(!empty($member)){
            Member::where('id', $request->id)->update(['status' => 0]);
            return redirect('family-management/edit/'.$request->family_id)->with('suc_message', 'Data telah dihapus!');
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }

    public function FamilyMemberEditView($family_id, $member_id)
    {
        $family = Family::where('id', $family_id)
            ->where('status', 1)
            ->with([
                'family_member', 
                'family_member.member_belongs' => function ($query) {
                    $query->where('status', 1);
                },
                'family_member.member_belongs.member_status', 
                'family_member.member_belongs.ethnic'
                ])
            ->first();
        if(!empty($family)){
            $member = Member::where('id', $member_id)->first();
            if(!empty($member)){
                $status_head_family = 0;
                foreach($family->family_member as $data){
                    if (isset($data->member_belongs) && $member->member_status_id != 1){
                        if ($data->member_belongs->member_status_id == 1){
                            $status_head_family = 1;
                        }
                    }
                }
                $province = Province::where('status', 1)->orderBy('name', 'asc')->get();
                $city = City::where('status', 1)->orderBy('name', 'asc')->get();
                $district = District::where('status', 1)->orderBy('name', 'asc')->get();
                $village = Village::where('status', 1)->orderBy('name', 'asc')->get();
                $marital = Marital::orderBy('id', 'asc')->get();
                $religion = Religion::orderBy('id', 'asc')->get();
                $education = Education::orderBy('id', 'asc')->get();
                $ethnic = Ethnic::where('status', 1)->orderBy('name', 'asc')->get();
                $title_adat = TitleAdat::where('status', 1)->orderBy('name', 'asc')->get();
                $member_status = MemberStatus::where('id', '!=', $status_head_family)->orderBy('id', 'asc')->get();
                $job = Job::where('status', 1)->orderBy('name', 'asc')->get();

                $data = array(
                    'family_id' => $family->id,
                    'member' => $member,
                    'province' => $province,
                    'city' => $city,
                    'district' => $district,
                    'village' => $village,
                    'marital' => $marital,
                    'religion' => $religion,
                    'education' => $education,
                    'ethnic' => $ethnic,
                    'title_adat' => $title_adat,
                    'member_status' => $member_status,
                    'job' => $job
                );
                return view('m-family-mgmt/update-family-member-mgmt')->with('data', $data);
            } else {
                return redirect('family-management/edit/'.$family->id)->with('err_message', 'Data Daftar Anggota tidak ditemukan!');
            }
        } else {
            return redirect('family-management')->with('err_message', 'Data Keluarga tidak ditemukan!');
        }
    }

    public function FamilyMemberUpdate(Request $request)
    {
        $member = Member::where('id', $request->id)->first();
        if(!empty($member)){
            $member_check_nik = Member::where('nik', $request->nik)->where('status', 1)->first();
            if(empty($member_check_nik) || $member->id == $member_check_nik->id){
                $photo = $request->file('photo');
                if (isset($photo)){
                    if($request->file('photo')->getSize() > 1000000){
                        return redirect()->back()->with('err_message', 'Foto lebih besar dari 1 MB!');
                    } else {
                        Member::where('id', $member->id)
                        ->update([
                                'photo' => $request->nik.".".$photo->getClientOriginalExtension()
                            ]);
                        $request->file('photo')->move(public_path("/photo/member"), $member->nik.".".$photo->getClientOriginalExtension());
                    }
                }
                Member::where('id', $member->id)
                  ->update([
                        'full_name' => $request->full_name,
                        'sur_name' => $request->sur_name,
                        'nik' => $request->nik,
                        'birthday' => $request->birthday,
                        'religion_id' => $request->religion_id,
                        'province_id' => $request->province_id,
                        'city_id' => $request->city_id,
                        'district_id' => $request->district_id,
                        'village_id' => $request->village_id,
                        'education_id' => $request->education_id,
                        'job_id' => $request->job_id,
                        'marital_id' => $request->marital_id,
                        'ethnic_id' => $request->ethnic_id,
                        'title_adat_id' => $request->title_adat_id,
                        'school_name' => $request->school_name,
                        'graduation_year' => $request->graduation_year,
                        'member_status_id' => $request->member_status_id,
                        'instance_name' => $request->instance_name,
                        'is_life' => $request->is_life,
                        'gender_status' => $request->gender_status,
                        'address' => $request->address,
                        'phone_number' => $request->phone_number,
                        'updated_by' => Auth::user()->email,
                    ]);
                return redirect('family-management/edit/'.$request->family_id)->with('suc_message', 'Data telah Diperbarui!');
            } else {
                return redirect()->back()->with('err_message', 'No NIK telah terdaftar di member lain!');
            }
        } else {
            return redirect()->back()->with('err_message', 'Data tidak ditemukan!');
        }
    }
}