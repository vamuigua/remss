@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tenants</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/tenants/create') }}" class="btn btn-success btn-sm my-2" title="Add New Tenant">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New Tenant
                        </a>
                        <!-- Import & Export Tenants Excel Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#import_export_modal">
                            Import & Export Excel
                        </button>
                        <!-- Import & Export Tenants Excel Modal -->
                        <div class="modal fade" id="import_export_modal" tabindex="-1" role="dialog" aria-labelledby="ImportExportModal" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ImportExportExcel">TENANTS: Import & Export Excel</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group {{ $errors->has('excel_format') ? 'has-error' : ''}}">
                                        <form method="GET" action="{{ route('tenants.exportTenantsData') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <label for="excel_format" class="control-label">{{ 'Download Tenant Details to Excel' }}</label>
                                            <select name="excel_format" class="form-control" id="excel_format">
                                                <option value="xlsx">Excel xlsx</option>
                                                <option value="xls">Excel xls</option>
                                                <option value="csv">Excel CSV</option>
                                            </select>
                                            <button class="btn btn-primary my-3">Export to Excel</button>
                                        </form>
                                    </div>
                                    
                                    <form  method="POST" action="{{ route('tenants.importTenantsData') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group {{ $errors->has('import_file') ? 'has-error' : ''}}">
                                            <label for="import_file" class="control-label">{{ 'Import Tenant Details Excel File ' }} <i>(.xlsx, .xls or .csv only)</i>:</label>
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

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Surname</th><th>Other Names</th><th>Email</th><th>House No</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($tenants as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->surname }}</td><td>{{ $item->other_names }}</td><td>{{ $item->email }}</td>
                                    <td>
                                        @if ( $item->house !== null)
                                            <a href="{{ url('/admin/houses/' . $item->house->id) }}">{{ $item->house->house_no }}</a>
                                        @else
                                            <p>Not Assigned</p>
                                        @endif
                                    </td>
                                        <td>
                                            <a href="{{ url('/admin/tenants/' . $item->id) }}" title="View Tenant"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/admin/tenants/' . $item->id . '/edit') }}" title="Edit Tenant"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/admin/tenants' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Tenant" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $tenants->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
