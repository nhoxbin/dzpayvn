<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function show(User $user) {
        return response($user);
    }

    public function update(Request $request, User $user) {
        $user->manage_game = isset($request->manage_game) ? json_encode($request->manage_game) : null;
        $user->cash = $request->cash;
        $user->save();

        return redirect()->back()->withSuccess('Thiết lập nhân viên thành công!');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->back()->withSuccess('Xóa thành công.');
    }
}
