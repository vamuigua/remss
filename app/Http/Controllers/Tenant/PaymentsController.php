<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoicePaidNotification;
use App\User;
use App\Invoice;
use App\Payment;
use Illuminate\Support\Carbon;

class PaymentsController extends Controller
{
    private $validatedData = '';

    public function payments(Request $request)
    {
        $perPage = 25;

        $user = Auth::user();
        $tenant_id = $user->tenant->id;

        $payments = Payment::where('tenant_id', 'LIKE', $tenant_id)
            ->latest()->paginate($perPage);

        return view('tenant.payments.index', compact('payments'));
    }

    public function paymentsCreate()
    {
        $user = Auth::user();
        $payment = new Payment();

        return view('tenant.payments.create', compact('payment', 'user'));
    }

    public function paymentsStore(Request $request)
    {
        // validate the request from the form
        $this->validatedData = $this->validatePaymentsRequest($request);

        $invoice_id = $this->validatedData['invoice_id'];
        $invoice = Invoice::find($invoice_id);
        $invoice_no = $invoice->invoice_no;

        $amount_paid = $this->validatedData['amount_paid'];
        $payment_type = $this->validatedData['payment_type'];

        // Create a new payment with the validated data
        $payment = Payment::create($this->validatedData);
        $payment_id = $payment->id;

        // check the method of payment
        if ($payment_type == "mpesa") {
            return redirect()->action(
                'Mpesa\\MpesaController@C2B_simulate',
                [$amount_paid, $invoice_no, $payment_id]
            );
        } elseif ($payment_type == "paypal") {
            dd($payment_type);
        }
    }

    // Complete and Finalize a Payment
    public function completePayment($payment_id)
    {
        // find the Payment made
        $payment = Payment::findOrFail($payment_id);

        // confirm to the payment that the mpesa transaction was successful
        $payment->mpesa_confirmation = "1";
        $payment->save();

        // find the balance of the payment
        $balance = $payment->balance;

        // checks if the final balance of the invoice_id was paid thus setting the status of the invoice_id to closed
        if ($balance == '0') {
            $id = $payment->invoice_id;
            $invoice = Invoice::findOrFail($id);
            $invoice->status = 'closed';
            $invoice->save();
        }

        // Send InvoicePaid Noticifaction to Tenant
        $tenant_id = $payment->tenant_id;
        $user = User::findOrFail($tenant_id);
        $when = Carbon::now()->addSeconds(5);
        $user->notify((new InvoicePaidNotification($payment, 'user'))->delay($when));


        // Grab all Admins only, remove Tenants from the query
        $users = User::all()->reject(function ($user) {
            return $user->hasRole('Admin') === false;
        });

        // Send InvoicePaid Noticifaction to Admin
        Notification::send($users, new InvoicePaidNotification($payment, 'admin'));

        return redirect('/tenant/payments/' . $payment->id)->with('flash_message', 'Payment Made! You will receive a Payment Notification shortly');
    }

    public function validatePaymentsRequest(Request $request)
    {
        return $request->validate([
            'payment_no' => 'required',
            'tenant_id' => 'required',
            'invoice_id' => 'required',
            'payment_type' => 'required',
            'payment_date' => 'required|date',
            'prev_balance' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            'comments' => 'required',
            'mpesa_confirmation' => 'required'
        ]);
    }

    public function paymentsShow($id)
    {
        $payment = Payment::findOrFail($id);
        return view('tenant.payments.show', compact('payment'));
    }

    //print receipt for payment
    public function print_receipt($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.print_receipt', compact('payment'));
    }
}
