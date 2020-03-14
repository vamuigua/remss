<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\User;
use App\Invoice;
use App\Payment;
use App\Notice;

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

    // Settings
    // Profile
     public function profile($id){
        $user = Auth::user($id);
        return view ('user.settings.profile', compact('user'));     
    }

    // Update Profile Picture
    public function updateProfilePic(Request $request){
        $request->validate(['image' => 'image']);

        if ($request->hasFile('image')) {
            $img_filePath = $request->file('image')->store('uploads/tenants_img', 'public');

            //resize uploaded tenant image
            $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
            $image->save();

            $user = Auth::user();
            $user->tenant->update(['image' => $img_filePath]);
        }

        return redirect()->back()->with('flash_message', 'Profile Photo updated!');
    }
}
