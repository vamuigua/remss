@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Payment No. {{ $payment->payment_no }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/payments') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/payments/' . $payment->id . '/edit') }}" title="Edit Payment"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/payments' . '/' . $payment->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Payment" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>

                        <div class="float-right">
                            <a href="{{route('payments.print_receipt', $payment)}}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print Receipt</a>
                        </div>
                        
                        <br/>
                        <br/>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Payment No. </th><td>{{ $payment->payment_no }}</td></tr>
                                    <tr><th> Tenant Name </th>
                                        <td> <a href="{{ url('/admin/tenants/' . $payment->tenant->id) }}">{{ $payment->tenant->surname }} {{ $payment->tenant->other_names }}</a> </td>
                                    </tr>
                                    <tr><th> Invoice No. </th>
                                        <td> <a href="{{ url('/admin/invoices/' . $payment->invoice->id) }}">{{ $payment->invoice->invoice_no  }}</a> </td>
                                    </tr>
                                    <tr><th> Payment Type </th><td> {{ $payment->payment_type }} </td></tr>
                                    <tr><th> Payment Date </th><td> {{ $payment->payment_date }} </td></tr>
                                    <tr><th> Previous Balance </th><td> {{ $payment->prev_balance }} </td></tr>
                                    <tr><th> Amount Paid </th><td> {{ $payment->amount_paid }} </td></tr>
                                    <tr><th> Balance </th><td> {{ $payment->balance }} </td></tr>
                                    <tr><th> Comments </th><td> {{ $payment->comments }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
