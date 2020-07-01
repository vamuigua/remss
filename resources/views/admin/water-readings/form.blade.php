<div class="form-group {{ $errors->has('house_id') ? 'has-error' : ''}}">
    <label for="house_id" class="control-label">{{ 'House No' }}</label>
    <select name="house_id" class="form-control selectpicker" data-live-search="true" id="house_id" onchange="updateWaterReading()">
        <option value="" disabled selected>Choose an Option</option>
        @foreach ($houses as $house)
            <option value="{{ $house->id }}" {{ (isset($waterreading->id)) && $house->id == $waterreading->house_id ? 'selected' : old('house_id')}}>{{ $house->house_no }}</option>
        @endforeach
    </select>
    {!! $errors->first('house_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('tenant_names') ? 'has-error' : ''}}">
    <label for="tenant_names" class="control-label">{{ 'Tenant Name' }}</label>
    <input class="form-control" name="tenant_names" type="text" id="tenant_names" value="{{ isset($waterreading->tenant_names) ? $waterreading->tenant_names : old('tenant_names') }}"  readonly>
    {!! $errors->first('tenant_names', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('prev_reading') ? 'has-error' : ''}}">
    <label for="prev_reading" class="control-label">{{ 'Prev Reading' }}</label>
    <input class="form-control" name="prev_reading" type="text" id="prev_reading" value="{{ isset($waterreading->prev_reading) ? $waterreading->prev_reading : old('prev_reading')}}"  readonly>
    {!! $errors->first('prev_reading', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('current_reading') ? 'has-error' : ''}}">
    <label for="current_reading" class="control-label">{{ 'Current Reading' }}</label>
    <input class="form-control" name="current_reading" type="number" id="current_reading" value="{{ isset($waterreading->current_reading) ? $waterreading->current_reading : old('current_reading')}}" oninput="updateWaterReading()">
    {!! $errors->first('current_reading', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('units_used') ? 'has-error' : ''}}">
    <label for="units_used" class="control-label">{{ 'Units Used' }}</label>
    <input class="form-control" name="units_used" type="number" id="units_used" value="{{ isset($waterreading->units_used) ? $waterreading->units_used : ''}}" readonly>
    {!! $errors->first('units_used', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('cost_per_unit') ? 'has-error' : ''}}">
    <label for="cost_per_unit" class="control-label">{{ 'Cost Per Unit' }}</label>
    <input class="form-control" name="cost_per_unit" type="number" step="0.01" min="0" max="10" id="cost_per_unit" value="{{ isset($waterreading->cost_per_unit) ? $waterreading->cost_per_unit : old('cost_per_unit')}}" oninput="updateWaterReading()">
    {!! $errors->first('cost_per_unit', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('total_charges') ? 'has-error' : ''}}">
    <label for="total_charges" class="control-label">{{ 'Total Charges' }}</label>
    <input class="form-control" name="total_charges" type="number" id="total_charges" value="{{ isset($waterreading->total_charges) ? $waterreading->total_charges : old('total_charges')}}" readonly>
    {!! $errors->first('total_charges', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
    <label for="date" class="control-label">{{ 'Date' }}</label>
    <input class="form-control" name="date" type="date" id="date" value="{{ isset($waterreading->date) ? $waterreading->date : old('date')}}" >
    {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

<script src="{{ asset('js/fetch.js') }}" type="text/javascript"></script>