@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Admin {{ $admin->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/admins') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/admins/' . $admin->id . '/edit') }}" title="Edit Admin"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/admins' . '/' . $admin->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Admin" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th>ID</th><td>{{ $admin->id }}</td></tr>
                                    <tr><th> Surname </th><td> {{ $admin->surname }} </td></tr>
                                    <tr><th> Other Names </th><td> {{ $admin->other_names }} </td></tr>
                                    <tr><th> Gender </th><td> {{ $admin->gender }} </td></tr>
                                    <tr><th> National ID </th><td> {{ $admin->national_id }} </td></tr>
                                    <tr><th> Mobile No. </th><td> {{ $admin->phone_no }} </td></tr>
                                    <tr><th> Email </th><td> {{ $admin->email }} </td></tr>
                                    <tr><th> Admin Photo: </th><td> <img src="{{$admin->adminImage()}}" alt="adminImage"> </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
