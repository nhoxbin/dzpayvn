<?php

namespace App\Http\Controllers\Admin\Bills;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TransferBill;

class TransferController extends Controller
{
    public function index() {
    	$transfer_bills = TransferBill::with('from', 'to')->get()->toArray();
    	return view('admin.bills.transfer', compact('transfer_bills'));
    }
}
