<div class="form-group {{ $errors->has('house') ? 'has-error' : ''}}">
    <label for="house" class="control-label">{{ 'House' }}</label>
    <input class="form-control" name="house" type="text" id="house" value="{{ isset($houseadvert->house) ? $houseadvert->house : old('house')}}" >
    {!! $errors->first('house', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('location') ? 'has-error' : ''}}">
    <label for="location" class="control-label">{{ 'Location' }}</label>
    <input class="form-control" name="location" type="text" id="location" value="{{ isset($houseadvert->location) ? $houseadvert->location : old('location')}}" >
    {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('images') ? 'has-error' : ''}}">
    <label for="images" class="control-label">{{ 'Images' }}</label>
    <input class="form-control" name="images[]" type="file" multiple id="images" value="{{ isset($houseadvert->images) ? $houseadvert->images : old('images')}}" >
    {!! $errors->first('images', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('details') ? 'has-error' : ''}}">
    <label for="details" class="control-label">{{ 'Details' }}</label>
    <textarea class="form-control" rows="5" name="details" type="textarea" id="details" >{{ isset($houseadvert->details) ? $houseadvert->details : old('details')}}</textarea>
    {!! $errors->first('details', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($houseadvert->description) ? $houseadvert->description : old('description')}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('rent') ? 'has-error' : ''}}">
    <label for="rent" class="control-label">{{ 'Rent' }}</label>
    <input class="form-control" name="rent" type="text" id="rent" value="{{ isset($houseadvert->rent) ? $houseadvert->rent : old('rent')}}" >
    {!! $errors->first('rent', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('booking_status') ? 'has-error' : ''}}">
    <label for="booking_status" class="control-label">{{ 'Booking status' }}</label>
    <select name="booking_status" class="form-control" id="booking_status" >
    @foreach ($houseadvert->bookingStatusOptions() as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($houseadvert->booking_status) && $houseadvert->booking_status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
    </select>
    {!! $errors->first('booking_status', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
    <label for="file" class="control-label">{{ 'Agreement Document' }}</label>
    <input class="form-control" name="file" type="file" id="file" accept=".pdf" value="{{ isset($houseadvert->file) ? $houseadvert->file : ''}}" >
    {!! $errors->first('file', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>