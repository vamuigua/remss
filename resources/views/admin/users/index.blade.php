@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/users/create') }}" class="btn btn-success btn-sm" title="Add New user">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New User Account
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Name</th><th>Email</th><th>Roles</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td><td>{{ $item->email }}</td><td>{{ $item->roles[0]->name }}</td>
                                        <td>
                                            <a href="{{ url('/admin/users/' . $item->id) }}" title="View user"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
