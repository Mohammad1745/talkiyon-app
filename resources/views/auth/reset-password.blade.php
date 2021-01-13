@extends('layouts.auth')
@section('title', 'Reset Password - Talkiyon Admin')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endsection
@section('content')
<div id="login-text" style="padding-left:10%">
        <h1 class="fs-80"><span class="fs-100" style="font-weight: bold; color:#00357a; font-family: cursive">T</span><span class="fs-80 text-gray">alkiyon Admin</span></h1>
        <h1 class="login100-form-title-talkiyon-txt p-l-13">A tool to accelerate future </h1>
    </div>
    <div id="login-form">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-l-20 p-r-20 p-t-40 p-b-50">
                    {{Form::open(['route' => 'resetPasswordProcess', 'class' => 'login100-form validate-form'])}}
                        <div class="wrap-input100 validate-input"
                             data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="phone" placeholder="Phone">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" name="code" placeholder="xxxxxx">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>

                        <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="Password">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>

                        <div class="wrap-input100 rs1 validate-input" data-validate="Confirm Password is required">
                            <input class="input100" type="password" name="confirm_password" placeholder="Password">
                            <span class="focus-input100-1"></span>
                            <span class="focus-input100-2"></span>
                        </div>

                        <div class="container-login100-form-btn m-t-20">
                            <button class="login100-form-btn">
                                Confirm
                            </button>
                        </div>

                        <div class="text-center p-b-4 m-t-20">
                                <span class="txt1">
                                    Are you a
                                </span>
                            <a href="https://devf.talkiyon.com" target="_blank" class="txt2 hov1">
                                User?
                            </a>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
