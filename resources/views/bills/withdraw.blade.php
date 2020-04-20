@extends('layouts.app')

@section('title', 'Rút tiền')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        @include('_errors')

        <form action="{{ route('withdraw.store') }}" method="post">
            @csrf

            <select name="withdraw_type" class="form-control" v-model="withdraw_type">
                <option value="bank">Ngân hàng</option>
                <option value="momo">Momo</option>
                <option value="zalopay">ZaloPay</option>
            </select><br />

            <div v-if="withdraw_type === 'bank'">
                <input type="text" name="bank_name" value="{{ old('bank_name') }}" required>
                <label for="bank_name" alt="Tên ngân hàng" placeholder="Nhập tên ngân hàng"></label>

                <input type="text" name="branch" value="{{ old('branch') }}" required>
                <label for="branch" alt="Chi nhánh" placeholder="Nhập chi nhánh"></label>
                
                <input type="text" name="stk" value="{{ old('stk') }}" required>
                <label for="stk" alt="Số tài khoản" placeholder="Nhập số tài khoản"></label>

                <input type="text" name="master_name" value="{{ old('master_name', Auth::user()->name) }}" required>
                <label for="master_name" alt="Tên chủ tài khoản" placeholder="Nhập tên chủ tài khoản"></label>
            </div>
            
            <div v-else>
                <input type="text" name="phone_number" value="{{ old('phone_number', '0'.Auth::user()->phone) }}" required>
                <label for="phone_number" alt="Số điện thoại" placeholder="Nhập số điện thoại"></label>

                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                <label for="name" alt="Họ và tên" placeholder="Nhập họ và tên"></label>
            </div>

            <input type="text" name="money" v-model="money" required>
            <label for="money" alt="Số tiền" placeholder="Nhập số tiền"></label>

            <div class="alert alert-success">
                <ul>
                    <li>Số tiền: @{{ money | currency }}</li>
                    <li v-if="withdraw_type === 'bank'">Phí giao dịch: @{{ 11000 | currency }} </li>
                    <li>Số tiền còn lại: @{{ (remaining_amount < 0 ? -1 : remaining_amount) | currency }}</li>
                </ul>
            </div>

            <input type="password" name="password" required>
            <label for="password" alt="Password" placeholder="Nhập password xác nhận"></label>

            <div class="input-block">

            <button type="submit" class="buy-btn btn btn-green">Xác nhận</button>
            </div>
        </form>
        
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

        .input-block {
            text-align: end;
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
<script>
    new Vue({
        el: '#app',
        data: function() {
            return {
                money: {{ old('money', 200000) }},
                real_money: {{ Auth::user()->cash }},
                withdraw_type: 'bank'
            }
        },
        computed: {
            remaining_amount() {
                return this.real_money - this.money - (this.withdraw_type === 'bank' ? 11000 : 0);
            }
        },
        filters: {
            currency(val) {
                return (new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'})).format(val);
            }
        },
        methods: {

        }
    })
</script>
@endpush