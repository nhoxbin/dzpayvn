@extends('layouts.app')

@section('title', 'Nạp, bắn tiền điện thoại')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        @include('_errors')

        <form action="{{ route('shoot_money.store') }}" method="post">
            @csrf

            <input type="hidden" name="sim_name" v-model="selected_sim_name">

            <select name="method" class="form-control" v-model="method">
                <option value="fast">Bắn tiền TKC (Nhanh)</option>
                <option value="slow">Nạp cước (Chậm)</option>
            </select>

            <select name="sim_id" class="form-control" v-model="selected_sim_id">
                <option v-for="sim in sims" :value="sim.id">@{{ sim.name + ' - ' + sim[method+'_discount'] }}</option>
            </select>

            <div v-if="method === 'slow'">
                <select v-if="selected_sim_name === 'viettel'" name="type" class="form-control">
                    <option v-for="type in types" :value="type">@{{ type }}</option>
                </select>
                <select v-else name="type" class="form-control">
                    <option :value="types[0]">@{{ types[0] }}</option>
                    <option :value="types[1]">@{{ types[1] }}</option>
                </select>

                <div v-if="selected_sim_name !== 'vinaphone'">
                    <input type="password" name="password">
                    <label for="password" :alt="lblPassword" :placeholder="lblPassword"></label>
                </div>
            </div>

            <input type="text" name="phone" value="0{{ Auth::user()->phone }}" required>
            <label for="phone" alt="Số điện thoại" placeholder="Nhập số điện thoại"></label>

            <input type="text" name="money" v-model="money" required>
            <label for="money" alt="Số tiền" placeholder="Nhập số tiền"></label>


            <input type="text" class="form-control" :value="currency" disabled>

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
        select {
            margin-bottom: 10px;
        }
    </style>
@endpush

@push('script')
<script>
    new Vue({
        el: '#app',
        data: function() {
            return {
                method: 'fast',
                types: [
                    'Di động - trả trước',
                    'Di động - trả sau',
                    'Homephone',
                    'Mạng hoặc NextTV',
                ],
                money: 10000,
                sims: {!! $sims->toJson() !!},
                selected_sim_id: {!! $sims->first()->toJson() !!}.id,
            }
        },
        computed: {
            selected_sim() {
                return this.sims.find(sim => sim.id === this.selected_sim_id);
            },
            selected_sim_name() {
                return this.selected_sim.name.toLowerCase();
            },
            selected_sim_discount() {
                return parseInt(this.selected_sim[this.method+'_discount'].match(/(\d+)/)[1]);
            },
            currency() {
                return (new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })).format(this.money - (this.money * this.selected_sim_discount / 100));
            },
            lblPassword() {
                return 'Mật khẩu My' + this.selected_sim_name.charAt(0).toUpperCase() + this.selected_sim_name.slice(1) + (this.selected_sim_name !== 'mobiphone' ? ' (Nếu là nạp hộ có thể để trống)' : '');
            }
        },
        methods: {
            
        }
    })
</script>
@endpush