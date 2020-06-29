@extends('admin.layouts.master')
@section('heading-name', 'Thành viên')
@section('content')
	<div class="container-fluid">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Thu nhập ref</h6>
		    </div>
		    <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="tblRefIncome" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Tên người giới thiệu</th>
								<th>Thưởng từ</th>
								<th>Ngày</th>
								<th>Thu nhập</th>
							</tr>
						</thead>
						<tbody>
						  	@foreach($income as $v)
							  	<tr>
							  		<td>{{ $v['name'] }}</td>
							  		<td>{{ $v['type'] }}</td>
							  		<td>{{ $v['datetime'] }}</td>
							  		<td>{{ number_format($v['income']) }}<sup>đ</sup></td>
							  	</tr>
						  	@endforeach
						</tbody>
						<tfoot>
		                    <tr>
		                        <th colspan="3" style="text-align:right">Thu nhập:</th>
		                        <th colspan="1"></th>
		                    </tr>
		                </tfoot>
					</table>
				</div>
		    </div>
		</div>

		<div class="card shadow mb-4">
		    <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Danh sách người giới thiệu</h6>
		    </div>
		    <div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="tblRef" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Người giới thiệu</th>
								<th>Người được giới thiệu</th>
								<th>Ngày</th>
							</tr>
						</thead>
						<tbody>
						  	@foreach($refs as $ref)
							  	<tr>
							  		<td>{{ $ref['name'] }}</td>
							  		<td>{{ $ref['ref'] }}</td>
							  		<td>{{ $ref['created_at'] }}</td>
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
			var self = this;
			var currency = v => {
				return (new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' })).format(v);
			};

            $('#tblRefIncome').DataTable({
            	order: [],
            	"columnDefs": [
			        { "targets": [1,2], "searchable": false }
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
                    var total = api.column(3).data().reduce((a, b) => (intVal(a) + intVal(b)), 0);

                    // Total over this page
                    var pageTotal = api.column(3, { page: 'current'} ).data().reduce((a, b) => (intVal(a) + intVal(b)), 0);
                    var income = currency(pageTotal) + ' trên tổng ' + currency(total);
                    // Update footer
                    $(api.column(3).footer()).html(income);
                }
            });

            $('#tblRef').DataTable({
            	order: [],
            	"columnDefs": [
			        { "targets": [2], "searchable": false }
			    ]
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