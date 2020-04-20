@extends('admin.layouts.master')
@section('heading-name', 'Lịch sử mua')
@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Lịch sử mua</h6>
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
							<button type="button" class="btn btn-danger" @@click="action('reject', order_id)" data-dismiss="modal">Hủy hóa đơn</button>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
					    <tr>
							<th>Mã GD</th>
							<th>Khách hàng</th>
							<th>Mua</th>
							<th>Game</th>
							<th>Loại tài khoản</th>
							<th>Tên nhân vật</th>
							<th>Thông tin</th>
							<th>Hành động</th>
					    </tr>
					</thead>
					<tbody>
						@foreach($buy_bills as $history)
					  		<tr>
					  			<td>{{ $history['id'] }}</td>
					  			<td>{{ $history['user']['name'] }}</td>
					  			<td>{{ number_format($history['package']['money_in_game']) . $history['package']['game']['sort_currency'] }}</td>
					  			<td>{{ $history['package']['game']['name'] }}</td>
					  			<td>{{ $history['account_type'] }}</td>
					  			<td>{{ $history['name_character'] }}</td>
					  			<td>{{ $history['info'] }}</td>
					  			<td>
									@if($history['confirm'] === 0)
						  				<div class="btn-group" role="group" aria-label="action button">
											<button class="btn btn-sm btn-primary" @@click="action('confirm', '{{ $history['id'] }}')">Xác nhận</button>
											<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalReason" @@click="order_id = '{{ $history['id'] }}'">Hủy đơn</button>
										</div>
									@else
										{{ $history['comment'] . (empty($history['reason']) ? null : ' Lý do: ' . $history['reason']) }}
									@endif
					  			</td>
					  		</tr>
						@endforeach
					</tbody>
				</table>
			</div>
	    </div>
	</div>
</div>
@endsection

@push('script')
<script>
	var app = new Vue({
		el: '#app',
		data: function() {
			return {
				reason: '',
				order_id: ''
			}
		},
		mounted() {
			$('#dataTable').DataTable();
		},
		methods: {
			action(type, id) {
				$.ajax({
					url: route('admin.buy.update', id),
					data: {
						reason: this.reason,
						action: type,
						_method: 'patch'
					},
					method: 'post',
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