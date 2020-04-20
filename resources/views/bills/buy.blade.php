@extends('layouts.app')
@section('title', 'Mua ' . $game['currency'] . ' game ' . $game['name'])
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        <p id="card-amount-label">Chọn gói muốn mua</p>
        <div class="card-amount-container">
            @foreach($game['packages'] as $package)
                <div class="card-amount-block {{ $loop->iteration%4 === 0 ? 'margin-0' : '' }}" :class="{ active: selectedPackage === {{ $package['id'] }} }" @@click="selectedPackage = {{ $package['id'] }}">
                    <span><font color="red">{{ number_format($package['money']) }}₫</font></span><br />
                    <span>{{ number_format($package['money_in_game']) . $game['sort_currency'] }}</span>
                </div>
            @endforeach
        </div>

        <input type="text" v-model="info.name_character" required>
        <label for="name_character" alt="Nhập tên nhân vật" placeholder="Nhập tên nhân vật"></label>
        {{-- 0: cần id, 1: cần tk --}}
        @if($game['type'] === 1)
            <input type="text" v-model="info.username" required>
            <label for="username" alt="Nhập username" placeholder="Nhập username"></label>

            <input type="password" v-model="info.password" required>
            <label for="password" alt="Nhập password" placeholder="Nhập password"></label>

            <input type="text" v-model="info.server" required>
            <label for="server" alt="Server" placeholder="Bỏ trống nếu ko cần"></label>

            <select name="account_type" class="form-control" v-model="info.account_type">
                <option value="facebook">Facebook</option>
                <option value="gmail">Gmail</option>
                <option value="twitter">Twitter</option>
                <option value="garena">Garena</option>
                <option value="vtc">VTC</option>
            </select>
            <br />
            <textarea class="form-control" placeholder="Mã xác thực (nếu có) mỗi mã 1 dòng. Nếu quý khách dùng tài khoản twitter để đăng nhập game vui lòng cung cấp sđt acc tại đây" cols="30" rows="5" v-model="info.code"></textarea>

            <a href="https://www.youtube.com/watch?v=Yn5_fFsLRvM" class="btn btn-info" target="_blank">Hướng dẫn lấy code Facebook</a>
            <a href="http://thuthuat.taimienphi.vn/kich-hoat-bao-mat-2-lop-cho-gmail-2590n.aspx" class="btn btn-info" target="_blank">Hướng dẫn lấy code Gmail</a>
        @else
            <input type="text" v-model="info.id" required>
            <label for="id" alt="Nhập ID nhân vật" placeholder="Nhập ID nhân vật"></label>
        @endif
        <div class="clearfix"></div>

        <div class="input-block">
            <button type="button" class="buy-btn btn btn-green" @@click="buy">Mua</button>
        </div>
        <div id="loading-icon" style="display: none;"><center><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></center></div>
    </div>
</div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/phone-topup.css') }}">
    <style>
        div.card-amount-container .active {
            border: 1px solid #000;
        }

        .buy-btn {
            width: 100%;
            margin-top: 20px;
        }

        .input-block {
            padding-left: 0;
            padding-right: 0;
        }

        .input-block:not(:last-child) {
            margin-bottom: 10px;
        }

        #loading-icon {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0,0,0,0.2);
            z-index: 99999;
            text-align: center;
            display: none;
            font-size: 3em;
        }
    </style>
@endpush
@push('script')
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: function() {
            return {
                selectedPackage: {{ array_column($game['packages'], 'id')[0] }},
                info: {
                    name_character: '',
                    id: null,
                    username: '',
                    password: '',
                    account_type: 'facebook',
                    code: '',
                    server: ''
                }
            }
        },
        methods: {
            buy() {
                $('#amount-loading').show();
                $.ajax({
                    url: route('game.buy.store', {{ $game['id'] }}),
                    method: 'post',
                    data: {
                        package: this.selectedPackage,
                        info: this.info
                    },
                    success: function(resp) {
                        alert(resp);
                    },
                    error: function(resp) {
                        alert(resp.responseText);
                    }
                }).done(function() {
                    location.href = route('dashboard');
                });
            }
        }
    });
</script>
@endpush