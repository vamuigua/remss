@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            {{-- @include('admin.sidebar') --}}

            <div class="col-md-12">
                <div class="row">
                    {{-- Tenants --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$tenants->count()}}</h3>
                                <p>Tenants</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <a href="/admin/tenants" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- Houses --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gradient-success">
                            <div class="inner">
                                <h3>{{$houses->count()}}</h3>
                                <p>Houses</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <a href="/admin/houses" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- Invoices --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-cyan">
                            <div class="inner">
                                <h3>{{$invoices->count()}}</h3>
                                <p>Invoices</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-invoice nav-icon"></i>
                            </div>
                            <a href="/admin/invoices" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- Payments --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-maroon">
                            <div class="inner">
                                <h3>{{$payments->count()}}</h3>
                                <p>Payments</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-money-check-alt"></i>
                            </div>
                            <a href="/admin/payments" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- Notices --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gradient-warning">
                            <div class="inner">
                                <h3>{{$notices->count()}}</h3>
                                <p>Notices</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-bell nav-icon"></i>
                            </div>
                            <a href="/admin/notices" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- Expenditures --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gradient-danger">
                            <div class="inner">
                                <h3>{{$expenditures->count()}}</h3>
                                <p>Expenditures</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-money-bill-alt nav-icon"></i>
                            </div>
                            <a href="/admin/expenditures" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    {{-- Water Readings --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gradient-primary">
                            <div class="inner">
                                <h3>{{$water_readings->count()}}</h3>
                                <p>Water Readings</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-water nav-icon"></i>
                            </div>
                            <a href="/admin/water-readings" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        Your application's dashboard.
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
