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
            </div>
            {{-- EXPENDIRURES CHART --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                        <h3 class="card-title">Expenditures</h3>
                        <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">$18,230.00</span>
                            <span>Expenditures Over Time</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                            <span class="text-success">
                            <i class="fas fa-arrow-up"></i> 33.1%
                            </span>
                            <span class="text-muted">Since last month</span>
                        </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="expenditure-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> This year
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Last year
                            </span>
                        </div>

                        {{-- Expenditures Chart Form --}}
                        <form action="{{ url('/admin/expenditure-months') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="d-flex justify-content-center form-row">
                                <div class="form-group col-md-4">
                                <div class="m-2"><label for="months" class="control-label">{{ 'Choose Month(s): ' }}</label></div>
                                 <select class="selectpicker" multiple data-live-search="true" name="months[]">
                                    @foreach ($months as $month)
                                        <option>{{$month}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group col-md-4">
                                <div class="m-2"><label for="date" class="control-label">{{ 'Choose Year: ' }}</label></div>
                                <input class="form-control" type="text" id="datepicker" name="year">
                                </div>
                            </div>
                            <div class="mx-5 d-flex justify-content-center form-group">
                                <input type="submit" class="btn btn-primary btn-lg btn-block">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
