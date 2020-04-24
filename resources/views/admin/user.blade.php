@extends('admin.layouts.master')
@section('heading-name', 'Thành viên')
@section('content')
	<div class="container-fluid">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Danh sách thành viên</h6>
		    </div>
		    <div class="card-body">
		    	<!-- Modal cho nhân viên quản lý game -->
				<div class="modal fade" id="manageGameModal" tabindex="-1" role="dialog" aria-labelledby="crud" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="crud">NV quản lý game</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form id="manage-game-form" class="form-horizontal" :action="linkSelectUser" method="post">
									@csrf
									@method('patch')

									<div class="form-group">
										<label class="control-label col-sm-12" for="name">Tên:</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" placeholder="Mobiphone, VinaPhone, Viettel, ..." v-model="user.name" disabled>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-12" for="name">Số tiền:</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" name="cash" v-model="user.cash">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-12" for="name">Quản lý game</label>
									</div>
									<div v-for="game in games" class="form-check">
										<label class="form-check-label">
										    <input type="checkbox" class="form-check-input" name="manage_game[]" :value="game.id" :checked="userGameChecked(game.id)">@{{ game.name }}
										</label>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
								<button type="button" class="btn btn-primary" onclick="document.getElementById('manage-game-form').submit();">Lưu</button>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
					  <thead>
					    <tr>
					      <th>ID</th>
					      <th>Tên</th>
					      <th>Số tiền</th>
					      <th>Email</th>
					      <th>Phone</th>
					      <th>Chức vụ</th>
					      <th>Hành động</th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($users as $user)
						  	<tr>
						  		<td>{{ $user->id }}</td>
						  		<td>{{ $user->name }}</td>
						  		<td>{{ number_format($user->cash) }}₫</td>
						  		<td>{{ $user->email }}</td>
						  		<td>+84{{ $user->phone }}</td>
						  		<td>{!! $user->role ? '<span class="badge badge-primary">Admin</span>' : (isset($user->manage_game) ? '<span class="badge badge-info">Nhân viên</span>' : '<span class="badge badge-dark">Thành viên</span>') !!}</td>
						  		<td>
						  			<div class="btn-group btn-group-sm">
							  			<button class="btn btn-primary" @@click="getInfo({{ $user->id }})" data-toggle="modal" data-target="#manageGameModal">Sửa</button>
						  				<button class="btn btn-danger" onclick="document.getElementById('delete-user-form').submit();">Xóa</button>
						  			</div>
									<form id="delete-user-form" action="{{ route('admin.user.destroy', $user->id) }}" method="post" style="display: none;">
										@method('delete')
										@csrf
									</form>
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
				linkSelectUser: '',
				user: {},
				games: {}
			}
		},
		mounted() {
			$('#usersTable').DataTable();
		},
		methods: {
			getInfo(user_id) {
				this.getInfoUser(user_id);
				this.getAllGames();
			},
			getInfoUser(id) {
				this.linkSelectUser = route('admin.user.update', id);
				$.get(route('admin.user.show', id)).then(resp => {
					resp.manage_game = JSON.parse(resp.manage_game) || null;
					this.user = resp;
				})
			},
			getAllGames() {
				$.get(route('admin.game.all')).then(resp => {
					this.games = resp;
				})
			},
			userGameChecked(game_id) {
				if (this.user.manage_game) {
					return this.user.manage_game.includes(game_id.toString());
				} else {
					return false;
				}
			}
		}
	})
</script>
@endpush