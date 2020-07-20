@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Events Calendar</div>
                    <div class="card-body">
                        <a href="{{ url('/admin/events') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        {{-- CALENDAR SCEHDULED EVENTS --}}
                        <div class="col-md-12 my-5">
                            <h1>SCHEDULED EVENTS</h1>
                            {!!  $calendar_details->calendar() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!!  $calendar_details->script() !!}
@endpush