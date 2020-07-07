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
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#newTenant">
            <div><i class="fas fa-user-plus fa-lg mt-2"></i></div>
            A NEW TENANT
        </button>
    </div>
    <div class="w-100"></div>
    <div class="d-flex justify-content-center col p-5 bg-danger">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#existingAdmin">
            <div><i class="fas fa-user-secret fa-lg mt-2"></i></div>
            AN EXISTING ADMIN
        </button>
    </div>
    <div class="d-flex justify-content-center col p-5 bg-success">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#existingTenant">
            <div><i class="fas fa-user fa-lg mt-2"></i></div>
            AN EXISTING TENANT
        </button>
    </div>
</div>

{{-- A NEW ADMIN MODAL --}}
<form method="POST" action="{{ url('/admin/users') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    @include ('admin.users.modals.newAdmin')
</form>
{{-- A NEW TENANT --}}
<form method="POST" action="{{ url('/admin/users') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
{{ csrf_field() }}
    @include('admin.users.modals.newTenant')
</form>
{{-- AN EXISTING ADMIN --}}
<form method="POST" action="{{ url('/admin/users') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
{{ csrf_field() }}
    @include('admin.users.modals.existingAdmin')
</form>
{{-- AN EXISTING TENANT --}}
<form method="POST" action="{{ url('/admin/users') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
{{ csrf_field() }}
    @include('admin.users.modals.existingTenant')
</form>

