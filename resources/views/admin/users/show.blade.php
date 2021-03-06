@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $user->name }} - {{ $user->roles[0]->name }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br/>
                        <br/>

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    @if ($user->admin)
                                        <img src="{{ $user->admin->adminImage() }}" class="img-circle elevation-2 img-fluid" alt="user_admin_image">
                                    @elseif($user->tenant)
                                        <img src="{{ $user->tenant->tenantImage() }}" class="img-circle elevation-2 img-fluid" alt="user_tenant_img">
                                    @endif
                                </div>

                                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                                <p class="text-muted text-center">{{ $user->roles[0]->name }}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr><th >Name </th><td>{{ $user->name }}</td></tr>
                                            <tr><th> Email </th><td> {{ $user->email }} </td></tr>
                                    <tr><th> Roles </th><td> {{ $user->roles[0]->name }} </td></tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        {{-- <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Profile Photo </th>
                                        <td> 
                                            @if ($user->admin)
                                                <img src="{{ $user->admin->adminImage() }}" class="img-circle elevation-2" alt="user_admin_image">
                                            @elseif($user->tenant)
                                                <img src="{{ $user->tenant->tenantImage() }}" class="img-circle elevation-2" alt="user_tenant_img">
                                            @endif 
                                        </td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $user->name }} </td></tr>
                                    <tr><th> Email </th><td> {{ $user->email }} </td></tr>
                                    <tr><th> Roles </th><td> {{ $user->roles[0]->name }} </td></tr>
                                </tbody>
                            </table>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
