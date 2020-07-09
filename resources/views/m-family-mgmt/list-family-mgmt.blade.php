@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Family Management</h1>
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
                <div class="row">
                    <div class="float-left col-xl-3 col-md-3 col-xs-8 m-b-10px">
                        <input name="name" id="search-value" type="search" value="" placeholder="Cari No KK" class="form-control">
                    </div>
                    <div class="float-left col-xl-3 col-md-3 col-xs-4 m-b-10px">
                        <button type="button" id="search-button" class="btn btn-primary">Cari</button>
                    </div>
                </div>
                <table id="sorting-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No KK</th>
                            <th>Kepala Keluarga</th>
                            <th>Kota</th>
                            <th>No. TLP</th>
                            <th>Kelengkapan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['family'] as $family)
                        <tr>
                            <td>{{ $family->no }}</td>
                            <td>{{ $family->family_no }}</td>
                            <td>{{ $family->kepala_keluarga }}</td>
                            <td>{{ $family->city->name }}</td>
                            <td>{{ $family->tlp_no }}</td>
                            <td>{{ $family->percentage_fill }} %</td>
                            <td class="text-center">
                                <a href="{{ url('family-management/edit/family/'.$family->id) }}"><i class="fa fa-pencil fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-detail-family-{{ $family->id }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                                <a href="{{ url('family-management/edit/'.$family->id) }}"><i class="fa fa-edit fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-family-{{ $family->id }}"><i class="fa fa-close fa-lg custom--1"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfooter>
                        <tr>
                            <td>{{ $data['family']->links() }}</td>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>
    </div>

</div>

@foreach($data['family'] as $family)
    <!-- Modal Delete -->
    <div id="modal-delete-family-{{ $family->id }}" class="modal fade">
        <form method="post" action="{{url('family-management/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Hapus Keluarga</h2>
                        <p>Apakah anda yakin ingin menghapus data?</p>
                    </div>
                    <input type="hidden" name="id" value="{{ $family->id }}"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Detail -->
    <div id="modal-detail-family-{{ $family->id }}" class="modal fade">
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
                                            <label class="form-control-label">No KK :</label>
                                            <input type="text" name="family_no" value="{{ $family->family_no }}" disabled class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Kota / Kabupaten :</label>
                                            <input type="text" value="{{ $family->city->name }}" disabled class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Kode POS :</label>
                                            <input type="text" name="post_code" value="{{ $family->post_code }}" disabled class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">No Telp :</label>
                                            <input type="text" name="tlp_no" value="{{ $family->tlp_no }}" disabled class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-4 m-b-10px">
                                        <div class="form-group">
                                            <label class="form-control-label">No KK Induk :</label>
                                            <input type="text" name="inherit_no" value="{{ $family->inherit_no }}" disabled class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Kecamatan :</label>
                                            <input type="text" value="{{ $family->district->name }}" disabled class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Alamat :</label>
                                            <textarea type="text" name="address_master" value="{{ $family->address }}" disabled class="form-control" rows="5" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-4 m-b-10px">
                                        <div class="form-group">
                                            <label class="form-control-label">Provinsi :</label>
                                            <input type="text" value="{{ $family->province->name }}" disabled class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Kelurahan / Desa :</label>
                                            <input type="text" value="{{ $family->village->name }}" disabled class="form-control" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Foto Keluarga :</label><br>
                                            <img src="{{ url('photo/kk/'.$family->photo) }}" alt="Image" width="170px" height="150px"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($family->member as $member)
                            @if(isset($member))
                                <div class="col-md-12 element">
                                    <div class="box-pencarian-family-tree" style=" background: #fff; ">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4 m-b-10px">
                                                <div class="form-group">
                                                    <label class="form-control-label">NIK :</label>
                                                    <input type="text" value="{{ $member->nik }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Tanggal Lahir :</label>
                                                    <input type="date" value="{{ $member->birthday }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Kecamatan :</label>
                                                    <input type="text" value="{{ $member->district->name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Jenis Pekerjaan :</label>
                                                    <input type="text" value="{{ isset($member->job) ? $member->job->name : '-' }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Pendidikan Terakhir :</label>
                                                    <input type="text" value="{{ isset($member->education) ? $member->education->name : '-' }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Suku :</label>
                                                    <input type="text" value="{{ isset($member->ethnic) ? $member->ethnic->name : '-' }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Alamat :</label>
                                                    <textarea type="text" name="address" class="form-control" rows="5" disabled required>{{ $member->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 m-b-10px">
                                                <div class="form-group">
                                                    <label class="form-control-label">Nama Lengkap :</label>
                                                    <input type="text" value="{{ $member->full_name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Provinsi :</label>
                                                    <input type="text" value="{{ $member->province->name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Kelurahan / Desa :</label>
                                                    <input type="text" value="{{ $member->village->name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Nama Instansi/Usaha :</label>
                                                    <input type="text" value="{{ $member->instance_name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Nama Sekolah :</label>
                                                    <input type="text" value="{{ $member->school_name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Gelar Adat :</label>
                                                    <input type="text" value="{{ isset($member->title_adat) ? $member->title_adat->name : '-' }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Foto Diri :</label><br>
                                                    <img src="{{ url('photo/member/'.$member->photo) }}" onerror="this.src='{{ url('assets/global/img/no-profile.jpg') }}'" alt="Image" width="170px" height="150px"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 m-b-10px">
                                                <div class="form-group">
                                                    <label class="form-control-label">Nama Panggilan :</label>
                                                    <input type="text" value="{{ $member->sur_name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Kota / Kabupaten :</label>
                                                    <input type="text" value="{{ $member->city->name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Status Hidup :</label>
                                                    @if($member->is_life == 1)
                                                        <input type="text" value="Hidup" disabled class="form-control" required/>
                                                    @else
                                                        <input type="text" value="Meninggal" disabled class="form-control" required/>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Jenis Kelamin :</label>
                                                    <input type="text" value="{{ $member->gender_status }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Status Pernikahan :</label>
                                                    <input type="text" value="{{ $member->marital->name }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Tahun Kelulusan :</label>
                                                    <input type="text" value="{{ $member->graduation_year }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">No Telepon :</label>
                                                    <input type="text" value="{{ $member->phone_number }}" disabled class="form-control" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label">Status :</label>
                                                    <input type="text" value="{{ $member->member_status->name }}" disabled class="form-control" required/>
                                                </div>               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-right w-100" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

@section('myscript')

    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}"></script>
    <script>   
    $(function () {
        $('#search-button').click(function(){
            var search = $('#search-value').val();
            if (search == null || search == ""){
                window.location.href="family-management";
            } else {
                window.location.href="family-management?search="+search;
            }
        });
        $('#sorting-table').DataTable( {
            "dom": '<"toolbar">frtip',
            "ordering": false,
            "info":     false,
            "paging":     false,
            "searching":     false,
        } );
    
        $("div.toolbar").html('<a class="float-right btn btn-success" href="/iws/public/family-management/add">Tambah</a>');
    });
    </script>
@endsection