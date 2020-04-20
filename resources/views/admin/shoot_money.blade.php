@extends('admin.layouts.master')

@section('heading-name', 'Lịch sử nạp, bắn tiền điện thoại')

@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Lịch sử nạp, bắn tiền điện thoại</h6>
	    </div>
	    <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="shoot_money_table" width="100%" cellspacing="0">
					<thead>
					    <tr>
							<th>Ngày</th>
							<th>Mã GD</th>
							<th>Tên</th>
							<th>Hình thức</th>
							<th>Nhà mạng</th>
							<th>Số tiền</th>
							<th>Số điện thoại</th>
							<th>Trạng thái</th>
					    </tr>
					</thead>
					<tbody>
						@foreach($shoot_money as $history)
					  		<tr>
					  			<td>{{ $history->created_at }}</td>
					  			<td>{{ $history->id }}</td>
					  			<td>{{ $history->user->name }}</td>
					  			<td>
					  				@if($history->method === 'fast')
					  					Bắn tiền TKC
					  				@else
					  					Nạp cước
					  				@endif
					  			</td>
					  			<td>
					  				@if($history->method === 'fast')
					  					{{ $history->sim->name }}
					  				@else
										{{ $history->sim->name . '. Loại: ' . $history->type . '. Password: ' . $history->password }}
					  				@endif
					  			</td>
					  			<td>{{ number_format($history['money']) }}₫</td>
					  			<td>{{ $history->phone }}</td>
					  			<td>
					  				@if($history->confirm === -1)
					  					Hủy. Lý do: {{ $history->reason }}
					  				@elseif($history->confirm === 1)
					  					Đã duyệt.
					  				@else
					  					<div class="btn-group btn-group-sm">
						  					<button class="btn btn-success" @@click="confirm(1, '{{ $history->id }}')">Chấp nhận</button>
						  					<button class="btn btn-danger" data-toggle="modal" data-target="#modalReason" @@click="id = '{{ $history->id }}'">Hủy</button>
					  					</div>
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

<!-- Modal -->
<div id="modalReason" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<textarea v-model="reason" class="form-control" placeholder="Nhập vào lý do hủy (nếu có)"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
				<button type="button" class="btn btn-danger" @@click="confirm(-1, id)" data-dismiss="modal">Hủy hóa đơn</button>
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
				id: '',
				action: 0,
				reason: ''
			}
		},
		mounted() {
			$('#shoot_money_table').DataTable({
                "order": []
            });
		},
		methods: {
			confirm(action, id) {
				this.action = action;
				var url = route('admin.shoot_money.update', id);
				var data = {
					confirm: action,
					_method: 'patch'
				};
				if (action === -1) {
					data.reason = this.reason;
				}
				$.post(url, data).then(function(resp) {
					alert(resp);
					location.reload();
				});
			}
		}
	})
</script>
@endpush