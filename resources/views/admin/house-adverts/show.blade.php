@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">HouseAdvert {{ $houseadvert->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/house-adverts') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/house-adverts/' . $houseadvert->id . '/edit') }}" title="Edit HouseAdvert"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/houseadverts' . '/' . $houseadvert->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete HouseAdvert" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $houseadvert->id }}</td>
                                    </tr>
                                    <tr><th> House </th><td> {{ $houseadvert->house }} </td></tr>
                                    <tr><th> Location </th><td> {{ $houseadvert->location }} </td></tr>
                                    <tr><th> Details </th><td> {{ $houseadvert->details }} </td></tr>
                                    <tr><th> Description </th><td> {{ $houseadvert->description }} </td></tr>
                                    <tr><th> Rent </th><td> {{ $houseadvert->rent }} </td></tr>
                                    <tr><th> Booking Status </th><td> {{ $houseadvert->booking_status }} </td></tr>
                                    <tr>
                                        <th> Images </th>
                                        @foreach($images as $image)
                                            <td> <img src="/storage/{{ $image }}" alt="houseImage"> </td>
                                        @endforeach
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
