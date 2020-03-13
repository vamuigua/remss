@extends('layouts.user')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix my-2">
                <span class="panel-title"><h2>Invoices</h2></span>
                <form method="GET" action="{{route('user.invoices.index')}}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel-body">
            @if($invoices->count())
            <table class="table table-striped">
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
                                <a href="{{route('user.invoices.show', $invoice)}}" class="btn btn-success btn-sm">View</a>
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