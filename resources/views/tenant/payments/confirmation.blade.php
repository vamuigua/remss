@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">Confirm Payment for Invoice</div>
                    <div class="card-body">
                        <a href="{{ url('/tenant/payments/create') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br>
                        <br>
                        <h2>Confirm Payment Details</h2>
                        <hr>
                        <div class="p-3">
                            <form method="POST" action="{{ route('tenant.paymentsStore') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="payment_no" class="control-label">{{ 'Payment No' }}</label>
                                            <input class="form-control" name="payment_no" type="text" id="payment_no" value="{{$payment_details['payment_no']}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tenant_id" class="control-label">{{ 'Tenant Name' }}</label>
                                            <input class="form-control" name="tenant_id" type="text" id="tenant_id" value="{{$payment_details['tenant_id']}}" readonly hidden>
                                            <input class="form-control" name="tenant_name" type="text" id="tenant_name" value="{{$payment_details['tenant_name']}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="invoice_id" class="control-label">{{ 'Invoice No' }}</label>
                                            <input class="form-control" name="invoice_id" type="text" id="invoice_id" value="{{$payment_details['invoice_id']}}" readonly hidden>
                                            <input class="form-control" name="invoice_no" type="text" id="invoice_no" value="{{ $invoice_no }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="prev_balance" class="control-label">{{ 'Previous Balance' }}</label>
                                            <input class="form-control" name="prev_balance" type="text" id="prev_balance" value="{{$payment_details['prev_balance']}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="amount_paid" class="control-label">{{ 'Amount Paid' }}</label>
                                            <input class="form-control" name="amount_paid" type="text" id="amount_paid" value="{{$payment_details['amount_paid']}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="balance" class="control-label">{{ 'Current Balance' }}</label>
                                            <input class="form-control" name="balance" type="text" id="balance" value="{{$payment_details['balance']}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="payment_date" class="control-label">{{ 'Payment Date' }}</label>
                                            <input class="form-control" name="payment_date" type="text" id="payment_date" value="{{$payment_details['payment_date']}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <label for="comments" class="control-label">{{ 'Comments' }}</label>
                                            <textarea class="form-control" rows="5" name="comments" id="comments" type="textarea" readonly>{{$payment_details['comments']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                {{-- PAYMENT BUTTONS --}}
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="btn btn-success btn-lg btn-block" type="submit" value="Lipa Na Mpesa">
                                            <img src="/img/lipa_na_mpesa_logo.png" alt="Lipa na Mpesa Logo" class="img-fluid">
                                        </div>
                                        <div class="col-md-6">
                                            <div id="paypal-button-container"></div>
                                            <img src="/img/paypal_logo.png" alt="PayPal Logo" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PAYPAL Scripts--}}
    @push('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id=ARbFvQo2ChnibuZXHe_9ga1IUWnqvHcr2O8U7Ld1E7AvhDdw0XtY-YX-NEp2t2R08xIPW2MbpyAsFcpg&currency=USD" data-sdk-integration-source="button-factory"></script>
    <script>
        // Set up the Transacation
        paypal.Buttons({
            style: {
            shape: 'rect',
            color: 'gold',
            layout: 'horizontal',
            label: 'pay',
        },
            createOrder: function(data, actions) {
                // get paid amount and convert FROM KSH to USD
                // assumption that 1 USD = 100 KSH
                var pay_amount = $("#amount_paid").val() / 100;

                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "" + pay_amount + ""
                        }
                    }]
                });
            },
            // Capture the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction completed by ' + details.payer.name.given_name + '!');
                    submitPaypalPayment();
                });
            }
        }).render('#paypal-button-container');

        function submitPaypalPayment(){
            alert("Submitting Payment...");

            //get Payment details 
            var _token = $('input[name="_token"]').val();
            var payment_no = $('#payment_no').val();
            var tenant_id = $('#tenant_id').val();
            var invoice_id = $('#invoice_id').val();
            var payment_type = $('#payment_type').val();
            var payment_date = $('#payment_date').val();
            var amount_paid = $('#amount_paid').val();
            var prev_balance = $('#prev_balance').val();
            var balance = $('#balance').val();
            var comments = $('#comments').val();
            var payment_type = 'PayPal';

            // send form data for processing
            $.ajax({
                url: "/tenant/payments/postPaypalPayment",
                method: "POST",
                data: {
                    _token: _token,
                    payment_no: payment_no,
                    tenant_id: tenant_id,
                    invoice_id: invoice_id,
                    payment_type: payment_type,
                    payment_date: payment_date,
                    amount_paid: amount_paid,
                    prev_balance: prev_balance,
                    balance: balance,
                    comments: comments,
                },
                success: function (data) {
                    if (data.response == "success") {
                        alert('Payment SUCCESSFUL!'); 
                        window.location.href = "/tenant/payments/" + data.payment_id;
                    }else if(data.response == "failed"){
                        alert('Payment FAILED!'); 
                        window.location.href = "/tenant/payments";
                    }
                }
            });
        }
    </script>
    @endpush
@endsection