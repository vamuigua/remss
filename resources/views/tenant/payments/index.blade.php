@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h2>Payments</h2></div>
                    <div class="col-md-3">
                        <a href="{{route('tenant.payments.create')}}" class="btn btn-success btn-sm my-3 p-3" title="Add New Payment">
                            <i class="fa fa-plus" aria-hidden="true"></i> Make New Payment
                        </a>
                    </div>
                    <div class="card-body">

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Payment No.</th><th>Amount Paid</th><th>Tenant</th><th>Payment Date</th>
                                        <th>Payment Type</th><th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->payment_no }}</td>
                                        <td>{{ $item->amount_paid }}</td>
                                        <td>{{ $item->tenant->surname }}</td>
                                        <td>{{ $item->payment_date }}</td>
                                        <td>{{ $item->payment_type }}</td>
                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('/tenant/payments/' . $item->id) }}" title="View Payment"><button class="btn btn-success btn-sm">View</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $payments->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
