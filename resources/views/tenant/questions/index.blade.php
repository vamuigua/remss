@extends('layouts.tenant')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                <div class="card-header">Questions / Feedback?</div>
                    <div class="card-body">
                        <a href="{{ route('tenant.dashboard') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
						<div class="my-3">
							<h3>Do you have any Questions/Feedback? Send us a message!</h3>
						</div>
						
                        <form method="POST" action="{{ route('tenant.questions') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('tenant.questions.form')

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
