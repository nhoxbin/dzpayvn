<?php

namespace App\Http\Controllers\Admin;

use App\Sim;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SimController extends Controller
{
    public function index() {
        return view('admin.sim');
    }

    public function store(Request $request) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        $request->validate([
            'name' => 'required|string',
            'discount' => 'required|string',
            'fast_discount' => 'required|string',
            'slow_discount' => 'required|string'
        ]);
        Sim::create($request->all());
        return response(['errors' => null, 'message' => 'Lưu thành công!'], 201);
    }

    public function edit(Request $request, Sim $sim) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        return response($sim, 200);
    }

    public function update(Request $request, Sim $sim) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        $sim->update($request->all());
        return response(['errors' => null, 'message' => 'Cập nhật thành công!'], 200);
    }

    public function maintenance() {
        $sims = Sim::all();
        foreach ($sims as $sim) {
            $sim->maintenance = !$sim->maintenance;
            $sim->save();
        }
        return back()->withSuccess('Thành công!');
    }

    public function destroy(Request $request, Sim $sim) {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        $sim->delete();
        return response('Xóa thành công!', 200);
    }
}
