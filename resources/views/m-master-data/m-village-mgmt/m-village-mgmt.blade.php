@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Kelurahan Management</h1>
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
                        <input name="name" id="search-value" type="search" value="" placeholder="Cari Kelurahan" class="form-control">
                    </div>
                    <div class="float-left col-xl-3 col-md-3 col-xs-4 m-b-10px">
                        <button type="button" id="search-button" class="btn btn-primary">Cari</button>
                    </div>
                </div>
                <table id="sorting-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Provinsi</th>
                            <th>Nama Kota</th>
                            <th>Nama Kecamatan</th>
                            <th>Nama Kelurahan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['village'] as $village)
                        <tr>
                            <td>{{ $village->no }}</td>
                            <td>{{ $village->district->city->province->name }}</td>
                            <td>{{ $village->district->city->name }}</td>
                            <td>{{ $village->district->name }}</td>
                            <td>{{ $village->name }}</td>
                            <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#modal-detail-village-m-{{ $village->id }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-edit-village-m-{{ $village->id }}"><i class="fa fa-edit fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-village-m-{{ $village->id }}"><i class="fa fa-close fa-lg custom--1"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfooter>
                        <tr>
                            <td>{{ $data['village']->links() }}</td>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Tambah -->
<div id="modal-tambah-village-m" class="modal fade">
    <form method="post" action="{{url('master/village/insert')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Tambah Kelurahan</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Pilih Provinsi *</label>
                            <select name="" id="province-selected" class="custom-select form-control" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach($data['list_province'] as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Pilih Kota *</label>
                            <select name="" id="city-selected" class="custom-select form-control" disabled required>
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Pilih Kecamatan *</label>
                            <select name="district_id" id="district-selected" class="custom-select form-control" disabled required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Nama Kelurahan *</label>
                            <input name="name" type="text" value="" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>

@foreach($data['village'] as $village)
    <!-- Modal Delete -->
    <div id="modal-delete-village-m-{{ $village->id }}" class="modal fade">
        <form method="post" action="{{url('master/village/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Hapus Kelurahan</h2>
                        <p>Apakah anda yakin ingin menghapus data?</p>
                    </div>
                    <input type="hidden" name="id" value="{{ $village->id }}"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit-village-m-{{ $village->id }}" class="modal fade">
        <form method="post" action="{{url('master/village/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-body">
                        <h2 class="text-center">Ubah Kelurahan</h2>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Pilih Provinsi *</label>
                                <select name="" class="custom-select form-control" readonly>
                                    <option value="">{{ $village->district->city->province->name }}</option>
                                </select>
                            </div>
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Pilih Kota *</label>
                                <select name="" class="custom-select form-control" readonly>
                                    <option value="">{{ $village->district->city->name }}</option>
                                </select>
                            </div>
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Pilih Kecamatan *</label>
                                <select class="custom-select form-control" readonly>
                                    <option value="{{ $village->district_id }}">{{ $village->district->name }}</option>
                                </select>
                                <input type="hidden" name="district_id" value="{{ $village->district_id }}"/>
                            </div>
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Nama Kelurahan *</label>
                                <input name="name" type="text" value="{{ $village->name }}" class="form-control" required>
                            </div>
                            <input type="hidden" name="id" value="{{ $village->id }}"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Detail -->
    <div id="modal-detail-village-m-{{ $village->id }}" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Detail Kelurahan</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-6 m-b-10px">
                            <label class="form-control-label">Name Provinsi</label>
                            <input name="" disabled type="text" value="{{ $village->district->city->province->name }}" class="form-control">
                        </div>
                        <div class="col-xl-12 col-md-6 m-b-10px">
                            <label class="form-control-label">Nama Kota</label>
                            <input name="" disabled type="text" value="{{ $village->district->city->name }}" class="form-control">
                        </div>
                        <div class="col-xl-12 col-md-6 m-b-10px">
                            <label class="form-control-label">Name Kecamatan</label>
                            <input name="" disabled type="text" value="{{ $village->district->name }}" class="form-control">
                        </div>
                        <div class="col-xl-12 col-md-6 m-b-10px">
                            <label class="form-control-label">Nama Kelurahan</label>
                            <input name="" disabled type="text" value="{{ $village->name }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Pada:</label>
                            <input name="" disabled type="text" value="{{ $village->created_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Oleh:</label>
                            <input name="" disabled type="text" value="{{ $village->created_by }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Pada:</label>
                            <input name="" disabled type="text" value="{{ $village->updated_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Oleh:</label>
                            <input name="" disabled type="text" value="{{ $village->updated_by }}" class="form-control">
                        </div>
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
                window.location.href="village";
            } else {
                window.location.href="village?search="+search;
            }
        });

        $('#province-selected').on('change', function() {
            $('#city-selected').empty().append('<option value="">Pilih Kota</option>');
            $.ajax({
                url: "district/get-list-city/"+this.value,
                method: 'get',
                success : function(data) {
                    var parse_data = JSON.parse(data);
                    if(parse_data.length > 0) {
                        $('#city-selected').prop('disabled', false);
                        for(var index in parse_data) {
                            $("#city-selected").append('<option value="'+ parse_data[index].id +'">'+ parse_data[index].name +'</option>');
                        }
                    } else {
                        $('#city-selected').prop('disabled', true);
                    }
                },
                error : function(err){
                    $('#city-selected').prop('disabled', true);
                }
            });
        });

        $('#city-selected').on('change', function() {
            $('#district-selected').empty().append('<option value="">Pilih Kecamatan</option>');
            $.ajax({
                url: "village/get-list-district/"+this.value,
                method: 'get',
                success : function(data) {
                    var parse_data = JSON.parse(data);
                    if(parse_data.length > 0) {
                        $('#district-selected').prop('disabled', false);
                        for(var index in parse_data) {
                            $("#district-selected").append('<option value="'+ parse_data[index].id +'">'+ parse_data[index].name +'</option>');
                        }
                    } else {
                        $('#district-selected').prop('disabled', true);
                    }
                },
                error : function(err){
                    $('#district-selected').prop('disabled', true);
                }
            });
        });

        $('#sorting-table').DataTable( {
            "dom": '<"toolbar">frtip',
            "ordering": false,
            "info":     false,
            "paging":     false,
            "searching":     false,
        } );
    
        $("div.toolbar").html('<a class="float-right btn btn-success" href="#" data-toggle="modal" data-target="#modal-tambah-village-m">Tambah</a>');

        var alert = $('div.alert[auto-close]');
        alert.each(function() {
            var that = $(this);
            var time_period = that.attr('auto-close');
            setTimeout(function() {
                that.alert('close');
            }, time_period);
        });
    });
    </script>
@endsection