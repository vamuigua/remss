@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Event {{ $event->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/events') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/events/' . $event->id . '/edit') }}" title="Edit Event"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/events' . '/' . $event->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Event" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Event Name </th><td> {{ $event->event_name }} </td></tr>
                                    <tr><th> Event Description </th><td> {{ $event->description }} </td></tr>
                                    <tr><th> All Day </th><td> {{ $event->all_day == 'true' ? 'Yes' : 'No' }} </td></tr>
                                    <tr><th> Start Date - Start Time</th><td> {{ ($event->start_date) }} - {{ isset($event->start_time) ? $event->start_time : 'N/A' }} </td></tr>
                                    <tr><th> End Date - End Time </th><td> {{ $event->end_date }} - {{ isset($event->end_time) ? $event->end_time : 'N/A' }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
