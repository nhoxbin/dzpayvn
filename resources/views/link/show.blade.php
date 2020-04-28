@extends('layouts.app')

@section('title', 'Danh sách link rút gọn')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        Mở khóa link bằng OTP tin nhắn<br />
        Soạn tin: <b>ON DZLINK {{ $link->id }}</b> gửi <b>{{ $link->service_number }}</b> ({{ number_format($link->service->amount) }} VNĐ / sms)
        <form action="" method="post">
            @csrf
            Nhập mã: <input type="number" name="code" class="form-control">
            <br />
            <button type="submit" class="btn btn-success">Mở khóa</button>
        </form>
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/transaction.css') }}">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/phone-topup.css') }}">
    <style>
        select {
            margin-bottom: 10px;
        }
    </style>
@endpush

@push('script')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: function() {
            return {

            }
        },
        created() {
        },
        computed: {
            
        },
        methods: {
            
        }
    })
</script>
@endpush