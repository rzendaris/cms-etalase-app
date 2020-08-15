@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
<!-- INSERT INTO `apps`(`id`, `name`, `type`, `app_icon`, `sdk_target_id`, `category_id`, `rate`, `version`, `file_size`, `description`, `updates_description`, `link`, `apk_file`, `expansion_file`, `developer_id`, `is_approve`, `is_active`, `is_partnership`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES (2,'App2','Game','app2.png',1,1,0,'1.0','2000','test app2','testing apps2','www.apps.com','app2.apk','aa',33,0,1,0,'2020-08-01 13:08:00','admin','2020-08-01 13:08:00','') -->
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
            <h1>Apps Management </h1>
        </div>
        <!-- <a class="float-right btn btn-success pull-right" href="{{ url('partnership-apps-management') }}">Partnership Apps <i class="fa fa-external-link fa-lg"></i></a> -->
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">

            <div class="tab-content">
                <div id="released" class="tab-pane fade in active">

                    <div class="table-responsive custom--2">
                        <div class="row custom-position-header">
                            <div class="float-left col-xl-3 col-md-3 col-xs-8 m-b-10px">
                                <input name="name" id="search-value" type="search" value="" placeholder="Search" class="form-control">
                            </div>
                            <div class="float-left col-xl-3 col-md-3 col-xs-4 m-b-10px">
                                <button type="button" id="search-button" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                        <!-- table -->
                    </div>
                    <br>
                    <br>
                    <h2>halaman developer apps-management</h2>

                </div>
            </div>
        </div>
    </div>

</div>



    @foreach($data['apps'] as $apps)
    <!-- Modal Delete -->
    <div id="modal-delete-{{$apps->id}}" class="modal fade">
        <form method="post" action="{{url('delete-apps')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Warning</h2>
                        <p>Delete data can't be recovery, are you sure?</p>
                    </div>
                    <input type="hidden" name="id" value="{{ $apps->id }}"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal Banned -->
    <div id="modal-banned-{{$apps->id}}" class="modal fade">
        <form method="post" action="{{url('block-apps')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Warning</h2>
                        <p>Are you sure?</p>
                    </div>
                    <input type="hidden" name="id" value="{{ $apps->id }}"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="modal-unbanned-{{$apps->id}}" class="modal fade">
        <form method="post" action="{{url('unblock-apps')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Warning</h2>
                        <p>Are you sure?</p>
                    </div>
                    <input type="hidden" name="id" value="{{ $apps->id }}"/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
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

        $("div.toolbar").html('<a class="float-right btn btn-success" href="{{ url('add-app') }}">Tambah</a>');
    });
    </script>
@endsection
