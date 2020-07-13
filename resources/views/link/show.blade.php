@extends('layouts.app')

@section('title', 'Rút Gọn Link | Bảo Mật Link | DZpayVN')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        Mở khóa link bằng OTP tin nhắn<br />
        Soạn tin: <b>ON DZLINK {{ $link->id }}</b> gửi <b>{{ $link->service_number }}</b><br/>
        <a href="sms:{{ $link->service_number }}?body=ON DZLINK {{ $link->id }}">=> Click <= Coppy Và Mở Nhắn Tin Trên Điện Thoại</a>
        <form action="" method="post">
            @csrf
            Nhập mã OTP: <input type="number" name="code" class="form-control">
            <br />
            <button type="submit" class="btn btn-success">Mở khóa</button>
        </form>
        Hoặc
        <form action="" method="post">
            @csrf
            <input type="hidden" name="user_unlock_link" value="1">
            <button type="submit" class="btn btn-success">Mở Khóa Bằng Tiền Trong Tài Khoản DzPayVN ( {{ number_format($link->service->amount) }} vnđ )</button>
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
@endpush