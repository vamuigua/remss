<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenant;
use App\House;
use App\Invoice;
use App\Payment;
use App\Notice;
use App\Expenditure;
use App\WaterReading;

class AdminController extends Controller
{
    public function index(){
        $houses = House::all();
        $tenants = Tenant::all();
        $invoices = Invoice::all();
        $payments = Payment::all();
        $notices = Notice::all();
        $expenditures = Expenditure::all();
        $water_readings = WaterReading::all();
        return view ('admin.dashboard', compact('tenants', 'houses', 'invoices', 'payments', 'notices', 'expenditures','water_readings'));   
    }
}
