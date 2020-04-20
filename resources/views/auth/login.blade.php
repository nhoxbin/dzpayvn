@extends('layouts.app')
@section('title', 'Đăng nhập')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="loginmodal-container">
        <div class="conten_login">
            <div class="bk-form-login">
                @error('email')
                    <div class="alert alert-danger">
                        <h4>{{ $message }}</h4>
                    </div>
                @enderror
                <form method="POST" action="{{ route('login') }}" accept-charset="UTF-8" id="bk-login">
                    @csrf
                    <div class="col-md-12">
                        <div class="row">
                            <input id="login" required="" autofocus="" autocomplete="off" onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly'); this.blur(); this.focus(); }" name="email" type="text" value="">
                            <label for="login" alt="Số điện thoại / Email" placeholder="Email đăng nhập"></label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <input id="password" required="" autofocus="" autocomplete="off" onfocus="if (this.hasAttribute('readonly')) { this.removeAttribute('readonly'); this.blur(); this.focus();}" name="password" type="password">
                            <label for="password" alt="Mật khẩu của bạn" placeholder="Mật khẩu của bạn"></label>
                        </div>
                    </div>

                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="row">
                                    <input type="submit" name="login" class="login loginmodal-submit pull-left col-md-12" value="Đăng nhập">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bk-loading">
                <img src="{{ asset('libs/baokim/images/loading.gif') }}">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="login-help">
            <div class="pull-left col-md-6">
                Chưa có tài khoản?
                <b><a href="{{ route('register') }}" class="login-register-link">Đăng ký</a></b>
            </div>
            <div class="pull-left col-md-6">
                <span class="pull-left login-register">
                    <img class="log-icon" src="{{ asset('libs/baokim/images/ion-forgot-password.png') }}">
                    <b><a href="#">Quên mật khẩu?</a> soạn ON PASSDZ matkhaumuondoi gửi 8085</b>
                </span>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/login.css') }}">
<style>
.payment-body {
    display: flex;
    align-items: flex-start;
    justify-content: center;
}
.bk-loading{
    text-align: center;
    display: none;
}
</style>
@endpush
@push('script')
<script>
    $('#bk-login').submit(function() {
        $('.bk-form-login').css('display', 'none');
        $('.login-help').css('display', 'none');
        $('.bk-loading').css('display', 'block');
    });
</script>
@endpush