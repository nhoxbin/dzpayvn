@extends('layouts.app')

@section('title', 'Link rút gọn')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        @include('_errors')

        <form action="{{ route('url.store') }}" method="post">
            @csrf
            <select name="service_number" class="form-control">
                @foreach($service_numbers as $service_number)
                    <option value="{{ $service_number->number }}">{{ $service_number->number . ' - ' . number_format($service_number->amount) }} đ</option>
                @endforeach
            </select>

            <input type="url" name="url" placeholder="Vui lòng nhập link" class="form-control">
            <br />
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

            }
        },
        computed: {
            
        },
        methods: {
            
        }
    })
</script>
@endpush