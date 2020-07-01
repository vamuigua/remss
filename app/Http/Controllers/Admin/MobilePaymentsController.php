<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MobilePayment;
use Illuminate\Support\Facades\DB;

class MobilePaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mobilePayments = DB::table('mobile_payments')->latest()->get();
        return view('admin.mobile-payments.index', compact('mobilePayments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mobilePayment = MobilePayment::findOrFail($id);
        return view('admin.mobile-payments.show', compact('mobilePayment'));
    }
}
