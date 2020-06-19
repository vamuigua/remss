<label for="user_account_for" class="control-label">{{ 'Create User Account for' }}</label>
{{-- SELECT OPTIONS --}}
<div class="row">
    <div class="d-flex justify-content-center col p-5 bg-primary">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newAdmin">
            <div>
                <i class="fa fa-user-secret fa-lg" aria-hidden="true"></i>
                <i class="fa fa-plus fa-sm" aria-hidden="true"></i>
            </div>
            A NEW ADMIN
        </button>
    </div>
    <div class="d-flex justify-content-center col p-5 bg-warning">
        <button type="button" class="btn btn-warning">
            <div><i class="fas fa-user-plus fa-lg mt-2"></i></div>
            A NEW TENANT
        </button>
    </div>
    <div class="w-100"></div>
    <div class="d-flex justify-content-center col p-5 bg-danger">
        <button type="button" class="btn btn-danger">
            <div><i class="fas fa-user-secret fa-lg mt-2"></i></div>
            AN EXISTING ADMIN
        </button>
    </div>
    <div class="d-flex justify-content-center col p-5 bg-success">
        <button type="button" class="btn btn-success">
            <div><i class="fas fa-user fa-lg mt-2"></i></div>
            AN EXISTING TENANT
        </button>
    </div>
</div>

{{-- A NEW ADMIN MODAL --}}
<div class="modal fade" id="newAdmin" tabindex="-1" role="dialog" aria-labelledby="newAdminLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAdminLabel">New Admin Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('surname') ? 'has-error' : ''}}">
                                    <label for="surname" class="control-label">{{ 'Surname' }}</label>
                                    <input class="form-control" name="surname" type="text" id="surname" value="{{ old('surname') ?? $admin->surname }}" >
                                    {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('other_names') ? 'has-error' : ''}}">
                                    <label for="other_names" class="control-label">{{ 'Other Names' }}</label>
                                    <input class="form-control" name="other_names" type="text" id="other_names" value="{{ old('other_names') ?? $admin->other_names }}" >
                                    {!! $errors->first('other_names', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                                    <label for="gender" class="control-label">{{ 'Gender' }}</label>
                                    <select name="gender" class="form-control" id="gender">
                                        @foreach ($admin->genderOptions() as $optionKey => $optionValue)
                                            <option value="{{ $optionKey }}" {{ (isset($admin->gender) && $admin->gender == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group {{ $errors->has('national_id') ? 'has-error' : ''}}">
                                    <label for="national_id" class="control-label">{{ 'National Id' }}</label>
                                    <input class="form-control" name="national_id" type="text" id="national_id" value="{{ old('national_id') ?? $admin->national_id }}" >
                                    {!! $errors->first('national_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('phone_no') ? 'has-error' : ''}}">
                                    <label for="phone_no" class="control-label">{{ 'Phone No' }}</label>
                                    <input class="form-control" name="phone_no" type="text" id="phone_no" value="{{ old('phone_no') ?? $admin->phone_no }}" >
                                    {!! $errors->first('phone_no', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                    <label for="email" class="control-label">{{ 'Email' }}</label>
                                    <input class="form-control" name="email" type="text" id="email" value="{{ old('email') ?? $admin->email }}" >
                                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                            <label for="image" class="control-label">{{ 'Image' }}</label>
                            <input class="form-control" name="image" type="file" id="image" value="{{ old('image') ?? $admin->image }}" >
                            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div>
                            <input type="hidden" name="user_account_for" value="new_admin">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create New Admin User Account</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- A NEW TENANT --}}
<div id="new_tenant"></div>
{{-- AN EXISTING ADMIN --}}
<div id="existing_admin"></div>
{{-- AN EXISTING TENANT --}}
<div id="existing_tenant"></div>

