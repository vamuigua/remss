@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="row">
                    {{-- Tenants --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$tenants}}</h3>
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
                                <h3>{{$houses}}</h3>
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
                                <h3>{{$invoices}}</h3>
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
                                <h3>{{$payments}}</h3>
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
                                <h3>{{$notices}}</h3>
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
                                <h3>{{$expenditures}}</h3>
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
                                <h3>{{$water_readings}}</h3>
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
                    {{-- Pending Payments --}}
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-purple">
                            <div class="inner">
                            <h3>{{$pending_payments}}</h3>
                                <p>Pending Payments</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            </div>
                            <a href="/admin/pending-payments" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- EXPENDIRURES CHART --}}
            <div class="col-md-12" id="expenditures_chart">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                        <h3 class="card-title">Expenditures</h3>
                        <a href="#" id="downloadChartPDF">Download Chart as PDF</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg" id="expenditure_total">KSH.0</span>
                            <span>Total Expenditure for Selected Months</span>
                        </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4" id="graph-container">
                            <canvas id="expenditure-chart" style="display:none"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2" id="blue_bar_year">
                                <i class="fas fa-square text-primary"></i> This year
                            </span>
                        </div>

                        {{-- Expenditures Chart Form --}}
                        <form id="expenditure_chart_form">
                            {{ csrf_field() }}
                            <div class="d-flex justify-content-center form-row">
                                <div class="form-group col-md-4">
                                <div class="m-2"><label for="months" class="control-label">{{ 'Choose Month(s): ' }}</label></div>
                                 <select class="selectpicker" multiple data-live-search="true" name="months[]" id="months" required>
                                    @foreach ($months as $month)
                                        @foreach ($month as $optionKey => $optionValue)
                                            <option value="{{ $optionValue }}">{{ $optionKey }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group col-md-4">
                                <div class="m-2"><label for="date" class="control-label">{{ 'Choose Year: ' }}</label></div>
                                <input class="form-control" type="text" id="datepicker" name="year" required>
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
