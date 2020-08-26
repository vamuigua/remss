<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvoicePaidNotification;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Invoice;
use App\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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

        // get active invoices for the currently logged in tenant
        $invoices = $user->tenant->invoices->where('status', 'active');

        // get the payment_no of the last payment
        $last_payment_no = DB::table('payments')->latest('id')->pluck('payment_no')->first();
        $new_payment_no = $last_payment_no + 1;

        return view('tenant.payments.create', compact('payment', 'user', 'new_payment_no', 'invoices'));
    }

    // Confirmation for Payment Page
    public function confirmationPayment(Request $request)
    {
        // validate the request from the form
        $this->validatedData = $this->validatePaymentsRequest($request);
        $payment_details = $request;

        // get the invoice no for the invoice selected
        $invoice = Invoice::findOrFail($this->validatedData['invoice_id']);
        $invoice_no = $invoice->invoice_no;

        return view('tenant.payments.confirmation', compact('payment_details', 'invoice_no'));
    }

    // Processes payment for an Mpesa transaction
    public function paymentsStore(Request $request)
    {
        // validate the request from the form
        $this->validatedData = $this->validatePaymentsRequest($request);

        $invoice_id = $this->validatedData['invoice_id'];
        $invoice = Invoice::findOrFail($invoice_id);
        $invoice_no = $invoice->invoice_no;

        $amount_paid = $this->validatedData['amount_paid'];

        // Create a new payment with the validated data
        $payment = Payment::create(array_merge(
            $this->validatedData,
            ['payment_type' => 'mpesa'],
        ));

        $payment_id = $payment->id;

        // Process Payment through Mpesa
        return redirect()->action(
            'Mpesa\\MpesaController@C2B_simulate',
            [$amount_paid, $invoice_no, $payment_id]
        );
    }

    // Complete and Finalize Mpesa Payment
    public function completePayment($payment_id)
    {
        // find the Payment made
        $payment = Payment::findOrFail($payment_id);

        // confirm to the payment that the mpesa transaction was successful
        $payment->mpesa_confirmation = "1";
        $payment->save();

        $this->checkPayementBalance($payment);
        $this->sendInvoicePaidNotification($payment);

        return redirect('/tenant/payments/' . $payment->id)->with('flash_message', 'Payment Made through Mpesa! You will receive a Payment Notification shortly');
    }

    // checks if the last payment has a balance
    public function checkPayementBalance(Payment $payment)
    {
        // find the balance of the payment
        $balance = $payment->balance;

        // checks if the final balance of the invoice_id was paid thus setting the status of the invoice_id to closed
        if ($balance == '0') {
            $id = $payment->invoice_id;
            $invoice = Invoice::findOrFail($id);
            $invoice->status = 'closed';
            $invoice->save();
        }
    }

    // sends invoice paid noification to tenant and admin
    public function sendInvoicePaidNotification(Payment $payment)
    {
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
    }

    //Adds payment to the system after successful approval from PayPal
    public function postPaypalPayment(Request $request)
    {
        // get payment details
        $payment_no = $request->get('payment_no');
        $tenant_id = $request->get('tenant_id');
        $invoice_id = $request->get('invoice_id');
        $payment_type = $request->get('payment_type');
        $payment_date = $request->get('payment_date');
        $amount_paid = $request->get('amount_paid');
        $prev_balance = $request->get('prev_balance');
        $balance = $request->get('balance');
        $comments = $request->get('comments');

        try {
            // Add new PayPal payment to the DB
            $payment = Payment::create([
                'payment_no' => $payment_no,
                'tenant_id' => $tenant_id,
                'invoice_id' => $invoice_id,
                'payment_type' => $payment_type,
                'payment_date' => $payment_date,
                'amount_paid' => $amount_paid,
                'prev_balance' => $prev_balance,
                'balance' => $balance,
                'comments' => $comments
            ]);

            $this->checkPayementBalance($payment);
            $this->sendInvoicePaidNotification($payment);

            $payment_id = $payment->id;
            $response = "success";

            return response()->json(array('response' => $response, 'payment_id' => $payment_id), 200);
        } catch (\Throwable $th) {
            Log::error('Failed to create Payment: ' . $th->getMessage());
            $response = "failed";

            return response()->json(array('response' => $response), 200);
        }
    }

    // validates payment details
    public function validatePaymentsRequest(Request $request)
    {
        return $request->validate([
            'payment_no' => 'required',
            'tenant_id' => 'required',
            'invoice_id' => 'required',
            'payment_date' => 'required|date',
            'prev_balance' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            'comments' => 'required',
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
