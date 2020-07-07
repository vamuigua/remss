@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Notices</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/notices/create') }}" class="btn btn-success btn-sm" title="Add New Notice">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Notice
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Subject</th><th>Message</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notices as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->subject }}</td><td>{!! $item->message !!}</td>
                                        <td>
                                            <a href="{{ url('/admin/notices/' . $item->id) }}" title="View Notice"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/notices/' . $item->id . '/edit') }}" title="Edit Notice"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/admin/notices' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Notice" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
