@extends('admin.layouts.master')
@section('heading-name', 'Các gói của game ' . $game['name'])
@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			{{-- <h6 class="m-0 font-weight-bold text-primary">Danh sách các gói</h6> --}}
			<div class="text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#packageModal" @@click="action = 'save'">
					Thêm gói
				</button>
			</div>

			<!-- Modal thêm gói -->
			<div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="crud">Thêm gói vào game @{{ addPackageForm.game_name }}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" onsubmit="return false;">
								<div class="form-group">
									<label class="control-label col-sm-12" for="money">Số tiền mua:</label>
									<div class="col-sm-12">
										<input type="number" class="form-control" placeholder="500000" v-model.number="addPackageForm.money">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-12" for="money_in_game">Tiền trong game:</label>
									<div class="col-sm-12">
										<input type="number" class="form-control" placeholder="10000" v-model.number="addPackageForm.money_in_game">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button type="button" class="btn btn-primary" @@click="SaveOrUpdatePackage">Lưu</button>
						</div>
					</div>
				</div>
			</div>
	    </div>
	    <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				  <thead>
				    <tr>
				      <th>Tiền mua</th>
				      <th>Tiền trong game</th>
				      <th>Hành động</th>
				    </tr>
				  </thead>
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
				action: 'save',
				addPackageForm: {
					game_id: {{ $game['id'] }},
					game_name: '{{ $game['name'] }}',
					package: null,
					money: 0,
					money_in_game: 0
				},
				dataTable: null
			}
		},
		mounted() {
			this.getListPackage();
		},
		methods: {
			getListPackage() {
				$.get(route('admin.datatables.game.package', this.addPackageForm.game_id)).then(list_game => {
					this.dataTable = $('#dataTable').DataTable({
						data: list_game,
				        columns: [
				            { data: 'money' },
				            {
				            	data: 'money_in_game',
				            	render: function ( data, type, row, meta ) {
									return data + ' {{ $game['currency'] }}';
								}
				            },
				            { data: 'actions', orderable: false, "searchable": false }
				        ]
					});
				});
			},
			SaveOrUpdatePackage() {
				let url = null,
					data = {
						money: this.addPackageForm.money,
						money_in_game: this.addPackageForm.money_in_game
					};
				if (this.action === 'save') {
					url = route('admin.game.package.store', this.addPackageForm.game_id);
				} else if (this.action === 'edit') {
					url = route('admin.game.package.update', [this.addPackageForm.game_id, this.addPackageForm.package]);
					data._method = 'patch';
				}
				$.ajax({
					url: url,
					data: data,
					cache: false,
					method: 'post',
					success: (resp) => {
						alert(resp);
						location.reload();
					},
					error: function(resp) {
						alert(resp.responseText);
					}
				});
			},
			editPackage(package) {
				this.action = 'edit';
				this.addPackageForm.package = package;
				var self = this;
				$.ajax({
					url: route('admin.game.package.edit', [this.addPackageForm.game_id, package]),
					method: 'get',
					success: function(resp) {
						self.addPackageForm.money = resp.money;
						self.addPackageForm.money_in_game = resp.money_in_game;
					},
					error: function(resp) {
						alert(resp.responseText);
					}
				});
			},
			deletePackage(id) {
				let conf = confirm('Bạn có chắc muốn xóa Gói này chứ?');
				if (!conf) {
					return;
				}
				$.ajax({
					url: route('admin.game.package.destroy', [this.addPackageForm.game_id, id]),
					data: {
						_method: 'delete'
					},
					method: 'post',
					success: function(resp) {
						if (resp === 'ok') {
							alert('Xóa thành công!');
							location.reload();
						}
					}
				});
			}
		}
	})
</script>
@endpush