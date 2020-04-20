@extends('admin.layouts.master')
@section('heading-name', 'Nhân viên báo cáo')
@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Danh sách hóa đơn nhân viên gửi yêu cầu</h6>
	    </div>
	    <div class="card-body">
			<div class="table-responsive">
				<table id="reportTables" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				  <thead>
				    <tr>
				      <th>Mã đơn</th>
				      <th>Nhân viên duyệt</th>
				      <th>Tên nhân vật</th>
				      <th>Nạp</th>
				      <th>Trạng thái</th>
				      <th>Hành động</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($reports as $report)
				  		<tr>
				  			<td>{{ $report->id }}</td>
				  			<td>{{ App\User::find($report->nv_id)->name . ". {$report->nv_id}" }}</td>
				  			<td>{{ $report->name_character }}</td>
				  			<td>{{ number_format($report->package->money_in_game) . $report->package->game->sort_currency.' Game: '.$report->package->game->name }}</td>
				  			<td>
				  				@if($report->require_cancel === 1)
				  					Yêu cầu hủy. Lý do: {{ $report->reason }}
				  				@else
				  					<img src="{{ url(json_decode($report->picture_to_confirm)['imgBefore']) }}" alt="before" class="img-responsive img-thumbnail img">
				  					<img src="{{ url(json_decode($report->picture_to_confirm)['imgAfter']) }}" alt="after" class="img-responsive img-thumbnail img">
				  				@endif
				  			</td>
				  			<td>
				  				@if($report->confirm === 0)
									<button class="btn btn-sm btn-primary" onclick="document.getElementById('confirm-form').submit()">Xác nhận</button>
									<form id="confirm-form" action="{{ route('admin.staff.report.bill.update', $report->id) }}" style="display: none" method="post">
										@method('patch')
										@csrf
									</form>
				  				@else
				  					Admin đã xác nhận
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
				action: 'add',
				simForm: {
					id: 0,
					name: '',
					discount: null
				},
				dataTable: null
			}
		},
		mounted() {
			$('#reportTables').DataTable();
		},
		methods: {
		}
	})
</script>
@endpush