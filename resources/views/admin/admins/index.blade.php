@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Admins</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/admins/create') }}" class="btn btn-success btn-sm" title="Add New Admin">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Admin
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Surname</th><th>Other Names</th><th>Email</th><th>Phone No.</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($admins as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->surname }}</td><td>{{ $item->other_names }}</td><td>{{ $item->email }}</td><td>{{ $item->phone_no }}</td>
                                        <td>
                                            <a href="{{ url('/admin/admins/' . $item->id) }}" title="View Admin"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/admins/' . $item->id . '/edit') }}" title="Edit Admin"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/admin/admins' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Admin" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $admins->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
