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
					<table class="table table-bordered" id="tblUnlockLink" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Tên</th>
								<th>Số dịch vụ</th>
								<th>ID Link</th>
								<th>Link</th>
								<th>Thời gian</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
						  	@foreach($users as $user)
							  	<tr>
							  		<td>{{ $user->user->name }}</td>
							  		<td>{{ $user->link->service->number }}</td>
							  		<td>{{ $user->link->id }}</td>
							  		<td>{{ $user->link->url }}</td>
							  		<td>{{ $user->created_at }}</td>
							  		<td><button type="button" class="btn btn-sm btn-success" @@click="copyToClipboard('{{ url('link/'.$user->link->token) }}')">Copy</button></td>
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
			return {}
		},
		mounted() {
			var self = this;
			var currency = v => {
				return (new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })).format(v);
			};

            $('#tblUnlockLink').DataTable({
            	order: [],
            	"columnDefs": [
			        { "targets": [2,3], "searchable": false }
			    ],
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
                    var total = api.column(4).data().reduce((a, b) => (intVal(a) + intVal(b)), 0);

                    // Total over this page
                    var pageTotal = api.column(4, { page: 'current'} ).data().reduce((a, b) => (intVal(a) + intVal(b)), 0);
                    var income = currency(pageTotal) + ' trên tổng ' + currency(total);
                    // Update footer
                    $(api.column(4).footer()).html(income);
                }
            });
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
