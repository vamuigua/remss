@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Mobile (Mpesa Paybill) Payments</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>TransID</th><th>TransAmount</th><th>BillRefNumber / Invoice No.</th><th>Name</th><th>Created at<th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($mobilePayments as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->TransID }}</td>
                                        <td>{{ $item->TransAmount }}</td>
                                        <td>{{ $item->BillRefNumber }}</td>
                                        <td>{{ $item->FirstName }} {{ $item->MiddleName }} {{ $item->LastName }}</td>
                                        <td>{{ $item->created_at}}</td>
                                        <td>
                                            <a href="{{ url('/admin/mobile-payments/' . $item->id) }}" title="View Payment"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        </td>
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
