@extends('admin.layouts.master')

@section('heading-name', 'Lịch sử chuyển tiền')

@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Lịch sử chuyển tiền</h6>
	    </div>
	    <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
					    <tr>
							<th>Ngày</th>
							<th>Mã GD</th>
							<th>Từ</th>
							<th>Đến</th>
							<th>Số tiền</th>
					    </tr>
					</thead>
					<tbody>
						@foreach($transfer_bills as $history)
					  		<tr>
					  			<td>{{ $history['created_at'] }}</td>
					  			<td>{{ $history['id'] }}</td>
					  			<td>{{ $history['from']['name'] }}</td>
					  			<td>{{ $history['to']['name'] }}</td>
					  			<td>{{ number_format($history['money']) }}₫</td>
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
				
			}
		},
		mounted() {
			$('#dataTable').DataTable({
                order: [[ 0, 'desc' ]]
            });
		},
		methods: {
			
		}
	})
</script>
@endpush