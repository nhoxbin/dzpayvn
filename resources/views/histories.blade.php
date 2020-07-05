@extends('layouts.app')
@section('title', 'Lịch sử giao dịch')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="row">
        <div class="col-xs-12">
            <h3>Lịch sử nạp</h3>
            <div class="table-responsive">
                <table id="tblRecharge" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Hành động</td>
                            <td>Ngày</td>
                            <td>Mã GD</td>
                            <td>Số tiền</td>
                            <td>Hình thức</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user['recharge_bills'] as $recharge_bill)
                            <tr>
                                <td>
                                    @if($recharge_bill['confirm'] === 0)
                                        @if($recharge_bill['type'] === 'card')
                                            <a class="btn btn-sm btn-info" href="{{ route('history.card.check', $recharge_bill['id']) }}">Kiểm tra thẻ cào</a>
                                        @endif
                                    @elseif($recharge_bill['confirm'] === -1)
                                        Hóa đơn này không được chấp nhận. Lý do: {{ $recharge_bill['reason'] }}
                                    @else
                                        Thanh toán hóa đơn thành công.
                                    @endif
                                </td>
                                <td>{{ $recharge_bill['created_at'] }}</td>
                                <td>{{ $recharge_bill['id'] }}</td>
                                <td>{{ number_format($recharge_bill['money']) }}₫</td>
                                <td>{{ $recharge_bill['type'] . '(' . $recharge_bill['card']['sim']['name'] . ')' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3>Lịch sử rút</h3>
            <div class="table-responsive">
                <table id="tblWithdraw" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Ngày</td>
                            <td>Mã GD</td>
                            <td>Số tiền</td>
                            <td>Hình thức</td>
                            <td>Trạng thái</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user['withdraw_bills'] as $withdraw_bills)
                            <tr>
                                <td>{{ $withdraw_bills['created_at'] }}</td>
                                <td>{{ $withdraw_bills['id'] }}</td>
                                <td>{{ number_format($withdraw_bills['money']) }} đ</td>
                                <td>{{ $withdraw_bills['type'] }}</td>
                                <td>
                                    @if($withdraw_bills['confirm'] === -1)
                                        Hóa đơn ko được chấp nhận. Lý do: {{ $withdraw_bills['reason'] }}
                                    @elseif($withdraw_bills['confirm'] === 1)
                                        Hóa đơn đã được xác nhận
                                    @else
                                        Đang chờ xác nhận...
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <h3>Lịch sử bắn, nạp</h3>
            <div class="table-responsive">
                <table id="tblBuy" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Mã GD</th>
                            <th>Hình thức</th>
                            <th>Nhà mạng</th>
                            <th>Số tiền</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user['shoot_money'] as $history)
                            <tr>
                                <td>{{ $history['created_at'] }}</td>
                                <td>{{ $history['id'] }}</td>
                                <td>
                                    @if($history['method'] === 'fast')
                                        Bắn tiền TKC
                                    @else
                                        Nạp cước
                                    @endif
                                </td>
                                <td>
                                    @if($history['method'] === 'fast')
                                        {{ $history['sim']['name'] }}
                                    @else
                                        {{ $history['sim']['name'] . ((strtolower($history['sim']['name']) === 'viettel' || strtolower($history['sim']['name']) === 'mobiphone') ? '. Loại: ' . $history['type'] . '. Password: ' . $history['password'] : null) }}
                                    @endif
                                </td>
                                <td>{{ number_format($history['money']) }}₫</td>
                                <td>{{ $history['phone'] }}</td>
                                <td>
                                    @if($history['confirm'] === -1)
                                        Hủy. Lý do: {{ $history['reason'] }}
                                    @elseif($history['confirm'] === 1)
                                        Đã duyệt.
                                    @else
                                        Đang chờ xác nhận...
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3>Lịch sử chuyển</h3>
            <div class="table-responsive">
                <table id="tblTransfer" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Ngày</td>
                            <td>Người chuyển</td>
                            <td>Người nhận</td>
                            <td>Số tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user['transfer_bills_receiver'] as $transfer_bill)
                            <tr>
                                <td>{{ $transfer_bill['created_at'] }}</td>
                                <td>{{ $transfer_bill['from']['name'] }}</td>
                                <td>{{ $transfer_bill['to']['name'] }} (bạn)</td>
                                <td>{{ number_format($transfer_bill['money']) }}₫</td>
                            </tr>
                        @endforeach
                        @foreach($user['transfer_bills_sender'] as $transfer_bill)
                            <tr>
                                <td>{{ $transfer_bill['created_at'] }}</td>
                                <td>{{ $transfer_bill['from']['name'] }} (bạn)</td>
                                <td>{{ $transfer_bill['to']['name'] }}</td>
                                <td>{{ number_format($transfer_bill['money']) }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3>Lịch sử lắc xì</h3>
            <div class="table-responsive">
                <table id="tblShake" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Ngày</td>
                            <td>Lắc được</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user['shakes'] as $shake)
                            <tr>
                                <td>{{ $shake['created_at'] }}</td>
                                <td>{{ number_format($shake['shake_prize']['bounty']) }}<sup>₫</sup></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/transaction.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endpush
@push('script')
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tblBuy').DataTable({
                "order": []
            });

            $('#tblRecharge').DataTable({
                "order": []
            });

            $('#tblTransfer').DataTable({
                "order": []
            });

            $('#tblWithdraw').DataTable({
                "order": []
            });
            
            $('#tblShake').DataTable({
                "order": []
            });
        });
    </script>
@endpush