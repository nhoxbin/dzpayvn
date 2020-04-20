@extends('admin.layouts.master')

@section('heading-name', 'Lắc Xì')

@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Thiết lập</h6>
	    </div>
	    <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
				  <thead>
				    <tr>
				      <th>STT</th>
				      <th>Thưởng</th>
				      <th>Hành động</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($shake_prizes as $prize)
				  		<tr>
				  			<td>{{ $prize->id }}</td>
				  			<td>{{ number_format($prize->bounty) }}<sup>đ</sup></td>
				  			<td>
				  				<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#shakeModal" @@click="editShake({{ $prize->id }})">Sửa</button>
				  			</td>
				  		</tr>
				  	@endforeach
				  </tbody>
				</table>
			</div>
	    </div>
	</div>

	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng đã lắc xì</h6>
	    </div>
	    <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="shake-table" width="100%" cellspacing="0">
				  <thead>
				    <tr>
				      <th>STT</th>
				      <th>Tên</th>
				      <th>Trúng</th>
				      <th>Hành động</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($shakes as $shake)
				  		<tr>
				  			<td>{{ $shake->id }}</td>
				  			<td>{{ $shake->user->name }}</td>
				  			<td>{{ number_format($shake->shake_prize->bounty) }}<sup>đ</sup></td>
				  			<td>
				  				<button class="btn btn-sm btn-danger">Xóa</button>
				  			</td>
				  		</tr>
				  	@endforeach
				  </tbody>
				</table>
			</div>
	    </div>
	</div>
</div>

<div class="modal fade" id="shakeModal" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="crud">Sửa thiết lập lixi</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form class="form-horizontal" onsubmit="return false;">
				<div class="form-group">
					<label class="control-label col-sm-12" for="discount">Thưởng:</label>
					<div class="col-sm-12">
						<input type="number" class="form-control" placeholder="5000" v-model.number="shake_prize.bounty">
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			<button type="button" class="btn btn-primary" @@click="actions">Lưu</button>
		</div>
	</div>
</div>
</div>
@endsection

@push('script')
<script>
	new Vue({
		el: '#app',
		data: function() {
			return {
				shake_prize: {
					id: 0,
					bounty: 0
				}
			}
		},
		mounted() {
			$('#shake-table').DataTable();
		},
		methods: {
			actions() {
				$.ajax({
					url: route('admin.prize.update', this.shake_prize.id),
					data: {
						bounty: this.shake_prize.bounty,
						_method: 'patch'
					},
					method: 'post',
					success: (resp) => {
						alert(resp);
						location.reload();
					},
					error: function(resp) {
						alert('Vui lòng điền đầy đủ các trường đã cho!');
					}
				});
			},
			editShake(id) {
				$.get(route('admin.prize.edit', id), resp => {
					this.shake_prize = resp;
				});
			}
		}
	})
</script>
@endpush