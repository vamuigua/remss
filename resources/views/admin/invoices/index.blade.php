@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix my-2">
                <span class="panel-title"><h2>Invoices</h2></span>
                <a href="{{route('invoices.create')}}" class="btn btn-success float-left"><i class="fa fa-plus" aria-hidden="true"></i> Create Invoice</a>
            </div>
        </div>
        <div class="panel-body">
            @if($invoices->count())
            <table id="datatable" class="table table-hover table-striped table-bordered">
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
                                <a href="{{route('invoices.show', $invoice)}}" class="btn btn-success btn-sm">View</a>
                                <a href="{{route('invoices.edit', $invoice)}}" class="btn btn-primary btn-sm">Edit</a>
                                <form class="form-inline" method="post"
                                    action="{{route('invoices.destroy', $invoice)}}"
                                    onsubmit="return confirm('Are you sure?')"
                                    style="display:inline"
                                >
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $invoices->render() !!}
            @else
                <div class="invoice-empty">
                    <p class="invoice-empty-title">
                        No Invoices were created.
                        <a href="{{route('invoices.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Create Now!</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection