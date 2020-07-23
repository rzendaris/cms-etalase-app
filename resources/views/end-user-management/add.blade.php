@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <form method="post" action="{{url('#')}}" enctype="multipart/form-data">

        <div class="page-head">
            <div class="page-title">
                <h1>Add End User</h1>
            </div>
        </div>
        <div class="wrapper">
            <div class="row">
                <div class="col-md-12 element">
                    <div class="box-pencarian-family-tree" style=" background: #fff; ">
                        <div class="row">
                            <div class="col-xl-2 col-md-2 m-b-10px">
                                <div class="form-group">
                                    <img id="blah2" style="margin-bottom:5px;border:solid 1px #c2cad8;" width="150" height="150" src="{{ asset('assets/global/img/no-profile.jpg') }}" /><br>
                                    <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" style=" width: 99%; border: solid 1px #c2cbd8; ">
                                </div>
                            </div>
                            <div class="col-xl-5 col-md-5 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama :*</label>
                                    <input type="text" name="full_name" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Email :*</label>
                                    <input type="text" name="email" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Birthday :*</label>
                                    <input type="date" name="website" class="form-control date"/>
                                </div>
                            </div>
                            <div class="col-xl-5 col-md-5 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Password :*</label>
                                    <input type="password" name="Password" class="form-control date"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Re-type Password :*</label>
                                    <input type="password" name="Password" class="form-control date"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Clone In This Div -->
                <div class="results"></div>
                <!-- Clone In This Div -->
            </div>

            <div class="row">
                <div class="col-xl-12 col-md-12 m-b-10px text-right">
                    <a href="{{ url('end-user-management') }}" class="btn btn-danger pull-left">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('myscript')

    <script src="{{ asset('assets/global/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/add-family.js') }}"></script>
    <script>
        $('[type=tel]').on('change', function(e) {
            $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
        });
        $('[type=tel]').on('keypress', function(e) {
            keys = ['0','1','2','3','4','5','6','7','8','9','.']
            return keys.indexOf(event.key) > -1
        });
    </script>
@endsection