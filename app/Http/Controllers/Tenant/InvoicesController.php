<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;

class InvoicesController extends Controller
{
    public function invoices(Request $request){
        $keyword = $request->get('search');
        $perPage = 25;

        $user = Auth::user();
        $tenant_id = $user->tenant->id;

        if (!empty($keyword)) {
            $invoices = Invoice::where('invoice_no', 'LIKE', "%$keyword%")
                ->orWhere('invoice_date', 'LIKE', "%$keyword%")
                ->orWhere('due_date', 'LIKE', "%$keyword%")
                ->orWhere('title', 'LIKE', "%$keyword%")
                ->orWhere('sub_total', 'LIKE', "%$keyword%")
                ->orWhere('discount', 'LIKE', "%$keyword%")
                ->orWhere('grand_total', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $invoices = Invoice::where('tenant_id','LIKE', $tenant_id)
                    ->latest()->paginate($perPage);
        }

        return view ('tenant.invoices.index', compact('invoices'));   
    }

    public function invoicesShow($id){
        $user = Auth::user();
        $invoices = $user->tenant->invoices;
        $invoice = $invoices->find($id);

        return view ('tenant.invoices.show', compact('invoice'));   
    }

    public function print_invoice($id)
    {
        $invoice = Invoice::with('products')->findOrFail($id);
        return view('admin.invoices.print_invoice', compact('invoice'));
    }

    public function pdf_invoice($id)
    {
        $invoice = Invoice::with('products')->findOrFail($id);
        return view('admin.invoices.pdf_invoice', compact('invoice'));

        // $pdf = PDF::loadView('admin.invoices.pdf_invoice', array('data' => $data));
        // return $pdf->download('invoice.pdf');
    }
}
