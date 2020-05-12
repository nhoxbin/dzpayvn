@extends('layouts.app')

@section('title', 'Link rút gọn')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        @include('_errors')
        Chọn đầu số mở khóa Link (mỗi lượt mở khóa link bạn sẽ nhận được số tiền tương ứng vào tài khoản của bạn!)
        <form action="{{ route('url.store') }}" method="post">
            @csrf
            <select name="service_number" class="form-control">
                @foreach($service_numbers as $service_number)
                    <option value="{{ $service_number->number }}">{{ $service_number->number . ' - ' . number_format($service_number->amount) }} đ</option>
                @endforeach
            </select>

            <input type="url" name="url" placeholder="Bỏ link cần rút gọn vào đây!" class="form-control">
            <br />
            <div class="input-block">
                <button type="submit" class="buy-btn btn btn-green">Rút Gọn</button>
            </div>
        </form>
        <br />
        <div class="table-responsive">
            <table id="tblLink" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Link</td>
                        <td>Số lần mở khoá</td>
                        <td>Thu nhập</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($links as $link)
                        <tr>
                            <td>{{ $link->id }}</td>
                            <td>{{ $link->url }}</td>
                            <td>{{ $link->unlock_count }}</td>
                            <td>{{ number_format($link->unlock_count * $link->service->amount) }} đ</td>
                            <td><button type="button" class="btn btn-sm btn-success" @@click="copyToClipboard('{{ url('link/'.$link->token) }}')">Copy</button></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align:right">Tổng thu nhập:</th>
                        <th colspan="2">@{{ this.total | currency }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div id="loading-icon" style="display: none;"><center><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></center></div>
    </div>
</div>
@endsection

@push('style')
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
<script src="//cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
<script>
    new Vue({
        el: '#app',
        data: function() {
            return {
                total: 0
            }
        },
        created() {
            var self = this;
            $('#tblLink').DataTable({
                order: [],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[^\d+]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    self.total = api.column(3).data().reduce((a, b) => (intVal(a) + intVal(b)), 0);

                    // Update footer
                    /*$(api.column(1).footer()).html();*/
                }
            });
        },
        filters: {
            currency(v) {
                return (new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })).format(v);
            },
        },
        methods: {
            copyToClipboard (str) {
                var el = document.createElement('textarea');
                el.value = str;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);

                alert('Link đã được Copy, bạn hãy share nó và kiếm tiền nào :)');
            }
        }
    })
</script>
@endpush