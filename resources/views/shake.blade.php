@extends('layouts.app')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="box-blue"></div>
    <div class="wallet-container">
        <div class="row">
            <div class="col-sm-6 col-xs-4">Số dư</div>
            <div class="col-sm-6 col-xs-8 text-right">@{{ cash | number_format }}</div>
        </div>
        <div class="row">
            <div class="col-xs-6">ID của bạn</div>
            <div class="col-xs-6 text-right">{{ Auth::id() }}</div>
        </div>
    </div>
    <div class="wallet-tool-container">
        <div class="row">
            <div class="col-xs-4">
                <a href="{{ route('recharge.create') }}">
                    <div class="tool-icon">
                    <img src="{{ asset('libs/baokim/images/wallet-db-03.svg') }}">
                    </div>
                    <span class="tool-text">Nạp tiền</span>
                </a>
            </div>
            <div class="col-xs-4">
                <a href="{{ route('transfer.create') }}">
                    <div class="tool-icon custom-tool-icon" style="padding-top: 19px">
                        <img src="{{ asset('libs/baokim/images/wallet-db-04.svg') }}">
                    </div>
                    <span class="tool-text">Chuyển tiền</span>
                </a>
            </div>
            <div class="col-xs-4">
                <a href="https://www.youtube.com/watch?v=sBXUfXtyjBE" target="_blank">
                    <div class="tool-icon">
                    <img src="{{ asset('libs/baokim/images/wallet-db-02.svg') }}">
                    </div>
                    <span class="tool-text">Hướng dẫn</span>
                </a>
            </div>
        </div>
    </div>
    <br />
    <div class="function-container justify-content-center">
        <img style="max-height: 100%" src="https://i.imgur.com/9HYi3zE.png">
        <div class="center" style="margin-bottom: 30px">
            <h3 style="font-size:28px; color: red; font-weight: 600">Trong Hũ Vàng Có <span style="color: #00CC00;font-size: 26px;">@{{ crate | number_format }}</span></h3>
        </div>
        <br />
        <button type="button" class="btn btn-danger btn-circle btn-xl" @@click="shake"><i class="fa fa-heart"></i> Chơi</button>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/dashboard.css') }}">
<style>
    .btn-circle.btn-xl { 
        width: 50%; 
        padding: 10px 16px;
        border-radius: 35px;
        font-size: 12px;
        text-align: center;
        margin-top: 10px;
    }

    .justify-content-center {
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@push('script')
<script>
    new Vue({
        el: '#app',
        data: function() {
            return {
                crate: {{ $crate->amount }},
                cash: {{ Auth::user()->cash }}
            }
        },
        filters: {
            number_format(value) {
                return (new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value));
            }
        },
        methods: {
            shake() {
                if (!confirm('Mỗi lượt lắc sẽ bị trừ 10.000đ. Bạn chơi chứ?')) {
                    return;
                }
                var self = this;
                $.post(route('shake.store'))
                    .then(function(resp) {
                        Swal.fire({
                          title: 'Chúc mừng!!!',
                          html: resp.msg,
                          icon: 'success',
                          confirmButtonText: 'Ố Kề'
                        })
                        // response immediately with user
                        self.cash -= 10000;
                        self.cash += parseInt(resp.bounty);
                        self.crate += parseInt(resp.bounty);
                    }).fail(function(resp) {
                        Swal.fire({
                          title: 'Có lỗi xảy ra!',
                          text: 'Vui lòng thực hiện lại!',
                          icon: 'error',
                          confirmButtonText: 'OK'
                        })
                    })
            }
        }
    })
</script>
@endpush