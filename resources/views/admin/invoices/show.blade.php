@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix">
                <span class="panel-title"><h2>Invoice</h2></span>
                <div class="float-left my-3">
                    <a href="{{route('invoices.index')}}" class="btn btn-warning mx-2"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                    <a href="{{route('invoices.edit', $invoice)}}" class="btn btn-primary mx-2"><i class="fa fa-pencil-alt" aria-hidden="true"></i> Edit</a>
                    <form class="form-inline float-right mx-2" method="post"
                        action="{{route('invoices.destroy', $invoice)}}"
                        onsubmit="return confirm('Are you sure?')"
                    >
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                </div>
                <div class="float-right">
                    <a href="{{route('invoices.print_invoice', $invoice)}}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Invoice No.</label>
                        <p>{{$invoice->invoice_no}}</p>
                    </div>
                    <div class="form-group">
                        <label>Grand Total</label>
                        <p>KSH. {{$invoice->grand_total}}</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Client</label>
                        <p>{{$invoice->client}}</p>
                    </div>
                    <div class="form-group">
                        <label>Client Address</label>
                        <pre class="pre">{{$invoice->client_address}}</pre>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Title</label>
                        <p>{{$invoice->title}}</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Invoice Date</label>
                            <p>{{$invoice->invoice_date}}</p>
                        </div>
                        <div class="col-sm-6">
                            <label>Due Date</label>
                            <p>{{$invoice->due_date}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->products as $product)
                        <tr>
                            <td class="table-name">{{$product->name}}</td>
                            <td class="table-price">KSH. {{$product->price}}</td>
                            <td class="table-qty">{{$product->qty}}</td>
                            <td class="table-total text-right">KSH. {{$product->qty * $product->price}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Sub Total</td>
                        <td class="table-amount">KSH. {{$invoice->sub_total}}</td>
                    </tr>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Discount</td>
                        <td class="table-amount">KSH. {{$invoice->discount}}</td>
                    </tr>
                    <tr>
                        <td class="table-empty" colspan="2"></td>
                        <td class="table-label">Grand Total</td>
                        <td class="table-amount">KSH. {{$invoice->grand_total}}</td>
                    </tr>
                </tfoot>
            </table>
            {{-- INVOICE PAYMENTS --}}
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th><th>Payment No.</th><th>Amount Paid</th><th>Balance</th><th>Tenant</th><th>Payment Date</th><th>Payment Type</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($invoice->payments()->count() > 0)
                        @foreach($invoice->payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->payment_no }}</td>
                                <td>{{ $payment->amount_paid }}</td>
                                <td>{{ $payment->balance }}</td>
                                <td>{{ $payment->tenant->surname }}</td>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ $payment->payment_type }}</td>
                                <td><a href="{{ url('/admin/payments/' . $payment->id) }}" title="View Payment"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a></td>
                            </tr>
                        @endforeach
                    @else
                        <b>NO PAYMENTS FOR THIS INVOICE!</b>
                    @endif
                </tbody>       
            </table>
        </div>
    </div>
@endsection

<script type="text/javascript">
    function print_invoice() {
        window.print();
    }
</script>