<div class="form-group {{ $errors->has('surname') ? 'has-error' : ''}}">
    <label for="surname" class="control-label">{{ 'Surname' }}</label>
    <input class="form-control" name="surname" type="text" id="surname" value="{{ old('surname') ?? $tenant->surname }}" >
    {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('other_names') ? 'has-error' : ''}}">
    <label for="other_names" class="control-label">{{ 'Other Names' }}</label>
    <input class="form-control" name="other_names" type="text" id="other_names" value="{{ old('other_names') ?? $tenant->other_names }}" >
    {!! $errors->first('other_names', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
    <label for="gender" class="control-label">{{ 'Gender' }}</label>
    <select name="gender" class="form-control" id="gender">
        @foreach ($tenant->genderOptions() as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($tenant->gender) && $tenant->gender == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('national_id') ? 'has-error' : ''}}">
    <label for="national_id" class="control-label">{{ 'National Id' }}</label>
    <input class="form-control" name="national_id" type="text" id="national_id" value="{{ old('national_id') ?? $tenant->national_id }}" >
    {!! $errors->first('national_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('phone_no') ? 'has-error' : ''}}">
    <label for="phone_no" class="control-label">{{ 'Phone No' }}</label>
    <input class="form-control" name="phone_no" type="text" id="phone_no" value="{{ old('phone_no') ?? $tenant->phone_no }}" >
    {!! $errors->first('phone_no', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="text" id="email" value="{{ old('email') ?? $tenant->email }}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Image' }}</label>
    <input class="form-control" name="image" type="file" id="image" value="{{ isset($post->image) ? $post->image : ''}}" >
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
