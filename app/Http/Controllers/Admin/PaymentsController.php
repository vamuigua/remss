<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Payment;
use App\Tenant;
use App\Invoice;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $payments = Payment::where('tenant_id', 'LIKE', "%$keyword%")
                ->orWhere('invoice_id', 'LIKE', "%$keyword%")
                ->orWhere('payment_type', 'LIKE', "%$keyword%")
                ->orWhere('payment_date', 'LIKE', "%$keyword%")
                ->orWhere('payment_no', 'LIKE', "%$keyword%")
                ->orWhere('amount_paid', 'LIKE', "%$keyword%")
                ->orWhere('balance', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $payments = Payment::latest()->paginate($perPage);
        }

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tenants = Tenant::all();
        $invoices = Invoice::all();
        $payment = new Payment();
        return view('admin.payments.create', compact('tenants','invoices', 'payment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        $balance = $validatedData['balance'];

        Payment::create($validatedData);

        // checks if the final balance of the invoice_id was paid thus setting the status of the invoice_id to closed
        if($balance == '0'){
            $id = $validatedData['invoice_id'];
            $invoice = Invoice::findOrFail($id);
            $invoice->status = 'closed';
            $invoice->save();
        }

        return redirect('admin/payments')->with('flash_message', 'Payment added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tenants = Tenant::all();
        $invoices = Invoice::all();
        $payment = Payment::findOrFail($id);

        return view('admin.payments.edit', compact('payment' , 'tenants', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validateRequest($request);
        
        $payment = Payment::findOrFail($id);
        $payment->update($validatedData);

        return redirect('admin/payments')->with('flash_message', 'Payment updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Payment::destroy($id);

        return redirect('admin/payments')->with('flash_message', 'Payment deleted!');
    }

    // Validates Payment Request Details
    public function validateRequest(Request $request){
        return $request->validate([
            'tenant_id' => 'required',
            'invoice_id' => 'required',
            'payment_type' => 'required',
            'payment_date' => 'required|date',
            'payment_no' => 'required',
            'prev_balance' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            'comments' => 'required'
        ]);
    }

    // Gets the balance of the last payment for the requested invoice_id
    public function getInvoiceBalance(Request $request){
        $invoice_id = $request->get('invoice_id');
        
        $last_payment_balance = DB::select('select `balance` from payments where invoice_id = :invoice_id ORDER BY `id` DESC LIMIT 1', ['invoice_id' => $invoice_id]);
        $invoice_status = DB::select('select `status` from invoices where id = :invoice_id ORDER BY `id` DESC LIMIT 1', ['invoice_id' => $invoice_id]);

        // checks if the invoice has any balance
        if($last_payment_balance == null && $invoice_status[0]->status == 'active')
        {
            $invoice_grand_total = DB::select('select `grand_total` from invoices where id = :invoice_id ORDER BY `id` DESC LIMIT 1', ['invoice_id' => $invoice_id]);
            $balance = $invoice_grand_total[0]->grand_total;
        }
        else
        {
            if($last_payment_balance[0]->balance == "0.00" && $invoice_status[0]->status == 'closed')
            {
                $balance = '0.00';
            }
            else if($last_payment_balance[0]->balance != null && $invoice_status[0]->status == 'active')
            {
                $balance = $last_payment_balance[0]->balance;
            }
        }
        
        return response()->json(array('balance'=> $balance), 200);
    }

    //print receipt for payment
    public function print_receipt($id){
        $payment = Payment::findOrFail($id);
        return view('admin.payments.print_receipt', compact('payment'));
    }
}
