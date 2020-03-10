<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\House;
use App\Invoice;
use App\Payment;
use App\Notice;

class AdminController extends Controller
{
    public function index(){
        $houses = House::all();
        $tenants = Tenant::all();
        $invoices = Invoice::all();
        $payments = Payment::all();
        $notices = Notice::all();
        return view ('admin.dashboard', compact('tenants', 'houses', 'invoices', 'payments', 'notices'));   
    }
}
