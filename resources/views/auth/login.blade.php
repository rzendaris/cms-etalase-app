@extends('auth.master')

@section('css')
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/pages/css/login-4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<style>
    .login .content .forget-password {margin-top: 10px;}
    div#LoginCaptcha_CaptchaDiv { 
        background: white;
        width: 100%!important;
        padding: 10px!important;
        height: auto!important;
    }
    .login-box-- {
        background: rgba(255, 255, 255, .7);
        border-radius: 10px!important;
        box-shadow: 0 0 10px rgba(51, 51, 51, 0.3);
    }
    .login-box-- .logo-default-login {
        margin:auto;
    }
    #CaptchaCode {
        padding-left: 10px;
    }
    @media (max-width:767px){
        .login .content {
            width:90%;
            margin-bottom: 60px;
        }
        .login .content h3 {
            font-size: 16px;
        }
    }
</style>
<div class="logo">
    <!-- <a href="#">
        <img src="{{ asset('assets/global/img/logo.png') }}" alt="logo-mina-indonesia" width="100"/> 
    </a> -->
</div>
<div class="content login-box--">
    <form class="login-form" method="POST" action="{{ route('login') }}">
    @csrf
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="/" >
                    <img src="{{ asset('assets/global/img/logo.png') }}" alt="" width="100" style="width:190px; height: 110px" class="logo-default-login" />
                </a>
                <h3 class="form-title">Login to your account</h3>
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
            </div>
        </div>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Enter any username and password. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" required autofocus/>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required/> 
            </div>
        </div>
        <div class="form-group{{ $errors->has('CaptchaCode') ? ' has-error' : '' }}">
            <div class="input-icon">
                {!! captcha_image_html('LoginCaptcha') !!}
                <input type="text" class="form-control" name="CaptchaCode" id="CaptchaCode" required>

                @if ($errors->has('CaptchaCode'))
                    <span class="help-block">
                        <strong>{{ $errors->first('CaptchaCode') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-8 col-md-6">
                <div class="forget-password">
                    <a href="{{ url('forgot-password') }}" style="color:#000000"><b> <i class="fa fa-unlock-alt"></i> Lupa Password ? </b></a>
                </div>
            </div>
            <div class="col-xs-4 col-md-6">
                <div class="form-actions">
                    <button type="submit" class="btn green pull-right"> Login </button>
                </div>
            </div>
        </div>
        <br>
    </form>
    <!-- END LOGIN FORM -->
</div>

@endsection

@section('myscript')

    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/login-4.min.js') }}" type="text/javascript"></script>
@endsection