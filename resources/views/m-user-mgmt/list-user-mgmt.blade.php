@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>User Management</h1>
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['user'] as $user)
                        <tr>
                            <td>{{ $user->no }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#modal-detail-user-m-{{ $user-> id }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-edit-user-m-{{ $user-> id }}"><i class="fa fa-edit fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-user-m-{{ $user-> id }}"><i class="fa fa-close fa-lg custom--1"></i></a>
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
<div id="modal-tambah-user-m" class="modal fade">
    <form method="post" action="{{url('user-management-fe/insert')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Tambah User</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Name *</label>
                            <input name="name" type="text" value="" class="form-control" required>
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Email *</label>
                            <input name="email" type="email" value="" class="form-control" required>
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Pilih Role *</label>
                            <select name="role_id" class="custom-select form-control" required>
                                <option value="">Pilih Role</option>
                                @foreach($data['role'] as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Password *</label>
                            <input name="password" type="password" value="" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($data['user'] as $user)
    <!-- Modal Detail -->
    <div id="modal-detail-user-m-{{ $user->id }}" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Detail User</h2>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Name</label>
                            <input name="" disabled type="text" value="{{ $user->name }}" class="form-control">
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Email</label>
                            <input name="" disabled type="text" value="{{ $user->email }}" class="form-control">
                        </div>
                        <div class="col-xl-12 col-md-12 m-b-10px">
                            <label class="form-control-label">Role</label>
                            <input name="" disabled type="text" value="{{ $user->role->name }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Pada:</label>
                            <input name="" disabled type="text" value="{{ $user->created_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Dibuat Oleh:</label>
                            <input name="" disabled type="text" value="{{ $user->created_by }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Pada:</label>
                            <input name="" disabled type="text" value="{{ $user->updated_at }}" class="form-control">
                        </div>
                        <div class="col-xl-6 col-md-6 m-b-10px">
                            <label class="form-control-label">Terakhir Diubah Oleh:</label>
                            <input name="" disabled type="text" value="{{ $user->updated_by }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-right w-100" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete -->
    <div id="modal-delete-user-m-{{ $user->id }}" class="modal fade">
        <form method="post" action="{{url('user-management-fe/delete')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Hapus {{ $user->email }}</h2>
                        <p>Apakah anda yakin ingin menghapus data?</p>
                        <input type="hidden" name="id" value="{{ $user->id }}"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Edit -->
    <div id="modal-edit-user-m-{{ $user->id }}" class="modal fade">
        <form method="post" action="{{url('user-management-fe/update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="text-center">Ubah User</h2>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Name *</label>
                                <input name="name" type="text" value="{{ $user->name }}" class="form-control" required>
                            </div>
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Email *</label>
                                <input name="email" type="text" value="{{ $user->email }}" class="form-control" readonly>
                            </div>
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Pilih Role *</label>
                                <select name="role_id" class="custom-select form-control" required>
                                    <option value="{{ $user->role->id }}">{{ $user->role->name }}</option>
                                    @foreach($data['role'] as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <label class="form-control-label">Password *</label>
                                <input name="password" type="password" value="" class="form-control">
                            </div>
                            <input name="id" type="hidden" value="{{ $user->id }}" class="form-control">
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
    
        $("div.toolbar").html('<a class="float-right btn btn-success" href="#" data-toggle="modal" data-target="#modal-tambah-user-m">Tambah</a>');

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