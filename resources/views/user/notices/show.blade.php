@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>Notice: {{ $notice->subject }}</b></div>
                    <div class="card-body">
                        <a href="{{route('user.notices.index')}}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Subject </th><td> {{ $notice->subject }} </td></tr>
                                    <tr><th> Message </th><td> {!! $notice->message !!} </td></tr>
                                    <tr><th> Sent</th><td> {{ $notice->created_at->diffForHumans() }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
