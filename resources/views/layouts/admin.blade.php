<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Admin Panel</title>
  {{-- All CSS Compiled Assets --}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-footer-fixed layout-navbar-fixed layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
      <li class="mr-6">
        <div class="dropdown">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell nav-icon"></i> 
              @if (Auth::user()->unreadNotifications->count())
                <span class="badge badge-warning navbar-badge ml-2">
                  {{Auth::user()->unreadNotifications->count()}}
                </span>
            @endif
          </a>

          <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropdownMenuLink">
            
            {{-- Show Unread Notification Count --}}
            @if (Auth::user()->unreadNotifications->count())
              @if (Auth::user()->notifications->count() > 1)
                <div class="d-flex justify-content-center">
                  <p class="dropdown-item dropdown-header bg-warning"><b>{{Auth::user()->unreadNotifications->count()}} Notifications</b></p>
                  <div class="dropdown-divider"></div>
                    <a class="dropdown-item dropdown-header" href="{{route('admin.notifications.markNotificationsAsRead')}}" style="color:#007bff">Mark All as Read</a>
                  <div class="dropdown-divider"></div>
                </div>
              @else
                <div class="d-flex justify-content-center">
                  <p class="dropdown-item dropdown-header bg-warning"><b>{{Auth::user()->unreadNotifications->count()}} Notification</b></p>
                  <div class="dropdown-divider"></div>
                    <a class="dropdown-item dropdown-header" href="{{route('admin.notifications.markNotificationsAsRead')}}" style="color:#007bff">Mark All as Read</a>
                  <div class="dropdown-divider"></div>
                </div>
              @endif
            @else
              <div class="d-flex justify-content-center">
                  <p class="dropdown-item dropdown-header bg-warning"><b>You don't have any new Notifications!</b></p>
              </div>
            @endif
            
            {{-- UNREAD NOTIFICATIONS --}}
            @foreach(Auth::user()->unreadNotifications as $notification)
              @if ($notification->data['notification_type'] == 'invoice paid')
                <a class="dropdown-item bg-light" href="/admin/payments/{{$notification->data['id']}}"><i class="fas fa-bell nav-icon"></i> {{$notification->data['subject']}}</a>
                <div class="dropdown-divider"></div>
              @endif
            @endforeach

            <a href="{{route('admin.notifications.index')}}" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
          </div>
        </div>
      </li>
    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
      <img src="/img/AdminLTELogo.png" alt="REMSS Admin Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }} ADMIN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/img/avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/admin/dashboard" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          {{-- DASHBOARD --}}
          <li class="nav-item">
            <a href="/admin/dashboard" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          {{-- MANAGEMENT --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/tenants" class="nav-link">
                  <i class="fas fa-user nav-icon"></i>
                  <p>Tenants</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/houses" class="nav-link">
                  <i class="fas fa-home nav-icon"></i>
                  <p>Houses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.notifications.index')}}" class="nav-link">
                  <i class="fas fa-bell nav-icon"></i>
                  <p>Notifications</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/notices" class="nav-link">
                  <i class="fas fa-bullhorn nav-icon"></i>
                  <p>Notices</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/invoices" class="nav-link">
                  <i class="fas fa-file-invoice nav-icon"></i>
                  <p>Invoices</p>
                </a>
              </li>
              {{-- PAYMENTS --}}
              <li class="nav-item has-treeview">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-money-bill-wave-alt"></i>
                <p>
                  Payments
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/admin/payments" class="nav-link">
                    <i class="nav-icon fas fa-dollar-sign"></i>
                    <p>All Payments</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/admin/pending-payments" class="nav-link">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <p>Pending Payments</p>
                  </a>
                </li>
              </ul>
            </li>
              <li class="nav-item">
                <a href="/admin/expenditures" class="nav-link">
                  <i class="fas fa-money-bill-alt nav-icon"></i>
                  <p>Expenditures</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/water-readings" class="nav-link">
                  <i class="fas fa-water nav-icon"></i>
                  <p>Water Readings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/house-adverts" class="nav-link">
                  <i class="fas fa-home nav-icon"></i>
                  <p>House Adverts</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- SERVICES --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-wrench"></i>
              <p>
                Services
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/messages" class="nav-link">
                  <i class="fas fa-mail-bulk nav-icon"></i>
                  <p>BulkSMS</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- SETTINGS --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="fas fa-cog nav-icon"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/roles" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>
                    Roles
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/roles/assign" class="nav-link">
                  <i class="fas fa-user-plus nav-icon"></i>
                  <p>
                    Assign Roles
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/admin/settings/profile/{{ Auth::user()->id }}" class="nav-link">
                  <i class="fas fa-user-edit nav-icon"></i>
                  <p>
                    Profile
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" 
                    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                  <i class="fas fa-power-off nav-icon"></i>
                  <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">REMSS</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Admin Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    {{-- Success Alert --}}
    @if(session()->has('flash_message'))
        <div class="alert alert-success" role="alert">
            <strong>Success:</strong> {{ session()->get('flash_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Error/Danger Alert --}}
    @if(session()->has('flash_message_error'))
        <div class="alert alert-danger" role="alert">
            <strong>Error:</strong> {{ session()->get('flash_message_error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Always with You!
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{date('Y')}} <a href="#">REMSS</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
</body>
@stack('scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/mychart.js') }}" type="text/javascript"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
</html>
