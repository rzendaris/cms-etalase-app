@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <form method="post" action="{{url('update-developer-management')}}" enctype="multipart/form-data">
          {{csrf_field()}}
        <div class="page-head">
            <div class="page-title">
                <h1>Approval Apps</h1>
            </div>
        </div>
        <div class="wrapper">
            <div class="row">
                <div class="col-md-12 element">
                    <div class="box-pencarian-family-tree" style=" background: #fff; ">
                    <div class="row">
                      <div class="col-xl-2 col-md-2 m-b-10px">
                          <div class="form-group">
                              <img id="blah2" style="margin-bottom:5px;border:solid 1px #c2cad8;" width="150" height="150" src="{{ url('/apps/'.$data['apps']->app_icon) }}" /><br>
                              <input id="upload-img-2" name="photo" type="file" disabled onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" style=" width: 99%; border: solid 1px #c2cbd8; ">
                          </div>
                          <div class="form-group">
                              <a href="{{ url('review-info') }}" class="btn btn-primary" style="width:100%;"><i class="fa fa-user"></i> Developer</a>
                          </div>
                      </div>
                      <div class="col-xl-10 col-md-10 m-b-10px">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Nama :</label>
                                    <input type="hidden" name="id" value="{{ $data['apps']->id }}">
                                    <input type="text" name="name"  value="{{ $data['apps']->name }}" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Category :</label>
                                    <select class="form-control" name="category" disabled>
                                      @foreach($data['category'] as $get)
                                      @if($data['apps']->category_id == $get->id)
                                              <option value="{{ $get->id}}" selected>{{ $get->name}}</option>
                                      @else
                                              <option value="{{ $get->id}}">{{ $get->name}}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">SDK Target : </label>
                                    <select class="form-control" name="sdk" disabled>
                                      @foreach($data['sdk'] as $get)
                                      @if($data['apps']->sdk_target_id == $get->id)
                                              <option value="{{ $get->id}}" selected>{{ $get->sdk}}</option>
                                      @else
                                              <option value="{{ $get->id}}">{{ $get->sdk}}</option>
                                      @endif
                                      @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">File Size :</label>
                                    <input type="text" name="file_size" value="{{ $data['apps']->file_size }}" class="form-control" disabled/>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Type :</label>
                                    <select class="form-control" name="type" disabled>
                                        <option value="Games">Games</option>
                                        <option value="Hiburan">Hiburan</option>
                                        <option value="Musik">Musik</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Rate :</label>
                                    <input type="text" name="rate" value="{{ $data['apps']->rate }}" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Version :</label>
                                    <input type="text" name="version" value="{{ $data['apps']->version }}" class="form-control" disabled/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Last Update :</label>
                                    <input type="text" name="updated_at" value="{{ $data['apps']->updated_at }}" class="form-control" disabled/>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-12 m-b-10px">
                                <div class="form-group">
                                    <label class="form-control-label">Google Play Link :</label>
                                    <input type="text" name="link" value="" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Description :</label>
                                    <textarea class="textarea-register form-control" name="description" rows="5" disabled>{{ $data['apps']->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">New Update Description :</label>
                                    <textarea class="textarea-register form-control" name="updates_description" rows="5" disabled>{{ $data['apps']->updates_description }}</textarea>
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
                    <a href="{{ url('apps-management') }}" class="btn btn-danger pull-left">Cancel</a>
                    <a href="#" data-toggle="modal" data-target="#modal-rejected" class="btn btn-warning">Rejected</a>
                    <a href="#" data-toggle="modal" data-target="#modal-approve" class="btn btn-success">Approve</a>
                </div>
            </div>
        </div>
    </form>
</div>

    <!-- Modal Rejected -->
    <div id="modal-rejected" class="modal fade">
        <form method="post" action="{{url('rejected-apps')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2 style=" margin: auto; ">Warning</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label class="control-label text-left">Rejected Reason :*</label>
                                    <input type="hidden" name="id" value="{{ $data['apps']->id }}">
                                    <textarea class="textarea-register form-control" name="reaseon" rows="3" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Approve -->
    <div id="modal-approve" class="modal fade">
        <form method="post" action="{{url('approved-apps')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h2>Warning</h2>
                        <p>Are you sure?</p>
                    </div>
                    <input type="hidden" name="id" value="1"/>
                    <div class="modal-footer">
                    <input type="hidden" name="id" value="{{ $data['apps']->id }}">
                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
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
