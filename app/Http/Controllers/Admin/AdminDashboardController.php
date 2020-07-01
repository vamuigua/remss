<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tenant;
use App\House;
use App\Invoice;
use App\Payment;
use App\Notice;
use App\Expenditure;
use App\WaterReading;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $houses = House::count();
        $tenants = Tenant::count();
        $invoices = Invoice::count();
        $payments = Payment::count();
        $notices = Notice::count();
        $expenditures = Expenditure::count();
        $water_readings = WaterReading::count();
        $pending_payments = Invoice::where('status', 'active')->count();

        $months = Expenditure::monthsOfTheYear();

        return view('admin.dashboard', compact('tenants', 'houses', 'invoices', 'payments', 'notices', 'expenditures', 'water_readings', 'months', 'pending_payments'));
    }
}
