<div class="form-group {{ $errors->has('house_no') ? 'has-error' : ''}}">
    <label for="house_no" class="control-label">{{ 'House No' }}</label>
    <input class="form-control" name="house_no" type="text" id="house_no" value="{{ old('house_no') ?? $house->house_no }}" >
    {!! $errors->first('house_no', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('features') ? 'has-error' : ''}}">
    <label for="features" class="control-label">{{ 'Features' }}</label>
    <textarea class="form-control" rows="5" name="features" type="textarea" id="features" >{{ old('features') ?? $house->features }}</textarea>
    {!! $errors->first('features', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('rent') ? 'has-error' : ''}}">
    <label for="rent" class="control-label">{{ 'Rent' }}</label>
    <input class="form-control" name="rent" type="text" id="rent" value="{{ old('rent') ?? $house->rent }}" >
    {!! $errors->first('rent', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control" id="status" >
    @foreach ($house->statusOptions() as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($house->status) && $house->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
    </select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('water_meter_no') ? 'has-error' : ''}}">
    <label for="water_meter_no" class="control-label">{{ 'Water Meter No' }}</label>
    <input class="form-control" name="water_meter_no" type="text" id="water_meter_no" value="{{ old('wWater_meter_no') ?? $house->water_meter_no }}" >
    {!! $errors->first('water_meter_no', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('electricity_meter_no') ? 'has-error' : ''}}">
    <label for="electricity_meter_no" class="control-label">{{ 'Electricity Meter No' }}</label>
    <input class="form-control" name="electricity_meter_no" type="text" id="electricity_meter_no" value="{{ old('electricity_meter_no') ?? $house->electricity_meter_no }}" >
    {!! $errors->first('electricity_meter_no', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
