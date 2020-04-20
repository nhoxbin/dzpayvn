@extends('layouts.app')
@section('title', 'Khách nạp game')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div class="row">
        <div class="col-xs-12">
            <!-- Modal YC hủy -->
            <div class="modal fade" id="modalRequestPicture" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crud">Gửi hình</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="requỉe-confirm-form" class="form-horizontal" :action="linkRequest" method="post" enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label class="col-sm-12">Trước:</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="images[]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Sau:</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="images[]">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('requỉe-confirm-form').submit()">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalRequestCancel" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crud">Yêu cầu hủy</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="requỉe-cancel-form" :action="linkRequest" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label class="col-sm-12">Lý do:</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="reason">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('requỉe-cancel-form').submit()">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tblUserBuyGame" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>Ngày</td>
                            <td>Mã GD</td>
                            <td>Gói</td>
                            <td>Loại TK</td>
                            <td>Tên nhân vật</td>
                            <td>Thông tin</td>
                            <td>Hành động</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($games as $game)
                            @foreach($game['buy_bills'] as $buy_bill)
                                <tr>
                                    <td>{{ $buy_bill['created_at'] }}</td>
                                    <td>{{ $buy_bill['id'] }}</td>
                                    <td>{{ 'Game: '.$game['name'].' '.number_format($buy_bill['package']['money_in_game']) . $game['sort_currency'] }}</td>
                                    <td>{{ $buy_bill['account_type'] }}</td>
                                    <td>{{ $buy_bill['name_character'] }}</td>
                                    <td>{{ $buy_bill['info'] }}</td>
                                    <td>
                                        @if($buy_bill['confirm'] === 0)
                                            @if($buy_bill['require_cancel'] === 0 && empty($buy_bill['picture_to_confirm']))
                                                <div class="btn-group" role="group" aria-label="action button">
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalRequestPicture" @@click="selectedBill='{{ $buy_bill['id'] }}', command='send'">Gửi ảnh</button>

                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalRequestCancel"  @@click="selectedBill='{{ $buy_bill['id'] }}', command='require_cancel'">Yêu cầu hủy</button>
                                                </div>
                                            @else
                                                Bạn đã gửi yêu cầu. Đợi Admin xác nhận.
                                            @endif
                                        @elseif($buy_bill['confirm'] === -1)
                                            {{ 'Đơn hàng đã bị hủy!' . (empty($buy_bill['reason']) ? null : ' Lý do: ' . $buy_bill['reason']) }}
                                        @else
                                            Admin đã xác nhận
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
        if($errors->any())
            alert('{{ $errors->first() }}');
        @endif
        new Vue({
            el: '#app',
            data: function() {
                return {
                    command: null,
                    selectedBill: 0
                }
            },
            computed: {
                linkRequest() {
                    return route('staff.manage.bill.update', {bill: this.selectedBill, command: this.command});
                }
            },
            mounted() {
                $('#tblUserBuyGame').DataTable({
                    columnDefs: [
                        { targets: [0], visible: false }
                    ],
                    order: [[ 0, 'desc' ]]
                });
            }
        })
    </script>
@endpush