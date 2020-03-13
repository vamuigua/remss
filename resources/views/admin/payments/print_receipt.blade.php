<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Receipt_{{$payment->payment_no}}_{{$payment->tenant->surname}}_{{$payment->tenant->other_names}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- All CSS Compiled Assets --}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="clearfix">
            <span class="panel-title"><h2>Receipt</h2></span>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>DATE</label>
                    <p>{{date('d-M-Y')}}</p>
                </div>
                <div class="form-group">
                    <label>Receipt No.</label>
                    <p>{{$payment->payment_no}}</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>From:</label>
                    <p>{{$payment->tenant->surname}} {{$payment->tenant->other_names}}</p>
                </div>
                <div class="form-group">
                    <label>To:</label>
                    <p>REMMS</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Invoice Ref:</label>
                    <p>{{$payment->invoice->invoice_no}}</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Amount to be received</th>
                        <th>Amount received</th>
                        <th>Balance due</th>
                        <th>Paid by</th>
                    </tr>
                </thead>
                <tbody>
                    <td class="table-prev_balance">KSH. {{$payment->prev_balance}}</td>
                    <td class="table-received">KSH. {{$payment->amount_paid}}</td>
                    <td class="table-balance">KSH. {{$payment->balance}}</td>
                    <td class="table-paidBy">{{$payment->payment_type}}</td>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="table-label"><b>Comments:</b></td>
                        <td class="table-empty" colspan="3">{{$payment->comments}}</td>
                    </tr>
                    <tr>
                        <td class="table-label">STAMP</td>
                        <td class="table-empty" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="table-label">Signature</td>
                        <td class="table-empty" colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
