@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Daftar Anggota Keluarga</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
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
            <div class="table-responsive custom--2">
                <table id="sorting-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Suku</th>
                            <th>Status Anggota</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['family']->member as $family_member)
                        <tr>
                            <td>{{ $family_member->no }}</td>
                            <td>{{ $family_member->nik }}</td>
                            <td>{{ $family_member->full_name }}</td>
                            <td>{{ $family_member->birthday }}</td>
                            @if(isset($family_member->ethnic))
                                <td>{{ $family_member->ethnic->name }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ $family_member->member_status->name }}</td>
                            <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#modal-detail-family-member-{{ $family_member->id }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                                <a href="{{ url('family-management/member/edit/'.$data['family']->id.'/'.$family_member->id) }}"><i class="fa fa-edit fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-family-member-{{ $family_member->id }}"><i class="fa fa-close fa-lg custom--1"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="page-head">
        <div class="page-title">
            <h1>Tambahkan Anggota Keluarga</h1>
        </div>
    </div>
    <div class="wrapper">
        <form method="post" action="{{url('family-management/member/insert')}}" enctype="multipart/form-data">
        {{csrf_field()}}
            <div class="row">
                <div class="col-md-12 element">
                    <div class="box-pencarian-family-tree" style=" background: #fff; ">
                        <div class="row">
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">NIK :*</label>
                                    <input type="tel" name="nik" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Tanggal Lahir :*</label>
                                    <input type="date" name="birthday" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kecamatan :*</label>
                                    <select name="district_id" id="district-selected" class="custom-select form-control" disabled required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Jenis Pekerjaan :</label>
                                    <select name="job_id" class="custom-select form-control">
                                        <option value="">Pilih Jenis Pekerjaan</option>
                                        @foreach($data['job'] as $job)
                                            <option value="{{ $job->id }}">{{ $job->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Pendidikan Terakhir :</label>
                                    <select name="education_id" class="custom-select form-control">
                                        <option value="">Pilih Pendidikan Terakhir</option>
                                        @foreach($data['education'] as $education)
                                            <option value="{{ $education->id }}">{{ $education->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Suku :</label>
                                    <select name="ethnic_id" class="custom-select form-control">
                                        <option value="">Pilih Suku</option>
                                        @foreach($data['ethnic'] as $ethnic)
                                            <option value="{{ $ethnic->id }}">{{ $ethnic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Alamat :</label>
                                    <textarea type="text" name="address" class="form-control" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"><i>Catatan : * (harus diisi)</i></label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Lengkap :*</label>
                                    <input type="text" name="full_name" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Provinsi :*</label>
                                    <select name="province_id" id="province-selected" class="custom-select form-control" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($data['province'] as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kelurahan / Desa :*</label>
                                    <select name="village_id" id="village-selected" class="custom-select form-control" disabled required>
                                        <option value="">Pilih Kelurahan / Desa</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Nama Instansi/Usaha :</label>
                                    <input type="text" name="instance_name" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Nama Sekolah Terakhir :</label>
                                    <input type="text" name="school_name" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Gelar Adat :</label>
                                    <select name="title_adat_id" class="custom-select form-control">
                                        <option value="">Pilih Gelar Adat</option>
                                        @foreach($data['title_adat'] as $title_adat)
                                            <option value="{{ $title_adat->id }}">{{ $title_adat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Foto Diri :</label><br>
                                    <img id="blah2" alt="your image" width="90" height="90" src="{{ asset('assets/global/img/no-profile.jpg') }}" /><br>
                                    <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Panggilan :</label>
                                    <input type="text" name="sur_name" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Kota / Kabupaten :*</label>
                                    <select name="city_id" id="city-selected" class="custom-select form-control" disabled required>
                                        <option value="">Pilih Kota / Kabupaten</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Hidup :*</label>
                                    <select name="is_life" class="custom-select form-control" required>
                                        <option value="">Pilih Status Hidup</option>
                                        <option value="1">Hidup</option>
                                        <option value="0">Meninggal</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Jenis Kelamin :*</label>
                                    <select name="gender_status" class="custom-select form-control" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Pernikahan :*</label>
                                    <select name="marital_id" class="custom-select form-control" required>
                                        <option value="">Pilih Status Pernikahan</option>
                                        @foreach($data['marital'] as $marital)
                                            <option value="{{ $marital->id }}">{{ $marital->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Tahun Kelulusan :</label>
                                    <input type="tel" name="graduation_year" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">No Telepon :</label>
                                    <input type="tel" name="phone_number" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Status Anggota Keluarga :*</label>
                                    <select name="member_status_id" class="custom-select form-control" required>
                                        <option value="">Pilih Status Anggota Keluarga</option>
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
                    <input type="hidden" name="family_id" value="{{ $data['family']->id }}"/>
                    <a href="{{ url('family-management') }}" class="btn btn-primary pull-left">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($data['family']->family_member as $family_member)
    @if(isset($family_member->member_belongs))
        <!-- Modal Delete -->
        <div id="modal-delete-family-member-{{ $family_member->member_belongs->id }}" class="modal fade">
            <form method="post" action="{{url('family-management/member/delete')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h2>Hapus Anggota Keluarga</h2>
                            <p>Apakah anda yakin ingin menghapus data?</p>
                        </div>
                        <input type="hidden" name="id" value="{{ $family_member->member_belongs->id }}"/>
                        <input type="hidden" name="family_id" value="{{ $data['family']->id }}"/>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Detail -->
        <div id="modal-detail-family-member-{{ $family_member->member_belongs->id }}" class="modal fade">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="text-center">Detail Anggota Keluarga</h2>
                        <div class="row">
                            <div class="col-md-12 element">
                                <div class="box-pencarian-family-tree" style=" background: #fff; ">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-4 m-b-10px">
                                            <div class="form-group">
                                                <label class="form-control-label">NIK :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->nik }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Tanggal Lahir :</label>
                                                <input type="date" value="{{ $family_member->member_belongs->birthday }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Kecamatan :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->district->name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Jenis Pekerjaan :</label>
                                                <input type="text" value="{{ isset($family_member->member_belongs->job) ? $family_member->member_belongs->job->name : '-' }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Pendidikan Terakhir :</label>
                                                <input type="text" value="{{ isset($family_member->member_belongs->education) ? $family_member->member_belongs->education->name : '-' }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Suku :</label>
                                                <input type="text" value="{{ isset($family_member->member_belongs->ethnic) ? $family_member->member_belongs->ethnic->name : '-' }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Alamat :</label>
                                                <textarea type="text" name="address" class="form-control" rows="5" disabled required>{{ $family_member->member_belongs->address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 m-b-10px">
                                            <div class="form-group">
                                                <label class="form-control-label">Nama Lengkap :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->full_name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Provinsi :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->province->name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Kelurahan / Desa :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->village->name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Nama Instansi/Usaha :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->instance_name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Nama Sekolah :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->school_name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Gelar Adat :</label>
                                                <input type="text" value="{{ isset($family_member->member_belongs->title_adat) ? $family_member->member_belongs->title_adat->name : '-' }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Foto Diri :</label><br>
                                                <img src="{{ url('photo/member/'.$family_member->member_belongs->photo) }}" alt="Image" width="170px" height="150px"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 m-b-10px">
                                            <div class="form-group">
                                                <label class="form-control-label">Nama Panggilan :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->sur_name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Kota / Kabupaten :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->city->name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Status Hidup :</label>
                                                @if($family_member->member_belongs->is_life == 1)
                                                    <input type="text" value="Hidup" disabled class="form-control" required/>
                                                @else
                                                    <input type="text" value="Meninggal" disabled class="form-control" required/>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Jenis Kelamin :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->gender_status }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Status Pernikahan :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->marital->name }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Tahun Kelulusan :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->graduation_year }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">No Telepon :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->phone_number }}" disabled class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Status :</label>
                                                <input type="text" value="{{ $family_member->member_belongs->member_status->name }}" disabled class="form-control" required/>
                                            </div>               
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger float-right w-100" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

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