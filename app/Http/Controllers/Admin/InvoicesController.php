<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\User;
use App\Tenant;
use App\Invoice;
use App\InvoiceProduct;
use App\Notifications\InvoiceSentNotification;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    use Notifiable;

    public function index()
    {
        $perPage = Invoice::count();
        $invoices = Invoice::orderBy('created_at', 'desc')
            ->paginate($perPage);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        $invoice = new Invoice();
        return view('admin.invoices.create', compact('tenants', 'invoice'));
    }

    public function store(Request $request)
    {
        // validate request from create form
        $validatedRequest = $this->validate($request, [
            'invoice_no' => 'required|alpha_dash|unique:invoices',
            'tenant_id' => 'required|max:255',
            'client_address' => 'required|max:255',
            'status' => 'required|max:255',
            'invoice_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'title' => 'required|max:255',
            'discount' => 'required|numeric|min:0',
            'products.*.name' => 'required|max:255',
            'products.*.price' => 'required|numeric|min:1',
            'products.*.qty' => 'required|integer|min:1'
        ]);

        // collect all the products from the request
        $products = collect($request->products)->transform(function ($product) {
            $product['total'] = $product['qty'] * $product['price'];
            return new InvoiceProduct($product);
        });

        // check if the products from the request is empty
        if ($products->isEmpty()) {
            return response()
                ->json([
                    'products_empty' => ['One or more Product is required.']
                ], 422);
        }

        $data = $request->except('products');
        $data['sub_total'] = $products->sum('total');
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        // create an invoice with the data and save the products with the relationship
        $invoice = Invoice::create($data);

        $invoice->products()->saveMany($products);

        // Send Invoice Noticifaction to Tenant
        $tenant_id = $validatedRequest['tenant_id'];
        $user = User::findOrFail($tenant_id);
        $when = Carbon::now()->addSeconds(5);
        $user->notify((new InvoiceSentNotification($invoice))->delay($when));

        // return a json response on successful creation of an invoice
        return response()
            ->json([
                'created' => true,
                'id' => $invoice->id
            ]);
    }

    public function show($id)
    {
        $invoice = Invoice::with('products')->findOrFail($id);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $tenants = Tenant::all();
        $invoice = Invoice::with('products')->findOrFail($id);
        return view('admin.invoices.edit', compact('invoice', 'tenants'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'invoice_no' => 'required|alpha_dash|unique:invoices,invoice_no,' . $id . ',id',
            'tenant_id' => 'required|max:255',
            'client_address' => 'required|max:255',
            'invoice_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'title' => 'required|max:255',
            'discount' => 'required|numeric|min:0',
            'products.*.name' => 'required|max:255',
            'products.*.price' => 'required|numeric|min:1',
            'products.*.qty' => 'required|integer|min:1'
        ]);

        $invoice = Invoice::findOrFail($id);

        $products = collect($request->products)->transform(function ($product) {
            $product['total'] = $product['qty'] * $product['price'];
            return new InvoiceProduct($product);
        });

        if ($products->isEmpty()) {
            return response()
                ->json([
                    'products_empty' => ['One or more Product is required.']
                ], 422);
        }

        $data = $request->except('products');
        $data['sub_total'] = $products->sum('total');
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $invoice->update($data);

        InvoiceProduct::where('invoice_id', $invoice->id)->delete();

        $invoice->products()->saveMany($products);

        return response()
            ->json([
                'updated' => true,
                'id' => $invoice->id
            ]);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        InvoiceProduct::where('invoice_id', $invoice->id)
            ->delete();

        $invoice->delete();

        return redirect()
            ->route('invoices.index');
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
