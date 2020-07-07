@component('mail::message')
# You have a new {{$data['subject'] }} From REMSS!

<p>The following details where provided from REMSS for a House Booking Request:</p>

<strong>First Name: </strong>{{$data['first_name'] }} 
<br>
<strong>Last Name: </strong>{{$data['last_name'] }} 
<br>
<strong>Email: </strong>{{$data['email'] }}
<br>
<strong>National ID: </strong>{{$data['national_id'] }}
<br>
<strong>Phone No.: </strong>{{$data['phone_no'] }}

<p>If this was you, we will communicate back to you through the email or phone number you provided</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent