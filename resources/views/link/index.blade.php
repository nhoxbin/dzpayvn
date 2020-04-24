@extends('layouts.app')

@section('title', 'Danh sách link rút gọn')

@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="main-content-container">
        <div class="table-responsive">
            <table id="tblLink" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <td>Link</td>
                        <td>Thu nhập</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($links as $link)
                        <tr>
                            <td>{{ $link->url }}</td>
                            <td>{{ number_format($link->unlock_count * $link->number->amount) }} đ</td>
                            <td><button type="button" class="btn btn-sm btn-success" @@click="copyToClipboard('{{ url('link/'.$link->token) }}')">Copy</button></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align:right">Tổng thu nhập:</th>
                        <th colspan="2">@{{ this.total | currency }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
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
                    self.total = api.column(1).data().reduce((a, b) => (intVal(a) + intVal(b)), 0);

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