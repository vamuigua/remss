<div class="form-group {{ $errors->has('outgoings') ? 'has-error' : ''}}">
    <label for="outgoings" class="control-label">{{ 'Outgoings' }}</label>
    <input class="form-control" name="outgoings" type="text" id="outgoings" value="{{ old('outgoings') ?? $expenditure->outgoings }}" >
    {!! $errors->first('outgoings', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('amount') ? 'has-error' : ''}}">
    <label for="amount" class="control-label">{{ 'Amount' }}</label>
    <input class="form-control" name="amount" type="number" id="amount" value="{{ old('amount') ?? $expenditure->amount }}" >
    {!! $errors->first('amount', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('particulars') ? 'has-error' : ''}}">
    <label for="particulars" class="control-label">{{ 'Particulars' }}</label>
    <textarea class="form-control" rows="5" name="particulars" type="textarea" id="summernote" >{{ old('particulars') ?? $expenditure->particulars }}</textarea>
    {!! $errors->first('particulars', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('expenditure_date') ? 'has-error' : ''}}">
    <label for="expenditure_date" class="control-label">{{ 'Expenditure Date' }}</label>
    <input class="form-control" name="expenditure_date" type="date" id="expenditure_date" value="{{ old('expenditure_date') ?? $expenditure->expenditure_date }}" >
    {!! $errors->first('expenditure_date', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
