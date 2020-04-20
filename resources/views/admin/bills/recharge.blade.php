@extends('admin.layouts.master')

@section('heading-name', 'Lịch sử nạp tiền')

@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Lịch sử nạp tiền</h6>
	    </div>
	    <div class="card-body">
	    	<!-- Modal -->
			<div id="modalReason" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content -->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							{{-- <h4 class="modal-title">Modal Header</h4> --}}
						</div>
						<div class="modal-body">
							<textarea v-model="reason" class="form-control" placeholder="Nhập vào lý do hủy (nếu có)"></textarea>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
							<button type="button" class="btn btn-danger" onclick="app.action('reject', app.order_id)" data-dismiss="modal">Hủy hóa đơn</button>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
					    <tr>
							<th></th>
							<th>Ngày</th>
							<th>Mã GD</th>
							<th>Khách hàng</th>
							<th>Số tiền</th>
							<th>Hình thức nạp</th>
							<th>Hành động</th>
					    </tr>
					</thead>
				</table>
			</div>
	    </div>
	</div>
</div>
@endsection
@push('css')
<style>
	td.details-control {
	    background: url('{{ asset('images/details_open.png') }}') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('{{ asset('images/details_close.png') }}') no-repeat center center;
	}
</style>
@endpush

@push('script')
	@if($errors->any())
		<script>alert('{{ $errors->first() }}')</script>
	@endif
	
<script>
	var app = new Vue({
		el: '#app',
		data: function() {
			return {
				order_id: '',
				reason: ''
			}
		},
		async mounted() {
			var table;
			await $.get(route('admin.datatables.recharge_bills')).then(function(bills) {
				table = $('#dataTable').DataTable({
					data: bills,
					"columns": [
			            {
			                "className":      'details-control',
			                "orderable":      false,
			                "data":           null,
			                "defaultContent": ''
			            },
						{ "data": "created_at" },
			            { "data": "id" },
			            { "data": "customer_name" },
			            { "data": "money" },
			            { "data": "payment_method" },
			            { "data": "actions" }
			        ],
					"order": [[ 1, "desc" ]],
					
				});
			})
			var self = this;
			// Add event listener for opening and closing details
		    $('#dataTable tbody').on('click', 'td.details-control', function() {
		        var tr = $(this).closest('tr');
		        var row = table.row( tr );
		        if ( row.child.isShown() ) {
		            // This row is already open - close it
		            row.child.hide();
		            tr.removeClass('shown');
		        } else {
		            // Open this row
		            row.child( self.format(row.data()) ).show();
		            tr.addClass('shown');
		        }
		    });
		},
		methods: {
			format(d) {
				var tr = '';
				if (d.payment_method === 'card') {
					tr = '<tr>'+
				            '<td>Nhà mạng:</td>'+
				            '<td>'+d.card.sim+'</td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td>Số serial:</td>'+
				            '<td>'+d.card.serial+'</td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td>Mã code:</td>'+
				            '<td>'+d.card.code+'</td>'+
				        '</tr>';
				} else if (d.payment_method === 'momo') {
					tr = '<tr>'+
				            '<td>Số điện thoại người chuyển:</td>'+
				            '<td>'+d.momo.phone+'</td>'+
				        '</tr>'+
				        '<tr>'+
				            '<td>Mã giao dịch:</td>'+
				            '<td>'+d.momo.code+'</td>'+
				        '</tr>';
				}
			    // `d` is the original data object for the row
			    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+tr+'</table>';
			},
			action(type, id) {
				let data = {
					action: type,
					_method: 'patch'
				};
				if (type === 'reject') {
					data.reason = this.reason;
				}
				$.ajax({
					url: route('admin.recharge.update', id),
					method: 'post',
					data: data,
					success: function(resp) {
						alert(resp);
						location.reload();
					}
				});
			}
		}
	})
</script>
@endpush