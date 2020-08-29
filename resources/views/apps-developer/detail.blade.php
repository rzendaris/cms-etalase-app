@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Application Detail</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 element">
            <div class="box-pencarian-family-tree" style=" background: #fff; ">
                <div class="row">
                    <div class="col-xl-2 col-md-2 m-b-10px">
                        <div class="form-group">
                            <img id="blah2" style="margin-bottom:5px;border:solid 1px #c2cad8;" width="100%" height="150" src="#" /><br>
                            <!-- <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" style=" width: 99%; border: solid 1px #c2cbd8; "> -->
                        </div>
                        <div class="form-group text-center">
                            <h2>4.5 <i class="fa fa-star"></i></h2>
                        </div>
                        <div class="form-group">
                            <a href="#" class="btn btn-primary" style="width:100%;"><i class="fa fa-star"></i> Review Info</a>
                        </div>
                        <div class="form-group">
                            <a href="#" class="btn btn-primary" style="width:100%;"><i class="fa fa-play"></i> Google Play</a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-md-10 m-b-10px">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama :</label>
                                    <input type="text" name="full_name"  value="" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Category :</label>
                                    <input type="text" name="category"  class="form-control" value="" disabled/>
                                </div>
                                <div class="form-group">
                                  <div class="row">
                                      <div class="col-md-12">
                                        <label class="form-control-label">SDK Target : </label>
                                        <input type="text" class="form-control" name="eu_sdk_version" value="" readonly>
                                      </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">File Size :</label>
                                    <input type="text" name="file_size" value="" class="form-control" disabled/>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Type :</label>
                                    <input type="text" name="type" value="" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Rate :</label>
                                    <input type="text" name="rate" value="" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Version :</label>
                                    <input type="text" name="type" value="" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Last Update :</label>
                                    <input type="text" name="rate" value="" class="form-control" disabled/>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-12 m-b-10px">
                                <div class="form-group">
                                    <label class="control-label">Description :</label>
                                    <textarea class="textarea-register form-control" rows="5" disabled></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">New Update Description :</label>
                                    <textarea class="textarea-register form-control" rows="5" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12 m-b-10px text-right">
            <a href="{{ url('apps-developer') }}" class="btn btn-danger pull-left">Back</a>
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
    });
    </script>
@endsection
