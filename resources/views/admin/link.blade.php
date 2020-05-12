@extends('admin.layouts.master')
@section('heading-name', 'Thành viên')
@section('content')
	<div class="container-fluid">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Danh sách thành viên</h6>
		    </div>
		    <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="tblLink" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>ID</th>
								<th>Tài khoản</th>
								<th>Link</th>
								<th>Lượt mở</th>
								<th>Thu nhập</th>
								<th>Hành động</th>
							</tr>
						</thead>
						<tbody>
						  	@foreach($links as $link)
							  	<tr>
							  		<td>{{ $link->id }}</td>
							  		<td>{{ $link->user->name }}</td>
							  		<td>{{ $link->url }}</td>
							  		<td>{{ $link->unlock_count }}</td>
							  		<td>{{ number_format($link->unlock_count * $link->service->amount) }} đ</td>
							  		<td><button type="button" class="btn btn-sm btn-success" @@click="copyToClipboard('{{ url('link/'.$link->token) }}')">Copy</button></td>
							  	</tr>
						  	@endforeach
						</tbody>
						<tfoot>
		                    <tr>
		                        <th colspan="4" style="text-align:right">Thu nhập:</th>
		                        <th colspan="2"></th>
		                    </tr>
		                </tfoot>
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
			var self = this;
			var currency = v => {
				return (new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })).format(v);
			};

            $('#tblLink').DataTable({
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