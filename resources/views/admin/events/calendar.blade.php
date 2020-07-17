@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Events Calendar</div>
                    <div class="card-body">
                        {{-- CALENDAR SCEHDULED EVENTS --}}
                        <div class="col-md-12 mb-5">
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