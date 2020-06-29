@extends('layouts.app')
@section('title', 'Link giới thiệu')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="row">
        <div class="col-xs-12">
            <p>Giới thiệu bạn bè sử dụng DzPayVn ngay! Bạn sẽ nhận được 1% vnđ từ họ khi họ nạp tiền bằng thẻ cào, kiếm tiền từ rút gọn link! Link mời của bạn bên dưới 👇</p>
            <div style="text-align: center; margin-bottom: 2rem;">
                <span>{{ url('register?ref=' . Auth::user()->ref_code) }}</span>
            </div>
            
            <h4>Những người được bạn giới thiệu</h4>
            <div class="table-responsive">
                <table id="tblRecharge" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Tên</td>
                            <td>Ngày</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $ref)
                            <tr>
                                <td>{{ $ref->user->name }}</td>
                                <td>{{ $ref->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h4>Thu nhập</h4>
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
                        {{-- @foreach($user['withdraw_bills'] as $withdraw_bills)
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
                        @endforeach --}}
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
        });
    </script>
@endpush