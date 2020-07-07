<div class="modal fade" id="existingAdmin" tabindex="-1" role="dialog" aria-labelledby="existingAdminLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existingAdminLabel">Existing Admin Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('admin_id') ? 'has-error' : ''}}">
                                    <label for="admin_id" class="control-label">{{ 'Admin Name' }}</label>
                                    <br>
                                    <select class="selectpicker" data-live-search="true" name="admin_id" id="admin_id" required>
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->other_names }} {{ $admin->surname }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('admin_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="user_account_for" value="existing_admin">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create User Account for Existing Admin </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>