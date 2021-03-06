<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaidNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Payment;
use App\Tenant;
use App\Invoice;

class PaymentsController extends Controller
{
    use Notifiable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = Payment::count();
        $payments = Payment::latest()->paginate($perPage);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $payment = new Payment();

        // get active invoices
        $invoices = Invoice::where('status', 'active')->get();

        // get the payment_no of the last payment
        $last_payment_no = DB::table('payments')->latest('id')->pluck('payment_no')->first();
        $new_payment_no = $last_payment_no + 1;

        return view('admin.payments.create', compact('invoices', 'payment', 'new_payment_no'));
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
        // save payment to DB
        $validatedData = $this->validateRequest($request);
        $balance = $validatedData['balance'];
        $payment = Payment::create(array_merge(
            $validatedData,
            ['tenant_id' => Invoice::findOrFail($validatedData['invoice_id'])->tenant->id]
        ));

        // checks if the final balance of the invoice_id was paid thus setting the status of the invoice_id to closed
        if ($balance == '0') {
            $id = $validatedData['invoice_id'];
            $invoice = Invoice::findOrFail($id);
            $invoice->status = 'closed';
            $invoice->save();
        }

        // Send InvoicePaid Noticifaction to Tenant 
        $tenant_user_id =  Invoice::findOrFail($validatedData['invoice_id'])->tenant->user_id;
        $user = User::findOrFail($tenant_user_id);
        $user->notify((new InvoicePaidNotification($payment, 'tenant')));

        // Grab all Admins only, remove Tenants from the query
        $users = User::all()->reject(function ($user) {
            return $user->hasRole('Admin') === false;
        });

        // Send InvoicePaid Noticifaction to Admin
        Notification::send($users, new InvoicePaidNotification($payment, 'admin'));

        return redirect('admin/payments/' . $payment->id)->with('flash_message', 'Payment added! You will receive a Payment Notification shortly.');
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
        return view('admin.payments.edit', compact('payment', 'tenants', 'invoices'));
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
        return redirect('admin/payments/' . $payment->id)->with('flash_message', 'Payment information updated!');
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
    public function validateRequest(Request $request)
    {
        return $request->validate([
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
    public function getInvoiceBalance(Request $request)
    {
        $invoice_id = $request->get('invoice_id');

        $last_payment_balance = DB::select('select `balance` from payments where invoice_id = :invoice_id ORDER BY `id` DESC LIMIT 1', ['invoice_id' => $invoice_id]);
        $invoice_status = DB::select('select `status` from invoices where id = :invoice_id ORDER BY `id` DESC LIMIT 1', ['invoice_id' => $invoice_id]);

        // checks if the invoice has any balance
        if ($last_payment_balance == null && $invoice_status[0]->status == 'active') {
            $invoice_grand_total = DB::select('select `grand_total` from invoices where id = :invoice_id ORDER BY `id` DESC LIMIT 1', ['invoice_id' => $invoice_id]);
            $balance = $invoice_grand_total[0]->grand_total;
        } else {
            if ($last_payment_balance[0]->balance == "0.00" && $invoice_status[0]->status == 'closed') {
                $balance = '0.00';
            } else if ($last_payment_balance[0]->balance != null && $invoice_status[0]->status == 'active') {
                $balance = $last_payment_balance[0]->balance;
            }
        }

        return response()->json(array('balance' => $balance), 200);
    }

    //print receipt for payment
    public function print_receipt($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.print_receipt', compact('payment'));
    }
}
