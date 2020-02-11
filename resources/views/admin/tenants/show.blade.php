@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Tenant {{ $tenant->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/tenants') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/tenants/' . $tenant->id . '/edit') }}" title="Edit Tenant"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/tenants' . '/' . $tenant->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Tenant" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th>ID</th><td>{{ $tenant->id }}</td></tr>
                                    <tr><th> Surname </th><td> {{ $tenant->surname }} </td></tr>
                                    <tr><th> Other Names </th><td> {{ $tenant->other_names }} </td></tr>
                                    <tr><th> Gender </th><td> {{ $tenant->gender }} </td></tr>
                                    <tr><th> National ID </th><td> {{ $tenant->national_id }} </td></tr>
                                    <tr><th> Mobile No. </th><td> {{ $tenant->phone_no }} </td></tr>
                                    <tr><th> Email </th><td> {{ $tenant->email }} </td></tr>
                                    <tr><th> Tenant Photo: </th><td> <img src="{{$tenant->tenantImage()}}" alt="tenantImage"> </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
