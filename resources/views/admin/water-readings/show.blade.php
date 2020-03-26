@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Water Reading {{ $waterreading->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/water-readings') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/water-readings/' . $waterreading->id . '/edit') }}" title="Edit WaterReading"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/waterreadings' . '/' . $waterreading->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete WaterReading" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> House No. </th><td><a href="{{ url('/admin/houses/'.$waterreading->house->id) }}">{{ $waterreading->house->house_no }}</a></td></tr>
                                    <tr><th> Prev Reading </th><td> {{ $waterreading->prev_reading }} </td></tr>
                                    <tr><th> Current Reading </th><td> {{ $waterreading->current_reading }} </td></tr>
                                    <tr><th> Units used </th><td> {{ $waterreading->units_used }} </td></tr>
                                    <tr><th> Cost Per Unit </th><td> {{ $waterreading->cost_per_unit }} </td></tr>
                                    <tr><th> Total Charges </th><td> KSH. {{ $waterreading->total_charges }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
