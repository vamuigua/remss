@extends('layouts.ADMIN')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">House Adverts</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/house-adverts/create') }}" class="btn btn-success btn-sm" title="Add New HouseAdvert">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>House</th><th>Location</th><th>Booking Status</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($houseadverts as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->house }}</td><td>{{ $item->location }}</td><td>{{ $item->booking_status }}</td>
                                        <td>
                                            <a href="{{ url('/admin/house-adverts/' . $item->id) }}" title="View HouseAdvert"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/house-adverts/' . $item->id . '/edit') }}" title="Edit HouseAdvert"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/admin/house-adverts' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete HouseAdvert" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $houseadverts->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
