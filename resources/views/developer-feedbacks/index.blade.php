@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="text-center">
            <h2>Feedbacks & Reply</h2>
            <h2>4.5 <i class="fa fa-star"></i></h2>
            <h4>1024 - Feedbacks</h4>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">

            <div class="table-responsive custom--2">
                <div class="row custom-position-header">
                    <div class="float-left col-xl-3 col-md-3 col-xs-12 m-b-10px">
                        <input name="name" id="search-value" type="search" value="" placeholder="Search" class="form-control">
                    </div>
                    <div class="float-left col-xl-2 col-md-2 col-xs-12 m-b-10px">
                        <select class="form-control">
                            <option value="2048">2048</option>
                            <option value="2029">2049</option>
                        </select>
                    </div>
                    <div class="float-left col-xl-3 col-md-3 col-xs-12 m-b-10px">
                        <button type="button" id="search-button" class="btn btn-primary">Cari</button>
                    </div>
                </div>
                <table id="sorting-table" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User Name</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Comment At</th>
                            <th>Reply</th>
                            <th>Reply At</th>
                            <th>Version</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><a href="#">fulan1@gmail.com</a></td>
                            <td>4</td>
                            <td>Bagus</td>
                            <td>12/12/2020 12:12</td>
                            <td>Good</td>
                            <td>12/12/2020 20:00</td>
                            <td>1.0.0</td>
                            <td>
                            <a href="#" class="btn" data-toggle="modal" data-target="#modal-reply"><i class="fa fa-reply fa-2x custom--1"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a href="#">fulan2@gmail.com</a></td>
                            <td>5</td>
                            <td>Tanoe</td>
                            <td>12/12/2020 12:12</td>
                            <td>Keren nih aplikasi</td>
                            <td>12/12/2020 20:00</td>
                            <td>1.0.0</td>
                            <td>
                            <a href="#" class="btn" ><i class="fa fa-edit fa-2x custom--1"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<div id="modal-reply" class="modal fade">
    <form method="post" action="#" enctype="multipart/form-data">
      {{csrf_field()}}
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h2 style=" margin: auto; "><i class="fa fa-reply"></i> Reply</h2>
                    <p class="text-left">Message :</p>
                    <textarea class="form-control" rows="4"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Yes</button>
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

        $("div.toolbar").html('<select class="form-control"><option value="all">Semua Rating</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>');
    });
    </script>
@endsection
