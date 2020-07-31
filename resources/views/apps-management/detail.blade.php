@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <div class="page-head">
        <div class="page-title">
            <h1>Apps Detail</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 element">
            <div class="box-pencarian-family-tree" style=" background: #fff; ">
                <div class="row">
                    <div class="col-xl-2 col-md-2 m-b-10px">
                        <div class="form-group">
                            <img id="blah2" style="margin-bottom:5px;border:solid 1px #c2cad8;" width="150" height="150" src="https://image.shutterstock.com/image-vector/male-silhouette-avatar-profile-picture-260nw-199246382.jpg" /><br>
                            <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" style=" width: 99%; border: solid 1px #c2cbd8; ">
                        </div>
                        <div class="form-group text-center">
                            <h1>4.5 <i class="fa fa-star"></i></h1>
                        </div>
                        <div class="form-group">
                            <a href="{{ url('review-info') }}" class="btn btn-primary" style="width:100%;"><i class="fa fa-star"></i> Review Info</a>
                        </div>
                        <div class="form-group">
                            <a href="{{ url('#') }}" class="btn btn-primary" style="width:100%;"><i class="fa fa-play"></i> Google Play</a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-md-10 m-b-10px">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama :</label>
                                    <input type="text" name="full_name" value="Loremp" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Category :</label>
                                    <input type="text" name="category" value="Game" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">SDK Target :</label>
                                    <input type="text" name="sdk" value="Android 9.0 (SDK 25)" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">File Size :</label>
                                    <input type="text" name="file_size" value="80 MB" class="form-control" disabled/>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Type :</label>
                                    <input type="text" name="type" value="Tipe" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Rate :</label>
                                    <input type="text" name="rate" value="3+" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Version :</label>
                                    <input type="text" name="type" value="Beta 1.0.0" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Last Update :</label>
                                    <input type="text" name="rate" value="10/10/2020" class="form-control" disabled/>
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
    <br>
    <div class="row">
        <div class="col-xl-2 col-md-2 m-b-10px">
            <div class="form-group">
                <img id="blah2" style="margin-bottom:5px;border:solid 1px #c2cad8;" width="150" height="150" src="https://image.shutterstock.com/image-vector/male-silhouette-avatar-profile-picture-260nw-199246382.jpg" /><br>
                <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" style=" width: 99%; border: solid 1px #c2cbd8; ">
            </div>
            <div class="form-group">
                <a href="{{ url('profile') }}" class="btn btn-primary" style="width:100%;"><i class="fa fa-user"></i> Profile</a>
            </div>
        </div>
        <div class="col-xl-5 col-md-5 m-b-10px">
            <div class="form-group">
                <label class="form-control-label">Nama :</label>
                <input type="text" name="full_name" value="Developer 1" class="form-control" disabled/>
            </div>
            <div class="form-group">
                <label class="form-control-label">Website :</label>
                <input type="text" name="email" value="google.com" class="form-control" disabled/>
            </div>
            <div class="form-group">
                <label class="control-label">Address :</label>
                <textarea class="textarea-register form-control" rows="5" disabled>Tidak ada</textarea>
            </div>
        </div>
        <div class="col-xl-5 col-md-5 m-b-10px">
            <div class="form-group">
                <label class="form-control-label">Email :</label>
                <input type="text" name="full_name" value="Developer@gmail.com" class="form-control" disabled/>
            </div>
            <div class="form-group">
                <label class="form-control-label">Country :</label>
                <input type="text" name="" value="Indonesia" class="form-control" disabled/>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xl-12 col-md-12 m-b-10px text-right">
            <a href="{{ url('apps-management') }}" class="btn btn-danger pull-left">Back</a>
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
