@extends('panel.master')

@section('css')

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://www.jqueryscript.net/demo/Multi-file-Image-Uploader-Plugin-With-jQuery-Image-Uploader/dist/styles.imageuploader.css" rel="stylesheet">

@endsection

@section('content')

<div class="content-body-white">
    <form method="post" action="{{url('#')}}" enctype="multipart/form-data">
          {{csrf_field()}}
        <div class="page-head">
            <div class="page-title">
                <h1>Upload Media</h1>
            </div>
        </div>
        <div class="wrapper">
            <div class="row">
              @if(session()->has('err_message'))
                  <div class="alert alert-danger alert-dismissible" role="alert" auto-close="10000">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {{ session()->get('err_message') }}
                  </div>
              @endif
              @if(session()->has('succ_message'))
                  <div class="alert alert-success alert-dismissible" role="alert" auto-close="10000">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {{ session()->get('succ_message') }}
                  </div>
              @endif
                <div class="col-md-12 element">
                    <div class="box-pencarian-family-tree" style=" background: #fff; ">
                        <br>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 m-b-10px">
                                <div class="form-group">
                                    <div class="uploader__box js-uploader__box l-center-box">
                                        <div class="uploader__contents">
                                            <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="text-danger text-center">Max. total file size 10 MB</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-md-12 m-b-10px text-right">
                    <a href="{{ url('apps-management') }}" class="btn btn-danger pull-left">Cancel</a>
                    <!-- <input type="submit" class="btn btn-primary" value="Save"> -->
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('myscript')

    <script src="{{ asset('assets/global/plugins/select2/js/select2.min.js') }}"></script>
    <script src="https://www.jqueryscript.net/demo/Multi-file-Image-Uploader-Plugin-With-jQuery-Image-Uploader/dist/jquery.imageuploader.js"></script>
    <script src="{{ asset('js/add-family.js') }}"></script>
    <script>
        $('[type=tel]').on('change', function(e) {
            $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
        });
        $('[type=tel]').on('keypress', function(e) {
            keys = ['0','1','2','3','4','5','6','7','8','9','.']
            return keys.indexOf(event.key) > -1
        });
        (function(){
            var options = {
                submitButtonCopy:'Upload Files',
                instructionsCopy:'Drag and Drop, or',
                furtherInstructionsCopy:'',
                selectButtonCopy:'Select Files',
                secondarySelectButtonCopy:'Pilih File Lainnya...',
                dropZone: $(this),
                fileTypeWhiteList: ['jpg','png','jpeg','gif','pdf'],
                badFileTypeMessage:'Sorry, we\'re unable to accept this type of file.',
                ajaxUrl:'/ajax/upload',
                testMode:false
            };
            $('.js-uploader__box').uploader(options);
        }());
    </script>
@endsection
