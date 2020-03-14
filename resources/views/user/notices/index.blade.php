@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h2>Notices</h2></div>
                    <div class="card-body">
                        <form method="GET" action="{{route('user.notices.index')}}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
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
                                            <a href="{{ url('/user/notices/' . $item->id) }}" title="View Notice"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
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
