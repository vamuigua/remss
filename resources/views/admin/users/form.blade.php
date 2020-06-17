<div class="form-group {{ $errors->has('user_account_for') ? 'has-error' : ''}}">
    <label for="user_account_for" class="control-label">{{ 'Create User Account for' }}</label>
    <select name="user_account_for" class="form-control" id="user_account_for">
        <option value="default_option">Choose an option</option>
        <option value="new_admin">A New Admin</option>
        <option value="new_tenant">A New Tenant</option>
        <option value="existing_admin">An Existing Admin</option>
        <option value="existing_tenant">An Existing Tenant</option>
    </select>
    {!! $errors->first('user_account_for', '<p class="help-block">:message</p>') !!}
</div>

{{-- NEW ADMIN --}}
<div id="new_admin"></div>
{{-- NEW TENANT --}}
<div id="new_tenant"></div>
{{-- EXISTING ADMIN --}}
<div id="existing_admin"></div>
{{-- EXISTING TENANT --}}
<div id="existing_tenant"></div>

<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    <label for="role" class="control-label">{{ 'Assign Role' }}</label>
    <select name="role" class="form-control" id="role">
        @foreach ($user->roleOptions() as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($user->roles[0]->user) && $user->roles[0]->user == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
