@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Developer Management</h1>
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
                            <th>Profile PIC</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Website</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="https://www.clker.com//cliparts/f/a/0/c/1434020125875430376profile-hi.png" width="100"/>
                            </td>
                            <td>Name</td>
                            <td>ubisoft@gmail.com</td>
                            <td>Indonesia</td>
                            <td>ubisoft.com</td>
                            <td>Jalan No 15</td>
                            <td>Active</td>
                            <td class="text-center">
                                <a href="{{ url('detail-developer-management') }}"><i class="fa fa-eye fa-lg custom--1"></i></a>
                                <a href="{{ url('edit-developer-management') }}"><i class="fa fa-pencil fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-banned-1"><i class="fa fa-ban fa-lg custom--1"></i></a>
                                <a href="#" data-toggle="modal" data-target="#modal-delete-1"><i class="fa fa-trash fa-lg custom--1"></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



    <!-- Modal Delete -->
    <div id="modal-delete-1" class="modal fade">
        <form method="post" action="{{url('delete-end-user')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Warning</h2>
                        <p>Delete data can't be recovery, are you sure?</p>
                    </div>
                    <input type="hidden" name="id" value="1"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Banned -->
    <div id="modal-banned-1" class="modal fade">
        <form method="post" action="{{url('block-end-user')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Warning</h2>
                        <p>Are you sure?</p>
                    </div>
                    <input type="hidden" name="id" value="1"/>
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

        $("div.toolbar").html('<a class="float-right btn btn-success" href="{{ url('add-developer-management') }}">Tambah</a>');
    });
    </script>
@endsection
