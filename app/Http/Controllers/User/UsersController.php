<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Invoice;
use App\Payment;

class UsersController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view ('user.dashboard', compact('user'));   
    }

    public function house(){
        $user = Auth::user();
        $house = $user->tenant->house;

        return view ('user.house', compact('house'));   
    }

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

        return view ('user.invoices.index', compact('invoices'));   
    }

    public function invoicesShow($id){
        $user = Auth::user();
        $invoices = $user->tenant->invoices;
        $invoice = $invoices->find($id);

        return view ('user.invoices.show', compact('invoice'));   
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

    public function payments(Request $request){
        $keyword = $request->get('search');
        $perPage = 25;

        $user = Auth::user();
        $tenant_id = $user->tenant->id;

        if (!empty($keyword)) {
            $payments = Payment::where('payment_type', 'LIKE', "%$keyword%")
                ->orWhere('payment_date', 'LIKE', "%$keyword%")
                ->orWhere('payment_no', 'LIKE', "%$keyword%")
                ->orWhere('prev_balance', 'LIKE', "%$keyword%")
                ->orWhere('amount_paid', 'LIKE', "%$keyword%")
                ->orWhere('balance', 'LIKE', "%$keyword%")
                ->orWhere('comments', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $payments = Payment::where('tenant_id','LIKE', $tenant_id)
                    ->latest()->paginate($perPage);
        }

        return view ('user.payments.index', compact('payments'));   
    }

    public function paymentsShow($id){
        $user = Auth::user();
        $payments = $user->tenant->payments;
        $payment = $payments->find($id);

        return view ('user.payments.show', compact('payment'));   
    }

    //print receipt for payment
    public function print_receipt($id){
        $payment = Payment::findOrFail($id);
        return view('admin.payments.print_receipt', compact('payment'));
    }
}
