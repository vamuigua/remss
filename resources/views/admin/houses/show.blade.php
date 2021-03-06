@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">House {{ $house->house_no }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/houses') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/houses/' . $house->id . '/edit') }}" title="Edit House"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/houses' . '/' . $house->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete House" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $house->id }}</td>
                                    </tr>
                                    <tr><th> House No </th><td> {{ $house->house_no }} </td></tr>
                                    <tr><th> Features </th><td> {!! $house->features !!} </td></tr>
                                    <tr><th> Rent </th><td> {{ $house->rent }} </td></tr>
                                    <tr><th> Status </th><td> {{ $house->status }} </td></tr>
                                    <tr><th> Water Meter No: </th><td> {{ $house->water_meter_no }} </td></tr>
                                    <tr><th> Electricity Meter No: </th><td> {{ $house->electricity_meter_no }} </td></tr>
                                    <tr><th> Occupying Tenant: </th>
                                        <td>
                                            @if ($house->tenant_id  === null)
                                                <p>None</p>
                                            @else
                                                <a href="{{ url('/admin/tenants/' . $house->tenant->id) }}">{{ $house->tenant->surname }} {{ $house->tenant->other_names }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
