<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Notifications\InvoicePaidNotification;
use App\User;
use App\Invoice;
use App\Payment;
use App\Notice;
use Illuminate\Support\Carbon;

class UsersController extends Controller
{

    private $validatedData = '';

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

    public function paymentsCreate(){
        $user = Auth::user();
        $payment = new Payment();

        return view ('user.payments.create', compact('payment', 'user')); 
    }

    public function paymentsStore(Request $request){
        // validate the request from the form
        $this->validatedData = $this->validatePaymentsRequest($request);

        $invoice_id = $this->validatedData['invoice_id'];
        $invoice = Invoice::find($invoice_id);
        $invoice_no = $invoice->invoice_no;

        $amount_paid = $this->validatedData['amount_paid'];
        $payment_type = $this->validatedData['payment_type'];
        
        $balance = $this->validatedData['balance'];

        // Create a new payment with the validated data
        $payment = Payment::create($this->validatedData);

        // checks if the final balance of the invoice_id was paid thus setting the status of the invoice_id to closed
        if($balance == '0'){
            $id = $this->validatedData['invoice_id'];
            $invoice = Invoice::findOrFail($id);
            $invoice->status = 'closed';
            $invoice->save();
        }

        // Send InvoicePaid Noticifaction to Tenant
        $tenant_id = $this->validatedData['tenant_id'];
        $user = User::findOrFail($tenant_id);
        $when = Carbon::now()->addSeconds(5);
        $user->notify((new InvoicePaidNotification($payment))->delay($when));

        // Send InvoicePaid Noticifaction to Admin
        $users = User::all();
        foreach ($users as $user) {
            if($user->hasRole('admin')){
                $user->notify((new InvoicePaidNotification($payment))->delay($when));
            }
        }

        // check the method of payment
        if($payment_type == "mpesa"){
            return redirect()->action(
                'Mpesa\\MpesaController@C2B_simulate', [$amount_paid, $invoice_no]
            );
        }elseif($payment_type == "paypal") {
            dd($payment_type);
        }

        return redirect('user/payments')->with('flash_message', 'Payment Made! You will receive a Payment Notification shortly');
    }

    public function validatePaymentsRequest(Request $request){
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

    // Notices index
    public function notices(Request $request){
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $notices = Notice::where('subject', 'LIKE', "%$keyword%")
                ->orWhere('message', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $notices = Notice::latest()->paginate($perPage);
        }

        return view ('user.notices.index', compact('notices'));   
    }

    // Notices Show 
    public function noticesShow($id){
        $notice = Notice::findOrFail($id);
        return view ('user.notices.show', compact('notice'));   
    }

    // Notifications

    // Mark all Notifications as Read
    public function markNotificationsAsRead(){
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('flash_message', 'All Notifications Marked as Read!');;   
    }

    // Notifications Index
    public function notifications(Request $request){
        $perPage = 25;
        $user = Auth::user();

        $notifications = $user->notifications;

        return view ('user.notifications.index', compact('notifications'));   
    }

    // Mark specific Notification as Read
    public function notificationRead($id){
        $user = Auth::user();
        $user->notifications->find($id)->markAsRead();

        return redirect()->back()->with('flash_message', 'Notification Marked as Read!');  
    }
}
