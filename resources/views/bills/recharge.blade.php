@extends('layouts.app')
@section('title', 'Nạp Tiền')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div id="loading-icon" style="display: none;">
        <img src="{{ asset('libs/baokim/images/loading.gif') }}">
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                @include('_errors')
                
                <div class="x_content">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#card">Thẻ điện thoại</a></li>
                        <li class=""><a data-toggle="tab" href="#momo">Momo</a></li>
                        <li class=""><a data-toggle="tab" href="#sms">Nạp tin nhắn</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="card" class="tab-pane fade in active">
                            <form action="{{ route('recharge.store') }}" method="POST" autocomplete="off" id="card-form">
                                @csrf
                                <input type="hidden" name="type" class="type" value="card">
                                <div class="list_amount">
                                    <div class="tab_amount">
                                        <div id="list_amount">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="10" class="card-choose__amount text-center boder_active">10K</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="20" class="card-choose__amount text-center">20K</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="30" class="card-choose__amount text-center">30K</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="50" class="card-choose__amount text-center">50K</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="100" class="card-choose__amount text-center">100K</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="200" class="card-choose__amount text-center">200K</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="300" class="card-choose__amount text-center">300K</div>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div for="500" class="card-choose__amount text-center">500K</div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="money" value="10K">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 input-block">
                                    <select name="sim_id" id="sim" class="form-control">
                                        @foreach($sims as $sim)
                                            @if(!$sim['maintenance'])
                                                <option value="{{ $sim['id'] }}">{{ $sim['name'] . ' - ' . $sim['discount']}}</option>
                                            @else
                                                <option value="0">Nạp thẻ cào đang bảo trì!!!</option>
                                                
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-xs-12 input-block">
                                    <input type="text" class="form-control" name="serial" placeholder="Số serial number" value="{{ old('serial') }}">
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-xs-12 input-block">
                                    <input autocomplete="off" type="text" class="form-control" name="code" placeholder="Mã nạp" value="{{ old('code') }}">
                                    <div class="clearfix"></div>
                                </div>
                            </form>

                            <div class="col-xs-12">
                                <h4><b>Lưu ý:</b> Mệnh giá bạn chọn ko đúng với mệnh giá thẻ, hệ thống sẽ <b>NUỐT THẺ</b> và ko hoàn trả lại, hãy cẩn thận</h4>
                            </div>
                        </div>

                        <div id="momo" class="tab-pane fade">
                            <p>Chuyển tiền vào tài khoản momo dưới đây và điền thông tin bên dưới!</p>
                            <p>Nội dung chuyển tiền ghi: 0{{ Auth::user()->phone }}</p>

                            <img src="{{ asset('images/momo.png') }}" alt="momo payment" class="img img-responsive img-rounded">
                            <form action="{{ route('recharge.store') }}" method="POST" autocomplete="off" id="momo-form" novalidate="novalidate">
                                @csrf
                                <input type="hidden" name="type" class="type" value="momo">
                                <div class="col-xs-12 input-block">
                                    <input autocomplete="off" class="valid" type="text" name="phone" aria-invalid="false">
                                    <label for="" alt="Số điện thoại người gửi" placeholder="Số điện thoại người gửi"></label>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-xs-12 input-block">
                                    <input autocomplete="off" class="valid" type="text" value="" name="code_momo" aria-invalid="false">
                                    <label for="" alt="Mã giao dịch MoMo" placeholder="Mã giao dịch MoMo"></label>
                                    
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-xs-12 input-block">
                                    <input autocomplete="off" placeholder="Số tiền nạp" class="form-control" type="number" name="money">
                                    
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>

                        <div id="sms" class="tab-pane fade">
                            <br />
                            <p>Soạn tin nhắn: ON DZPAY {{ Auth::id() }}</p>
                            <p>Gửi 8785 (+4.000 VNĐ)</p>
                            <p>Gửi 8685 (+2.500 VNĐ)</p>
                            <p>Gửi 8585 (+1.200 VNĐ)</p>
                        </div>

                        <div class="col-xs-12 input-block" id="recharge">
                            <button type="button" class="btn btn-green recharge-btn">Nạp tiền</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/create.css') }}">
@endpush

@push('script')
    <script type="text/javascript" src="{{ asset('libs/baokim/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/baokim/js/additional-methods.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/baokim/js/create.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.recharge-btn').on('click', function() {
                let form = $('.tab-pane.in.active').find('form');
                let type = form.find('input[name="type"]').val();
                
                if (form.valid()) {
                    $('#loading-icon').show();
                    form.submit();
                } else {
                    $('#loading-icon').hide();
                }
            });
        });
    </script>
@endpush