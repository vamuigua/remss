@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Pending Payments</h3></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Invoice No.</th><th>Due Date</th><th>Last Payment No.</th><th>Amount Paid</th><th>Balance</th><th>Payment Date</th>
                                        <th>Payment Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ url('/admin/invoices/' . $invoice->id) }}">{{ $invoice->invoice_no }}</a></td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td> <a href="{{ url('/admin/payments/' . $invoice->payments->last()->id) }}">{{ $invoice->payments->last()->payment_no }}</a></td>
                                        <td>{{ $invoice->payments->last()->amount_paid }}</td>
                                        <td>{{ $invoice->payments->last()->balance }}</td>
                                        <td>{{ $invoice->payments->last()->payment_date }}</td>
                                        <td>{{ $invoice->payments->last()->payment_type }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
