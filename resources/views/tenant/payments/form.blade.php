<div class="form-group {{ $errors->has('payment_no') ? 'has-error' : ''}}">
    <label for="payment_no" class="control-label">{{ 'Payment No' }}</label>
    <input class="form-control" name="payment_no" type="text" id="payment_no" value="{{ isset($payment->payment_no) ? $payment->payment_no : $new_payment_no }}" readonly>
    {!! $errors->first('payment_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('tenant_id') ? 'has-error' : ''}}">
    <label for="tenant_id" class="control-label">{{ 'Tenant Name' }}</label>
    <input class="form-control" name="tenant_id" type="text" id="tenant_id" value="{{ isset($user->tenant->id) ? $user->tenant->id : old('tenant_id')}}" readonly hidden>
    <input class="form-control" name="tenant_name" type="text" id="tenant_names" value="{{ isset($user->tenant->id) ? $user->tenant->surname." ".$user->tenant->other_names : old('tenant_names')}}" readonly>
    {!! $errors->first('tenant_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('invoice_id') ? 'has-error' : ''}}">
    <label for="invoice_id" class="control-label">{{ 'Invoice No.' }}</label>
    <select name="invoice_id" class="form-control selectpicker tenant_invoice_id" data-live-search="true" id="invoice_id">
        <option selected="selected">Choose an Invoice</option>
        @foreach ($invoices as $invoice)
            <option value="{{ $invoice->id }}" {{ (isset($invoice->id)) && ($payment->invoice_id == $invoice->id) ? 'selected' : old('invoice_id')}}>{{ $invoice->invoice_no }}</option>
        @endforeach
    </select>
    {!! $errors->first('invoice_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('prev_balance') ? 'has-error' : ''}}">
    <label for="prev_balance" class="control-label">{{ 'Previous Balance' }}</label>
    <input class="form-control" name="prev_balance" type="number" id="prev_balance" value="{{ isset($payment->prev_balance) ? $payment->prev_balance : old('prev_balance')}}" readonly>
    {!! $errors->first('prev_balance', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : ''}}">
    <label for="amount_paid" class="control-label">{{ 'Amount Paid' }}</label>
    <input class="form-control payment_amount_paid" name="amount_paid" type="number" id="amount_paid" value="{{ isset($payment->amount_paid) ? $payment->amount_paid : old('amount_paid')}}">
    {!! $errors->first('amount_paid', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('balance') ? 'has-error' : ''}}">
    <label for="balance" class="control-label">{{ 'Current Balance' }}</label>
    <input class="form-control" name="balance" type="number" id="balance" value="{{ isset($payment->balance) ? $payment->balance : old('payment_date')}}" readonly>
    {!! $errors->first('balance', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('payment_date') ? 'has-error' : ''}}">
    <label for="payment_date" class="control-label">{{ 'Payment Date' }}</label>
    <input class="form-control" name="payment_date" type="date" id="payment_date" value="{{ isset($payment->payment_date) ? $payment->payment_date : date("Y-m-d") }}" readonly>
    {!! $errors->first('payment_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('comments') ? 'has-error' : ''}}">
    <label for="comments" class="control-label">{{ 'Comments' }}</label>
    <textarea class="form-control" rows="5" name="comments" type="textarea">{{ isset($payment->comments) ? $payment->comments : old('comments') }}</textarea>
    {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Next">
</div>