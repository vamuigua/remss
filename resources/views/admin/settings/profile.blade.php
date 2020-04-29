@extends('layouts.admin')

@section('content')
    <div class="container">
        <div><h2>Profile</h2></div>
        <div class="row">
            <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                       src="/img/avatar.png"
                       alt="Admin profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                <p class="text-muted text-center">Admin</p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr><th >Name </th><td>{{ $user->name }}</td></tr>
                            <tr><th> Email </th><td> {{ $user->email }} </td></tr>
                        </tbody>
                    </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <div class="col-md-8">
                <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#password" data-toggle="tab">Password</a></li>
                  {{-- <li class="nav-item"><a class="nav-link" href="#profilePic" data-toggle="tab">Profile Picture</a></li> --}}
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="password">
                        
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ route('admin.settings.updatePassword') }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="old_password" class="col-form-label">Old Password</label>
                                <div class="col-sm-12">
                                <input type="password" class="form-control row" id="old_password" name="old_password" value={{old('old_password')}}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">New Password</label>
                                <div class="col-sm-12">
                                <input type="password" class="form-control row" id="password" name="password" value={{old('password')}}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-form-label">Confirm Password</label>
                                <div class="col-sm-12">
                                <input type="password" class="form-control row" id="password_confirmation" name="password_confirmation" value={{old('password_confirmation')}}>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                    </label>
                                </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                  </div>
                  <!-- /.tab-pane -->
                  {{-- <div class="tab-pane" id="profilePic">
                      <form method="POST" action="{{ route('user.settings.updateProfilePic') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                            <label for="image" class="control-label">{{ 'Change Profile Picture' }}</label>
                            <input class="form-control" name="image" type="file" id="image" value="{{ isset($user->tenant->image) ? $user->tenant->image : ''}}" >
                            <div class="form-group">
                                <input class="btn btn-success my-3" type="submit" value="Update Photo">
                                {!! $errors->first('image', '<p class="alert alert-danger help-block">:message</p>') !!}
                            </div>
                            <div class="mt-2">
                                <p><b>Current Tenant Photo:</b></p><img src="{{$user->tenant->tenantImage()}}" alt="tenantImage">
                            </div>
                        </div>
                      </form>
                  </div> --}}
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
            </div>
        </div>
    </div>
@endsection
