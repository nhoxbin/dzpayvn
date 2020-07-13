@extends('admin.layouts.master')
@section('heading-name', 'Mở khóa link')
@section('content')
	<div class="container-fluid">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Danh sách thành viên mở khóa link bằng tiền dzpayvn</h6>
		    </div>
		    <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="tblLink" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Tên</th>
								<th>Số dịch vụ</th>
								<th>Link</th>
							</tr>
						</thead>
						<tbody>
						  	@foreach($users as $user)
							  	<tr>
							  		<td>{{ $user->user->name }}</td>
							  		<td>{{ $user->link->service->number }}</td>
							  		<td>{{ $user->link->url }}</td>
							  	</tr>
						  	@endforeach
						</tbody>
					</table>
				</div>
		    </div>
		</div>
	</div>
@endsection