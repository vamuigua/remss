@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row">
            {{-- @include('admin.sidebar') --}}

            <div class="col-md-12">
                <div class="row">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            {{ $user->tenant->surname }} Your application's dashboard.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
