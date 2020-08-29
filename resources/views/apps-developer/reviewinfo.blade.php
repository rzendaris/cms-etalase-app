@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="text-center">
            <h2>{{ count($data['ratingsall']) }}</h2>
            <h4>{{ $data['apps']->type }} - Feedbacks</h4>
            <h2>{{ $data['avgrating'] }} <i class="fa fa-star"></i></h2>
            <h4>{{ count($data['ratings']) }} Feedbacks</h4>
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
                        @foreach($data['ratings'] as $ratings)
                        <tr>
                            <td>{{ $ratings->no }}</td>
                            <td><a href="#">{{ $ratings->endusers->email }}</a></td>
                            <td>{{ $ratings->ratings }}</td>
                            <td>{{ $ratings->comment }}</td>
                            <td>{{ $ratings->comment_at }}</td>
                            <td>{{ $ratings->reply }}</td>
                            <td>{{ $ratings->reply_at }}</td>
                            <td>{{ $ratings->apps->version }}</td>
                        </tr>
                        @endforeach
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
