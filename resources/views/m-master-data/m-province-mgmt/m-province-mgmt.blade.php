@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Province Management</h1>
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
                            <th>Nama Provinsi</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['province'] as $province)
                        <tr>
                            <td>{{ $province->no }}</td>
                            <td>{{ $province->name }}</td>
                            <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#modal-detail-province-m-{{ $province->id }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-edit-province-m-{{ $province->id }}"><i class="fa fa-edit fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-province-m-{{ $province->id }}"><i class="fa fa-close fa-lg custom--1"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Tambah -->
<div id="modal-tambah-province-m" class="modal fade">
    <form method="post" action="{{url('master/province/insert')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Tambah Provinsi</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Nama Provinsi *</label>
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

@foreach($data['province'] as $province)
    <!-- Modal Delete -->
    <div id="modal-delete-province-m-{{ $province->id }}" class="modal fade">
        <form method="post" action="{{url('master/province/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Hapus Provinsi</h2>
                        <p>Apakah anda yakin ingin menghapus data?</p>
                    </div>
                    <input type="hidden" name="id" value="{{ $province->id }}"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit-province-m-{{ $province->id }}" class="modal fade">
        <form method="post" action="{{url('master/province/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-body">
                        <h2 class="text-center">Ubah Provinsi</h2>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Nama Provinsi *</label>
                                <input name="name" type="text" value="{{ $province->name }}" class="form-control" required>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $province->id }}"/>
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
    <div id="modal-detail-province-m-{{ $province->id }}" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Detail Provinsi</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Name Provinsi</label>
                            <input name="" disabled type="text" value="{{ $province->name }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Pada:</label>
                            <input name="" disabled type="text" value="{{ $province->created_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Oleh:</label>
                            <input name="" disabled type="text" value="{{ $province->created_by }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Pada:</label>
                            <input name="" disabled type="text" value="{{ $province->updated_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Oleh:</label>
                            <input name="" disabled type="text" value="{{ $province->updated_by }}" class="form-control">
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
        $('#sorting-table').DataTable( {
            "dom": '<"toolbar">frtip',
            "ordering": false,
            "info":     false,
            language: { search: "", searchPlaceholder: "Pencarian"  },
        } );
    
        $("div.toolbar").html('<a class="float-right btn btn-success" href="#" data-toggle="modal" data-target="#modal-tambah-province-m">Tambah</a>');

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