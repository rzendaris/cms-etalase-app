@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
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
    <div class="page-head">
        <div class="page-title">
            <h1>User Management</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            
            <div class="table-responsive custom--2">
                <div class="row custom-position-header">
                    <div class="float-left col-xl-3 col-md-3 col-xs-8 m-b-10px">
                        <input name="name" id="search-value" type="search" value="" placeholder="Search" class="form-control">
                    </div>
                    <div class="float-left col-xl-3 col-md-3 col-xs-4 m-b-10px">
                        <button type="button" id="search-button" class="btn btn-primary">Cari</button>
                    </div>
                </div>
                <table id="sorting-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                            <td>1</td>
                            <td>Fulan</td>
                            <td class="text-center">Fulan@gmail.com</td>
                            <td class="text-right">
                                <a href="#" data-toggle="modal" data-target="#modal-edit-user"><i class="fa fa-pencil fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-reset-user"><i class="fa fa-key fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-user"><i class="fa fa-trash fa-lg custom--1"></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

    <!-- Modal Edit User -->
    <div id="modal-add-user" class="modal fade">
        <form method="post" action="{{url('block-user')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Add User</h2>
                        <br>
                        <div class="form-group text-left">
                            <label class="form-control-label">Name: *</label>
                            <input type="text" name="name" class="form-control" value="" required="">
                        </div>
                        <div class="form-group text-left">
                            <label class="form-control-label">Email: *</label>
                            <input type="text" name="email" class="form-control" value="" required="">
                        </div>
                        <div class="form-group text-left">
                            <label class="form-control-label">Password: *</label>
                            <input type="password" name="password" class="form-control" value="" required="">
                        </div>
                        <div class="form-group text-left">
                            <label class="form-control-label">Re-type Password: *</label>
                            <input type="password" name="password" class="form-control" value="" required="">
                        </div>
                    </div>
                    <input type="hidden" name="id" value=""/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Edit User -->
    <div id="modal-edit-user" class="modal fade">
        <form method="post" action="{{url('block-user')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Edit User</h2>
                        <br>
                        <div class="form-group text-left">
                            <label class="form-control-label">Name: *</label>
                            <input type="text" name="name" class="form-control" value="Fulan" required="">
                        </div>
                        <div class="form-group text-left">
                            <label class="form-control-label">Email: *</label>
                            <input type="text" name="email" class="form-control" value="Fulan@gmail.com" required="">
                        </div>
                    </div>
                    <input type="hidden" name="id" value=""/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Reset -->
    <div id="modal-reset-user" class="modal fade">
        <form method="post" action="{{url('block-user')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Reset Password</h2>
                        <br>
                        <div class="form-group text-left">
                            <label class="form-control-label">Password: *</label>
                            <input type="password" name="password" class="form-control" required="">
                        </div>
                        <div class="form-group text-left">
                            <label class="form-control-label">Re-type Password: *</label>
                            <input type="password" name="password" class="form-control" required="">
                        </div>
                    </div>
                    <input type="hidden" name="id" value=""/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Delete -->
    <div id="modal-delete-user" class="modal fade">
        <form method="post" action="{{url('block-user')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Warning</h2>
                        <p>Are you sure?</p>
                    </div>
                    <input type="hidden" name="id" value=""/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


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

        $("div.toolbar").html('<a class="float-right btn btn-success" data-toggle="modal" data-target="#modal-add-user" href="#">Tambah</a>');
    });
    </script>
@endsection
