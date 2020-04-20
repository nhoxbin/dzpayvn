@extends('layouts.app')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="banner">
        <img src="https://i.imgur.com/PYutaNd.png">
        <div class="conten_banner">
            Ví điện tử DzPayVn<br>
            Đổi thẻ cào thành tiền mặt<br>
            Bắn tiền trong sim thành tiền mặt
        </div>
    </div>
    <div class="reg_lg">
        <a class="col-md-6 col-sm-6 col-xs-6 btn_reg" href="{{ route('register') }}">
            <div class="row">
                Đăng ký
            </div>
        </a>
        <a class="col-md-6 col-sm-6 col-xs-6 btn_login" href="{{ route('login') }}">
            <div class="row">
                Đăng nhập
            </div>
        </a>
    </div>
    <div class="clearfix"></div>
    <div class="conten_home">
        <h3 class="text-center">ĐA DẠNG TIỆN ÍCH</h3>
        <div class="conten_df">
            Ví DZpayVN Hỗ Trợ Nạp tiền vào tài khoản qua Momo, Thẻ Cào, Tài khoản chính của sim ! Hỗ Trợ rút về Momo Và Tất cả Các Ngân Hàng VN!
        </div>
    </div>
    <div class="list_item pdtop20">
        <div class="panel">
            <div class="panel-footer">
                <div class="icon_left pull-left">
                    <img class="width100" src="https://i.imgur.com/SOYaRt5.png">
                </div>
                <div class="pull-left conten_ft_home">Nạp Tiền từ tài khoản chính Điện Thoại</div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="icon_left pull-left">
                    <img class="width100" src="{{ asset('https://i.imgur.com/obHhDFv.png') }}">
                </div>
                <div class="pull-left conten_ft_home">Nạp tiền bằng thẻ cào điện thoại</div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-footer">
                <div class="icon_left pull-left">
                    <img class="width100" src="{{ asset('https://i.imgur.com/qLoT1hr.png') }}">
                </div>
                <div class="pull-left conten_ft_home">Rút tiền về tất cả các ngân hàng VN!</div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="icon_left pull-left">
                    <img class="width100" src="https://i.imgur.com/GJPTNK1.png">
                </div>
                <div class="pull-left conten_ft_home">Rút tiền về ví Momo ngay tức thì!</div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-footer">
                <div class="icon_left pull-left">
                    <img class="width100" src="https://i.imgur.com/YG8N2jJ.png">
                </div>
                <div class="pull-left conten_ft_home">Rút tiền về ví Zalo Pay Ngay Tức Thì!</div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('libs/baokim/css/home.css') }}">
@endpush