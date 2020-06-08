@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h2>Notices</h2></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Subject</th><th>Message</th><th>Sent</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notices as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{!! $item->message !!}</td>
                                        <td>{!! $item->created_at->diffForHumans() !!}</td>
                                        <td>
                                            <a href="{{ url('/tenant/notices/' . $item->id) }}" title="View Notice"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $notices->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
