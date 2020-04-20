@extends('admin.layouts.master')
@section('heading-name', 'Danh sách Game')
@section('content')
<div class="container-fluid">
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
			{{-- <h6 class="m-0 font-weight-bold text-primary">Danh sách các game</h6> --}}
			<div class="text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalGame" @@click="action = 'add'">
					Thêm game
				</button>
			</div>

			<!-- Modal thêm game -->
			<div class="modal fade" id="modalGame" tabindex="-1" role="dialog" aria-labelledby="modalGame" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="action">@{{ actionLabel }} game</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" onsubmit="return false;">
								<div class="form-group">
									<label class="control-label col-sm-12" for="name">Name:</label>
									<div class="col-sm-12">
										<input type="text" class="form-control" v-model="gameForm.name" placeholder="Nhập tên Game">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-12" for="file">Tiền tệ:</label>
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="Vàng, Bạc, Ngọc, Kim cương..." v-model="gameForm.currency">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-12" for="file">Tiền tệ viết tắt:</label>
									<div class="col-sm-12">
										<input type="text" class="form-control" placeholder="V, B, Ng, KC..." v-model="gameForm.sort_currency">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-2" for="file">Loại:</label>
									<div class="col-sm-12">
										<select v-model="gameForm.type" class="form-control">
											<option value="0">ID</option>
											<option value="1">Tài khoản</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-12" for="file">Hình:</label>
									<div class="col-sm-12">
										<input type="file" v-on:change="updateFile" accept="images/*">
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
	    </div>
	    <div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				  <thead>
				    <tr>
				      <th>Hình</th>
				      <th>Tên game</th>
				      <th>Cần</th>
				      <th>Tiền tệ</th>
				      <th>Tiền tệ viết tắt</th>
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
	@if(session('success'))
		alert('{{ session('success') }}');
	@endif
	
	var app = new Vue({
		el: '#app',
		data: function() {
			return {
				gameForm: {
					id: 0,
					name: '',
					type: 0,
					currency: '',
					sort_currency: '',
					picture: null
				},
				action: '',
				dataTable: null
			}
		},
		computed: {
			actionLabel() {
				if (this.action === 'add') {
					return 'Thêm';
				} else {
					return 'Sửa';
				}
			}
		},
		mounted() {
			this.getListGame();
		},
		methods: {
			updateFile(e) {
				this.gameForm.picture = e.target.files[0];
			},
			getListGame() {
				$.get(route('admin.datatables.game')).then(list_game => {
					this.dataTable = $('#dataTable').DataTable({
						data: list_game,
				        columns: [
				            { data: 'picture', orderable: false, searchable: false },
				            { data: 'name' },
				            { data: 'type' },
				            { data: 'currency' },
				            { data: 'sort_currency' },
				            { data: 'actions', orderable: false, searchable: false }
				        ]
					});
				});
			},
			actions() {
				let formData = new FormData();
				formData.append('name', this.gameForm.name);
				formData.append('picture', this.gameForm.picture);
				formData.append('type', this.gameForm.type);
				formData.append('currency', this.gameForm.currency);
				formData.append('sort_currency', this.gameForm.sort_currency);

				let url;
				if (this.action === 'add') {
					url = route('admin.game.store');
				} else {
					formData.append('_method', 'PATCH');
					url = route('admin.game.update', this.gameForm.id);
				}
				$.ajax({
					url: url,
					data: formData,
					method: 'post',
					cache: false,
					contentType: false,
					processData: false,
					success: (resp) => {
						if (resp === 'ok') {
							alert('Thêm thành công!');
							location.reload();
						}
					},
					error: function(resp) {
						alert(resp.responseText);
					}
				});
			},
			editGame(id) {
				this.action = 'edit';
				this.gameForm.id = id;

				$.get(route('admin.game.edit', id)).then(game => {
					this.gameForm.type = game.type;
					this.gameForm.name = game.name;
					this.gameForm.currency = game.currency;
					this.gameForm.sort_currency = game.sort_currency;
				});
			},
			deleteGame(id) {
				let conf = confirm('Bạn có chắc muốn xóa Game này chứ? Khi xóa game này bạn sẽ bị mất dữ liệu gói theo Game!!!');
				if (!conf) {
					return;
				}
				$.ajax({
					url: route('admin.game.destroy', id),
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