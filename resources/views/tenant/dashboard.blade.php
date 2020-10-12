@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ $user->tenant->tenantImage() }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->tenant->surname }} {{ $user->tenant->other_names }}</h3>

                <p class="text-muted text-center">Tenant</p>
                <h5 class="text-center">Welome Back! {{ $user->tenant->surname }}</h5>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">Recent Updates</div>

                    <div class="card-body">
                        <div class="row">
                            {{--  Active Invoices --}}
                            <div class="col-lg-6 col-6">
                                <div class="small-box bg-cyan">
                                    <div class="inner">
                                    <h3>{{ $active_invoices }}</h3>
                                        <p>Active Invoices</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-invoice nav-icon"></i>
                                    </div>
                                    <a href="/tenant/invoices" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- ! Active Invoices --}}
                            {{-- Unread Notifications --}}
                            <div class="col-lg-6 col-6">
                                <div class="small-box bg-gradient-warning">
                                    <div class="inner">
                                    <h3>{{ $unread_notifications }}</h3>
                                        <p>Unread Notifications</p>
                                    </div>
                                    <div class="icon">
                                        <i class="nav-icon fas fa-bell"></i>
                                    </div>
                                    <a href="/tenant/notifications" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            {{-- !Unread Notifications --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
