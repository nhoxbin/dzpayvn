@extends('layouts.app')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="box-blue"></div>
	<div class="wallet-container">
	    <div class="row">
	        <div class="col-sm-6 col-xs-4">Số dư</div>
	        <div class="col-sm-6 col-xs-8 text-right">{{ number_format($user['cash']) }} ₫</div>
	    </div>
	    <div class="row">
            <div class="col-xs-6">ID của bạn</div>
            <div class="col-xs-6 text-right">{{ $user['id'] }}</div>
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
	            <a href="{{ route('withdraw.create') }}">
	                <div class="tool-icon">
	                <img src="{{ asset('libs/baokim/images/wallet-db-02.svg') }}">
	                </div>
	                <span class="tool-text">Rút tiền</span>
	            </a>
	        </div>
	    </div>
	</div>
	<br />
	@include('_errors')

	<div class="alert alert-warning" style="">
        <button class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        DzPayVn vừa mới mở tính năng lắc xì trúng thưởng lớn. Vui lòng click <a href="{{ route('shake.create') }}">vào đây</a> để chơi.
    </div>
	<div class="function-container">
		<a href="{{ route('ref.index') }}" class="function-button no-padding shadow blockIP">
            <img src="https://i.imgur.com/OajVp28.png">
            <p>Giới thiệu ( Kiếm Tiền )</p>
	    </a>
		<a href="{{ route('shoot_money.create') }}" class="function-button no-padding shadow blockIP">
            <img src="https://i.imgur.com/3xUbehh.png">
            <p>Bắn Tiền TKC Và Nạp Cước ( 3 Nhà Mạng )</p>
	    </a>
	    <a href="http://shopgamedz.com" class="function-button no-padding function-button-no-margin shadow blockIP">
            <img src="https://i.imgur.com/eASDz2X.png">
            <p>Nạp Game, App Mobile Qua Android và IOS giá rẻ!</p>
	    </a>
	    <a href="{{ route('url.create') }}" class="function-button no-padding shadow blockIP">
            <img src="https://i.imgur.com/mACPdxd.png">
            <p>Rút Gọn Link ( Kiếm Tiền )</p>
	    </a>
		{{-- @foreach($games as $game)
    	    <a href="{{ route('game.buy.create', $game['id']) }}" class="function-button no-padding shadow {{ $loop->iteration%3 === 0 ? 'function-button-no-margin' : '' }} blockIP">
	            <img src="{{ asset($game['picture']) }}">
	            <p>{{ $game['name'] }}</p>
    	    </a>
	    @endforeach --}}
	</div>
	<div class="other-function-container">
	    <a href="https://www.facebook.com/vlHungDZ/">
	        <div class="other-function-content shadow">
	            <img src="https://i.imgur.com/ugfVQ0w.png">
	            <div class="content-text">
	                <span>Liên Hệ Facebook Admin</span>
	            </div>
	        </div>
	    </a>
	</div>
</div>
@endsection

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/dashboard.css') }}">
@endpush