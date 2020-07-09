@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <form method="post" action="{{url('family-management/member/update')}}" enctype="multipart/form-data">
    {{csrf_field()}}
        <div class="page-head">
            <div class="page-title">
                <h1>Perbarui Data Anggota Keluarga</h1>
            </div>
        </div>
        <div class="wrapper">
            <div class="row">
                <div class="col-md-12 element">
                @if(session()->has('err_message'))
                    <div class="alert alert-danger alert-dismissible" role="alert" auto-close="10000">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session()->get('err_message') }}
                    </div>
                @endif
                @if(session()->has('suc_message'))
                    <div class="alert alert-success alert-dismissible" role="alert" auto-close="10000">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session()->get('suc_message') }}
                    </div>
                @endif
                    <div class="box-pencarian-family-tree" style=" background: #fff; ">
                        <div class="row">
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">NIK :*</label>
                                    <input type="tel" name="nik" value="{{ $data['member']->nik }}" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Tanggal Lahir :*</label>
                                    <input type="date" name="birthday" value="{{ $data['member']->birthday }}" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kecamatan :*</label>
                                    <select name="district_id" id="district-selected" class="custom-select form-control" required>
                                        <option value="{{ $data['member']->district->id }}">{{ $data['member']->district->name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Jenis Pekerjaan :</label>
                                    <select name="job_id" class="custom-select form-control">
                                        <option value="{{ isset($data['member']->job) ? $data['member']->job->id : '' }}">{{ isset($data['member']->job) ? $data['member']->job->name : '-' }}</option>
                                        @foreach($data['job'] as $job)
                                            <option value="{{ $job->id }}">{{ $job->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Pendidikan Terakhir :</label>
                                    <select name="education_id" class="custom-select form-control">
                                        <option value="{{ isset($data['member']->education) ? $data['member']->education->id : '' }}">{{ isset($data['member']->education) ? $data['member']->education->name : '-' }}</option>
                                        @foreach($data['education'] as $education)
                                            <option value="{{ $education->id }}">{{ $education->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Suku :</label>
                                    <select name="ethnic_id" class="custom-select form-control">
                                        <option value="{{ isset($data['member']->ethnic) ? $data['member']->ethnic->id : '' }}">{{ isset($data['member']->ethnic) ? $data['member']->ethnic->name : '-' }}</option>
                                        @foreach($data['ethnic'] as $ethnic)
                                            <option value="{{ $ethnic->id }}">{{ $ethnic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Alamat :</label>
                                    <textarea type="text" name="address" class="form-control" rows="5">{{ $data['member']->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Lengkap :</label>
                                    <input type="text" name="full_name" value="{{ $data['member']->full_name }}" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Provinsi :</label>
                                    <select name="province_id" id="province-selected" class="custom-select form-control" required>
                                        <option value="{{ $data['member']->province->id }}">{{ $data['member']->province->name }}</option>
                                        @foreach($data['province'] as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kelurahan / Desa :</label>
                                    <select name="village_id" id="village-selected" class="custom-select form-control" required>
                                        <option value="{{ $data['member']->village->id }}">{{ $data['member']->village->name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Nama Instansi/Usaha :</label>
                                    <input type="text" name="instance_name" value="{{ $data['member']->instance_name }}" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Nama Sekolah Terakhir :</label>
                                    <input type="text" name="school_name" value="{{ $data['member']->school_name }}" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Gelar Adat :</label>
                                    <select name="title_adat_id" class="custom-select form-control">
                                        <option value="{{ isset($data['member']->title_adat) ? $data['member']->title_adat->id : '' }}">{{ isset($data['member']->title_adat) ? $data['member']->title_adat->name : '-' }}</option>
                                        @foreach($data['title_adat'] as $title_adat)
                                            <option value="{{ $title_adat->id }}">{{ $title_adat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Foto Diri :</label><br>
                                    <img id="blah2" alt="your image" width="90" height="90"  src="{{ url('photo/member/'.$data['member']->photo) }}"/><br>
                                    <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Panggilan :</label>
                                    <input type="text" name="sur_name" value="{{ $data['member']->sur_name }}" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kota / Kabupaten :*</label>
                                    <select name="city_id" id="city-selected" class="custom-select form-control" required>
                                        <option value="{{ $data['member']->city->id }}">{{ $data['member']->city->name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Hidup :*</label>
                                    <select name="is_life" class="custom-select form-control" required>
                                        @if($data['member']->is_life == 1)
                                            <option value="1">Hidup</option>
                                        @else
                                            <option value="0">Meninggal</option>
                                        @endif
                                        <option value="1">Hidup</option>
                                        <option value="0">Meninggal</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Jenis Kelamin :*</label>
                                    <select name="gender_status" class="custom-select form-control" required>
                                        <option value="{{ $data['member']->gender_status }}">{{ $data['member']->gender_status }}</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Pernikahan :*</label>
                                    <select name="marital_id" class="custom-select form-control" required>
                                        <option value="{{ $data['member']->marital->id }}">{{ $data['member']->marital->name }}</option>
                                        @foreach($data['marital'] as $marital)
                                            <option value="{{ $marital->id }}">{{ $marital->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Tahun Kelulusan :</label>
                                    <input type="tel" name="graduation_year" value="{{ $data['member']->graduation_year }}" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">No Telepon :</label>
                                    <input type="tel" name="phone_number" value="{{ $data['member']->phone_number }}" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Anggota Keluarga :*</label>
                                    <select name="member_status_id" class="custom-select form-control" required>
                                        <option value="{{ $data['member']->member_status->id }}">{{ $data['member']->member_status->name }}</option>
                                        @foreach($data['member_status'] as $member_status)
                                            <option value="{{ $member_status->id }}">{{ $member_status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>               
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Clone In This Div -->
                <div class="results"></div>
                <!-- Clone In This Div -->
            </div>

            <div class="row">
                <div class="col-xl-12 col-md-12 m-b-10px text-right">
                    <input type="hidden" name="id" value="{{ $data['member']->id }}"/>
                    <input type="hidden" name="family_id" value="{{ $data['family_id'] }}"/>
                    <a href="{{ url('family-management/edit/'.$data['family_id']) }}" class="btn btn-primary pull-left">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('myscript')

    <script src="{{ asset('assets/global/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/add-family.js') }}"></script>
    <script>
        $('[type=tel]').on('change', function(e) {
            $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
        });
        $('[type=tel]').on('keypress', function(e) {
            keys = ['0','1','2','3','4','5','6','7','8','9','.']
            return keys.indexOf(event.key) > -1
        });
    </script>
@endsection