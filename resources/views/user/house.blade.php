@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">House {{ $house->house_no }}</div>
                    <div class="card-body">
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
                                                <p>{{ $house->tenant->surname }} {{ $house->tenant->other_names }}</p>
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
