@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Water Readings</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/water-readings/create') }}" class="btn btn-success btn-sm" title="Add New WaterReading">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Water Readings
                        </a>

                        <form method="GET" action="{{ url('/admin/water-readings') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>#</th><th>House</th><th>Prev Reading</th><th>Current Reading</th><th>Total Charges</th><th>Created At</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($waterreadings as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->house->house_no }}</td>
                                        <td>{{ $item->prev_reading }}</td>
                                        <td>{{ $item->current_reading }}</td>
                                        <td>KSH. {{ $item->total_charges }}</td>
                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('/admin/water-readings/' . $item->id) }}" title="View WaterReading"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/water-readings/' . $item->id . '/edit') }}" title="Edit WaterReading"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/admin/water-readings' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete WaterReading" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $waterreadings->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
