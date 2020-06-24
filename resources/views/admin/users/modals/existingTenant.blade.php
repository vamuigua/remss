<div class="modal fade" id="existingTenant" tabindex="-1" role="dialog" aria-labelledby="existingTenantLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existingTenantLabel">Existing Tenant Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('tenant_id') ? 'has-error' : ''}}">
                                    <label for="tenant_id" class="control-label">{{ 'Tenant Name' }}</label>
                                    <br>
                                    <select class="selectpicker" data-live-search="true" name="tenant_id" id="tenant_id" required>
                                        @foreach ($tenants as $tenant)
                                            <option value="{{ $tenant->id }}">{{ $tenant->other_names }} {{ $tenant->surname }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('tenant_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="user_account_for" value="existing_tenant">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create User Account for Existing Tenant</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>