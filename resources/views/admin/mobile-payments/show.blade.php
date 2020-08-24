@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Mobile Payment: {{ $mobilePayment->TransID }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/mobile-payments') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>

                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th>TransactionType</th><td>{{ $mobilePayment->TransactionType }}</td></tr>
                                    <tr><th> TransID </th><td> {{ $mobilePayment->TransID }} </td></tr>
                                    <tr><th> TransTime </th><td> {{ $mobilePayment->TransTime }} </td></tr>
                                    <tr><th> TransAmount </th><td> {{ $mobilePayment->TransAmount }} </td></tr>
                                    <tr><th> BusinessShortCode </th><td> {{ $mobilePayment->BusinessShortCode }} </td></tr>
                                    <tr><th> BillRefNumber </th><td> {{ $mobilePayment->BillRefNumber }} </td></tr>
                                    <tr><th> InvoiceNumber </th><td> {{ ($mobilePayment->InvoiceNumber) == null ? "Null" : $mobilePayment->InvoiceNumber }} </td></tr>
                                    <tr><th> OrgAccountBalance </th><td> {{ $mobilePayment->OrgAccountBalance }} </td></tr>
                                    <tr><th> ThirdPartyTransID </th><td> {{ ($mobilePayment->ThirdPartyTransID) == null ? "Null" : $mobilePayment->ThirdPartyTransID }} </td></tr>
                                    <tr><th> MSISDN </th><td> {{ $mobilePayment->MSISDN }} </td></tr>
                                    <tr><th> FirstName </th><td> {{ $mobilePayment->FirstName }} </td></tr>
                                    <tr><th> MiddleName </th><td> {{ $mobilePayment->MiddleName }} </td></tr>
                                    <tr><th> LastName </th><td> {{ $mobilePayment->LastName }} </td></tr>
                                    <tr><th> Created at </th><td> {{ $mobilePayment->created_at }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
