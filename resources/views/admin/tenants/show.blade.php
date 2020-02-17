@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Tenant: {{ $tenant->surname }} {{ $tenant->other_names }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/tenants') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/tenants/' . $tenant->id . '/edit') }}" title="Edit Tenant"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/tenants' . '/' . $tenant->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Tenant" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th>ID</th><td>{{ $tenant->id }}</td></tr>
                                    <tr><th> Surname </th><td> {{ $tenant->surname }} </td></tr>
                                    <tr><th> Other Names </th><td> {{ $tenant->other_names }} </td></tr>
                                    <tr><th> Gender </th><td> {{ $tenant->gender }} </td></tr>
                                    <tr><th> National ID </th><td> {{ $tenant->national_id }} </td></tr>
                                    <tr><th> Mobile No. </th><td> {{ $tenant->phone_no }} </td></tr>
                                    <tr><th> Email </th><td> {{ $tenant->email }} </td></tr>
                                    <tr><th> Occupying House </th>
                                        <td>
                                            <div class="btn-group-vertical">

                                                @if ( $tenant->house !== null)
                                                    <a href="{{ url('/admin/houses/' . $tenant->house->id) }}">{{ $tenant->house->house_no }}</a>
                                                @else
                                                    <p>None</p>
                                                @endif
                                                
                                                <div class="btn-group my-3" role="group" aria-label="Basic example">
                                                    <!-- Assign House Button trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#assignHouse">
                                                        <i class="fas fa-home nav-icon" aria-hidden="true"></i>
                                                        Assign House
                                                    </button>
                                                    <form method="POST" action="{{ route('tenants.revokeHouse') }}" accept-charset="UTF-8">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Revoke Assigned House" onclick="return confirm(&quot;Confirm Revoke Assigned House?&quot;)"><i class="fa fa-trash" aria-hidden="true"></i> Revoke Assigned House</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="assignHouse" tabindex="-1" role="dialog" aria-labelledby="assignHouseLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form method="POST" action="{{ route('tenants.assignHouse') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assignHouseLabel">Assign House</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ csrf_field() }}
                                                                <div class="form-group {{ $errors->has('house_no') ? 'has-error' : ''}}">
                                                                    <label for="house_no" class="control-label">{{ 'House_no' }}</label>
                                                                    <select name="house_no" class="form-control" id="house_no">
                                                                        @foreach ($houses as $house)
                                                                            <option value="{{ $house->house_no }}" {{ (isset($house->house_no) && $has_house !== null && $tenant->house->house_no == $house->house_no) ? 'selected' : ''}}>{{ $house->house_no }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    {!! $errors->first('house_no', '<p class="help-block">:message</p>') !!}
                                                                    <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr><th> Tenant Photo: </th><td> <img src="{{$tenant->tenantImage()}}" alt="tenantImage"> </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
