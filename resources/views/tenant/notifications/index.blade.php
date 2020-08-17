@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h2>Notifiactions</h2></div>
                    <div class="card-body" style="overflow-y: auto;">
                        <br/>
                        <br/>
                        {{-- Notifications Timeline --}}
                        <div class="row">
                            <div class="col-md-12">
                                @if ($notifications->count() <= 0)
                                        <div class="my-3"><b>You don't have any Notifications!</b></div>
                                @endif
                                <!-- The time line -->
                                <div class="timeline">
                                <!-- timeline time label -->
                                <div class="time-label">
                                <span class="bg-red">{{date('d-M-Y')}}</span>
                                </div>
                                <!-- /.timeline-label -->
                                @if ($notifications->count() > 0)
                                    @foreach ($notifications as $notification)
                                        {{-- INVOICE SENT --}}
                                        @if ($notification->data['notification_type'] == 'invoice sent')
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-file-invoice bg-danger"></i>
                                                <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{$notification->created_at->diffForHumans()}}</span>
                                                <h3 class="timeline-header"><a href="#">From REMSS:</a> You have new {{$notification->data['notification_type']}}</h3>

                                                <div class="timeline-body">
                                                    {{$notification->data['subject']}}
                                                </div>
                                                <div class="timeline-footer">
                                                    <a class="btn btn-success btn-sm" href="/tenant/invoices/{{$notification->data['id']}}">Read more</a>
                                                    @if ($notification->read_at == null)
                                                        <a class="btn btn-primary btn-sm" href="/tenant/notifications/{{$notification->id}}/notificationRead">Mark as Read</a>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @endif
                                        {{-- INVOICE PAID --}}
                                        @if ($notification->data['notification_type'] == 'invoice paid')
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fas fa-dollar-sign bg-success"></i>
                                                <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{$notification->created_at->diffForHumans()}}</span>
                                                <h3 class="timeline-header"><a href="#">From REMSS:</a> You have new {{$notification->data['notification_type']}}</h3>

                                                <div class="timeline-body">
                                                    {{$notification->data['subject']}}
                                                </div>
                                                <div class="timeline-footer">
                                                    <a class="btn btn-success btn-sm" href="/tenant/payments/{{$notification->data['id']}}">Read more</a>
                                                    @if ($notification->read_at == null)
                                                        <a class="btn btn-primary btn-sm" href="/tenant/notifications/{{$notification->id}}/notificationRead">Mark as Read</a>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @endif
                                        {{-- NOTICE  --}}
                                        @if ($notification->data['notification_type'] == 'notice')
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-bullhorn bg-warning"></i>
                                                <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{$notification->created_at->diffForHumans()}}</span>
                                                <h3 class="timeline-header"><a href="#">From REMSS:</a> You have new {{$notification->data['notification_type']}}</h3>

                                                <div class="timeline-body">
                                                    {{$notification->data['subject']}}
                                                </div>
                                                <div class="timeline-footer">
                                                    <a class="btn btn-success btn-sm" href="/tenant/notices/{{$notification->data['id']}}">Read more</a>
                                                    @if ($notification->read_at == null)
                                                        <a class="btn btn-primary btn-sm" href="/tenant/notifications/{{$notification->id}}/notificationRead">Mark as Read</a>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @endif
                                    @endforeach
                                @endif
                                <!-- END timeline item -->
                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
