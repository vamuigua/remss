<div class="modal fade" id="newTenant" tabindex="-1" role="dialog" aria-labelledby="newTenantLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTenantLabel">New Tenant Account</h5>
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
                                    <input class="form-control" name="surname" type="text" id="surname" value="{{ old('surname') }}" >
                                    {!! $errors->first('surname', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('other_names') ? 'has-error' : ''}}">
                                    <label for="other_names" class="control-label">{{ 'Other Names' }}</label>
                                    <input class="form-control" name="other_names" type="text" id="other_names" value="{{ old('other_names') }}" >
                                    {!! $errors->first('other_names', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                                    <label for="gender" class="control-label">{{ 'Gender' }}</label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group {{ $errors->has('national_id') ? 'has-error' : ''}}">
                                    <label for="national_id" class="control-label">{{ 'National Id' }}</label>
                                    <input class="form-control" name="national_id" type="text" id="national_id" value="{{ old('national_id') }}" >
                                    {!! $errors->first('national_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('phone_no') ? 'has-error' : ''}}">
                                    <label for="phone_no" class="control-label">{{ 'Phone No' }}</label>
                                    <input class="form-control" name="phone_no" type="text" id="phone_no" value="{{ old('phone_no') }}" >
                                    {!! $errors->first('phone_no', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                    <label for="email" class="control-label">{{ 'Email' }}</label>
                                    <input class="form-control" name="email" type="text" id="email" value="{{ old('email') }}" >
                                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                            <label for="image" class="control-label">{{ 'Image' }}</label>
                            <input class="form-control" name="image" type="file" id="image" value="{{ old('image') }}" >
                            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div>
                            <input type="hidden" name="user_account_for" value="new_tenant">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create New Tenant User Account</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>