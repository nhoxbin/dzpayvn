@extends('layouts.app')
@section('title', 'Chuyển tiền')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="row">
        <div class="col-xs-12">
            <form autocomplete="off" novalidate>
                @csrf
                <div class="col-xs-12 input-block">
                    <input class="form-control" type="number" v-model="to" required autocomplete="off" placeholder="ID người muốn chuyển">
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-12 input-block">
                    <input class="form-control" type="number" v-model="money" required placeholder="Số tiền muốn chuyển">
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="col-xs-12 input-block">
                <button type="button" class="register-btn btn btn-green" @@click="transfer">Chuyển tiền</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/register.css') }}">
@endpush
@push('script')
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: function() {
            return {
                to: null,
                money: null
            }
        },
        methods: {
            transfer() {
                var self = this;
                $.ajax({
                    url: route('transfer.store'),
                    data: {
                        to: this.to,
                        money: this.money
                    },
                    method: 'post',
                    success: function(resp) {
                        if (resp.success === true) {
                            self.to = null;
                            self.money = null;
                        }
                        alert(resp.msg);
                    }
                });
            }
        }
    });
</script>
@endpush