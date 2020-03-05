<div class="form-group {{ $errors->has('payment_no') ? 'has-error' : ''}}">
    <label for="payment_no" class="control-label">{{ 'Payment No' }}</label>
    <input class="form-control" name="payment_no" type="text" id="payment_no" value="{{ isset($payment->payment_no) ? $payment->payment_no : old('payment_no')}}" >
    {!! $errors->first('payment_no', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('tenant_id') ? 'has-error' : ''}}">
    <label for="tenant_id" class="control-label">{{ 'Tenant' }}</label>
    <select name="tenant_id" class="form-control selectpicker" data-live-search="true" id="tenant_id">
        @foreach ($tenants as $tenant)
            <option value="{{ $tenant->id }}" {{ (isset($tenant->id)) && $payment->tenant_id == $tenant->id ? 'selected' : old('tenant_id')}}>{{ $tenant->surname }} {{ $tenant->other_names }}</option>
        @endforeach
    </select>
    {!! $errors->first('tenant_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('invoice_id') ? 'has-error' : ''}}">
    <label for="invoice_id" class="control-label">{{ 'Invoice No.' }}</label>
    <select name="invoice_id" class="form-control selectpicker" data-live-search="true" id="invoice_id" onchange="updateDetails()">
        @foreach ($invoices as $invoice)
            <option value="{{ $invoice->id }}" {{ (isset($invoice->id))  && $payment->invoice_id == $invoice->id ? 'selected' : old('invoice_id')}}>{{ $invoice->invoice_no }}</option>
        @endforeach
    </select>
    {!! $errors->first('invoice_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('payment_type') ? 'has-error' : ''}}">
    <label for="payment_type" class="control-label">{{ 'Payment Type' }}</label>
    <select name="payment_type" class="form-control" id="payment_type">
        @foreach ($payment->paymentTypeOptions() as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($payment->payment_type) && $payment->payment_type == $optionKey) ? 'selected' : old('payment_type')}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('payment_type', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('payment_date') ? 'has-error' : ''}}">
    <label for="payment_date" class="control-label">{{ 'Payment Date' }}</label>
    <input class="form-control" name="payment_date" type="date" id="payment_date" value="{{ isset($payment->payment_date) ? $payment->payment_date : old('payment_date')}}" >
    {!! $errors->first('payment_date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('amount_paid') ? 'has-error' : ''}}">
    <label for="amount_paid" class="control-label">{{ 'Amount Paid' }}</label>
    <input class="form-control" name="amount_paid" type="number" id="amount_paid" value="{{ isset($payment->amount_paid) ? $payment->amount_paid : old('amount_paid')}}" oninput="updateDetails()">
    {!! $errors->first('amount_paid', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('prev_balance') ? 'has-error' : ''}}">
    <label for="prev_balance" class="control-label">{{ 'Previous Balance' }}</label>
<input class="form-control" name="prev_balance" type="number" id="prev_balance" value="{{ old('prev_balance') }}" readonly>
    {!! $errors->first('prev_balance', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('balance') ? 'has-error' : ''}}">
    <label for="balance" class="control-label">{{ 'Current Balance' }}</label>
    <input class="form-control" name="balance" type="number" id="balance" value="{{ isset($payment->balance) ? $payment->balance : old('payment_date')}}" readonly>
    {!! $errors->first('balance', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('comments') ? 'has-error' : ''}}">
    <label for="comments" class="control-label">{{ 'Comments' }}</label>
    <textarea class="form-control" rows="5" name="comments" type="textarea" id="comments" >{{ isset($payment->comments) ? $payment->comments : old('comments') }}</textarea>
    {!! $errors->first('comments', '<p class="help-block">:message</p>') !!}
</div>

{{-- <div id="summernote">Hello Summernote</div> --}}

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

<script src="{{ asset('js/fetch.js') }}" type="text/javascript"></script>

