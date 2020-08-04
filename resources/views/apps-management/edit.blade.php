@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="content-body-white">
    <form method="post" action="{{url('update-apps-management')}}" enctype="multipart/form-data">
          {{csrf_field()}}
        <div class="page-head">
            <div class="page-title">
                <h1>Edit Apps</h1>
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
                                    <input id="upload-img-2" name="photo" type="file" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" style=" width: 99%; border: solid 1px #c2cbd8; ">
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
                                          <input type="text" name="name"  value="{{ $data['apps']->name }}" class="form-control"/>
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label">Category :</label>
                                          <select class="form-control" name="category">
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
                                          <input type="text" class="form-control" name="eu_sdk_version" value="{{ $data['apps']->eu_sdk_version }}" disabled>
                                      
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label">File Size :</label>
                                          <input type="text" name="file_size" value="{{ $data['apps']->file_size }}" class="form-control"/>
                                      </div>
                                  </div>
                                  <div class="col-xl-6 col-md-6 m-b-10px">
                                      <div class="form-group">
                                          <label class="form-control-label">Type :</label>
                                          <select class="form-control" name="type">
                                              <option value="Games">Games</option>
                                              <option value="Hiburan">Hiburan</option>
                                              <option value="Musik">Musik</option>
                                          </select>
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label">Rate :</label>
                                          <input type="text" name="rate" value="{{ $data['apps']->rate }}" class="form-control"/>
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label">Version :</label>
                                          <input type="text" name="version" value="{{ $data['apps']->version }}" class="form-control"/>
                                      </div>
                                      <div class="form-group">
                                          <label class="form-control-label">Last Update :</label>
                                          <input type="text" name="updated_at" value="{{ $data['apps']->updated_at }}" class="form-control"/>
                                      </div>
                                  </div>
                                  <div class="col-md-12 col-xl-12 m-b-10px">
                                      <div class="form-group">
                                          <label class="form-control-label">Google Play Link :</label>
                                          <input type="text" name="link" value="" class="form-control" />
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label">Description :</label>
                                          <textarea class="textarea-register form-control" name="description" rows="5">{{ $data['apps']->description }}</textarea>
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label">New Update Description :</label>
                                          <textarea class="textarea-register form-control" name="updates_description" rows="5">{{ $data['apps']->updates_description }}</textarea>
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
                    <input type="submit" class="btn btn-primary" value="Save">
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
