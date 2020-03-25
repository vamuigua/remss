@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Houses</div>
                    <div class="card-body">
                    <div class="my-2">
                        <a href="{{ url('/admin/houses/create') }}" class="btn btn-success btn-sm" title="Add New House">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                        <!-- Import & Export Houses Excel Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#import_export_modal">
                            Import & Export Excel
                        </button>
                    </div>
                        <!-- Import & Export Houses Excel Modal -->
                        <div class="modal fade" id="import_export_modal" tabindex="-1" role="dialog" aria-labelledby="ImportExportModal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ImportExportExcel">HOUSES: Import & Export Excel</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group {{ $errors->has('excel_format') ? 'has-error' : ''}}">
                                        <form method="GET" action="{{ route('houses.exportHousesData') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <label for="excel_format" class="control-label">{{ 'Download House Details to Excel' }}</label>
                                            <select name="excel_format" class="form-control" id="excel_format">
                                                <option value="xlsx">Excel xlsx</option>
                                                <option value="xls">Excel xls</option>
                                                <option value="csv">Excel CSV</option>
                                            </select>
                                            <button class="btn btn-primary my-3">Export to Excel</button>
                                        </form>
                                    </div>
                                    
                                    <form  method="POST" action="{{ route('houses.importHousesData') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group {{ $errors->has('import_file') ? 'has-error' : ''}}">
                                            <label for="import_file" class="control-label">{{ 'Import House Details Excel File ' }} <i>(.xlsx, .xls or .csv only)</i>:</label>
                                            <br>
                                            <input accept=".xlsx, .xls, .csv" type="file" name="import_file" />
                                            <button class="btn btn-primary">Import Excel File</button>
                                            {!! $errors->first('import_file', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>

                        {{-- Errors Panel --}}
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="GET" action="{{ url('/admin/houses') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>#</th><th>House No</th><th>Features</th><th>Status</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($houses as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->house_no }}</td><td>{!! $item->features !!}</td><td>{{ $item->status }}</td>
                                        <td>
                                            <a href="{{ url('/admin/houses/' . $item->id) }}" title="View House"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/houses/' . $item->id . '/edit') }}" title="Edit House"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/admin/houses' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete House" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $houses->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
