@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Gelar Adat Management</h1>
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
                            <th>Nama Gelar</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['degree'] as $degree)
                        <tr>
                            <td>{{ $degree->no }}</td>
                            <td>{{ $degree->name }}</td>
                            <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#modal-detail-gelar-m-{{ $degree->id }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-edit-gelar-m-{{ $degree->id }}"><i class="fa fa-edit fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-gelar-m-{{ $degree->id }}"><i class="fa fa-close fa-lg custom--1"></i></a>
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
<div id="modal-tambah-gelar-m" class="modal fade">
    <form method="post" action="{{url('master/degree/insert')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Tambah Gelar</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Nama Gelar *</label>
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

@foreach($data['degree'] as $degree)
    <!-- Modal Delete -->
    <div id="modal-delete-gelar-m-{{ $degree->id }}" class="modal fade">
        <form method="post" action="{{url('master/degree/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Hapus Gelar</h2>
                        <p>Apakah anda yakin ingin menghapus data?</p>
                    </div>
                    <input type="hidden" name="id" value="{{ $degree->id }}"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit-gelar-m-{{ $degree->id }}" class="modal fade">
        <form method="post" action="{{url('master/degree/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-body">
                        <h2 class="text-center">Ubah Gelar</h2>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Nama Gelar *</label>
                                <input name="name" type="text" value="{{ $degree->name }}" class="form-control" required>
                            </div>
                            <input type="hidden" name="id" value="{{ $degree->id }}"/>
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
    <div id="modal-detail-gelar-m-{{ $degree->id }}" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Detail Gelar</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Name Gelar</label>
                            <input name="" disabled type="text" value="{{ $degree->name }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Pada:</label>
                            <input name="" disabled type="text" value="{{ $degree->created_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Oleh:</label>
                            <input name="" disabled type="text" value="{{ $degree->created_by }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Pada:</label>
                            <input name="" disabled type="text" value="{{ $degree->updated_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Oleh:</label>
                            <input name="" disabled type="text" value="{{ $degree->updated_by }}" class="form-control">
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
    
        $("div.toolbar").html('<a class="float-right btn btn-success" href="#" data-toggle="modal" data-target="#modal-tambah-gelar-m">Tambah</a>');

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