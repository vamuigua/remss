@extends('layouts.tenant')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix my-2">
                <span class="panel-title"><h2>Invoices</h2></span>
                <a href="{{route('tenant.payments.create')}}" class="btn btn-success btn-sm my-3 p-3" title="Add New Payment">
                    <i class="fa fa-plus" aria-hidden="true"></i> Make New Payment
                </a>
            </div>
        </div>
        <div class="panel-body">
            @if($invoices->count())
            <table id="datatable" class="table table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice No.</th>
                        <th>Grand Total</th>
                        <th>Client</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$invoice->invoice_no}}</td>
                            <td>KSH. {{$invoice->grand_total}}</td>
                            <td>{{$invoice->tenant->surname}} {{$invoice->tenant->other_names}}</td>
                            <td>{{$invoice->invoice_date}}</td>
                            <td>{{$invoice->due_date}}</td>
                            <td>{{$invoice->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('tenant.invoices.show', $invoice)}}" class="btn btn-success btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $invoices->render() !!}
            @else
                <div class="invoice-empty">
                    <p class="invoice-empty-title">
                        <b>You have No Invoices.</b>
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection