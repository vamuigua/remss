<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;

class TenantController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $active_invoices = Invoice::where('status', 'active')->count();
        $unread_notifications = $user->unreadNotifications->count();
        return view('tenant.dashboard', compact('user', 'active_invoices', 'unread_notifications'));
    }

    public function house()
    {
        $user = Auth::user();
        $house = $user->tenant->house;

        return view('tenant.house', compact('house'));
    }
}
