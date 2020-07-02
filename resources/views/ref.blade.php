@extends('layouts.app')
@section('title', 'Link giới thiệu')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="row">
        <div class="col-xs-12">
            <p>Giới thiệu bạn bè sử dụng DzPayVn ngay! Bạn sẽ nhận được 1% vnđ từ họ khi họ nạp tiền bằng thẻ cào, kiếm tiền từ rút gọn link! Link mời của bạn bên dưới 👇</p>
            <div style="text-align: center; margin-bottom: 2rem;">
                <pre>{{ url('register?ref=' . Auth::user()->ref_code) }}</pre>
            </div>
            
            <h4>Những người được bạn giới thiệu</h4>
            <div class="table-responsive">
                <table id="tblRefIncome" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Tên</td>
                            <td>Tham gia vào lúc</td>
                            <td>Tổng thu</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($refs as $ref)
                            <tr>
                                <td>{{ $ref->name }}</td>
                                <td>{{ $ref->joined_at }}</td>
                                <td>{{ number_format($ref->total_income) }}<sup>đ</sup></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h4>Chi tiết thu nhập</h4>
            <div class="table-responsive">
                <table id="tblRefDetail" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Tên</td>
                            <td>Nhận từ</td>
                            <td>Ngày</td>
                            <td>Thu nhập</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($refs_detail as $ref)
                            <tr>
                                <td>{{ $ref['name'] }}</td>
                                <td>{{ $ref['type'] }}</td>
                                <td>{{ $ref['datetime'] }}</td>
                                <td>{{ number_format($ref['income']) }}<sup>đ</sup></td>
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
            $('#tblRefIncome').DataTable({
                "order": []
            });

            $('#tblRefDetail').DataTable({
                "order": []
            });
        });
    </script>
@endpush