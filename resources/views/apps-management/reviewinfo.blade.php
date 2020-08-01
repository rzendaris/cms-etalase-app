@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="text-center">
            <h2>2024</h2>
            <h4>Game - Feedbacks</h4>
            <h2>4.5 <i class="fa fa-star"></i></h2>
            <h4>102 Feedbacks</h4>
        </div>
    </div>
    <hr>
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
                            <th>User Name</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Comment At</th>
                            <th>Reply</th>
                            <th>Reply At</th>
                            <th>Version</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>1</td>
                            <td><a href="#">fulan@gmail.com</a></td>
                            <td>4</td>
                            <td>Bagus</td>
                            <td>12/12/2020 10:10</td>
                            <td>Terima Kasih</td>
                            <td>12/12/2020 13:00</td>
                            <td>1.0.0</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a href="#">fulan@gmail.com</a></td>
                            <td>4</td>
                            <td>Bagus</td>
                            <td>12/12/2020 10:10</td>
                            <td>Terima Kasih</td>
                            <td>12/12/2020 13:00</td>
                            <td>1.0.0</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

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
