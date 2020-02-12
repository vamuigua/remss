@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            {{-- @include('admin.sidebar') --}}

            <div class="col-md-12">
                <div class="row">
                    {{-- Tenants --}}
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                        <div class="inner">
                        <h3>{{$tenants->count()}}</h3>

                            <p>Tenants <i class="fas fa-user"></i></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="/admin/tenants" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    {{-- Houses --}}
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                        <div class="inner">
                        <h3>{{$houses->count()}}</h3>

                            <p>Houses <i class="fas fa-home"></i></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="/admin/houses" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
