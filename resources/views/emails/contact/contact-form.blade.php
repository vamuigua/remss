@component('mail::message')
# You have a new Message!

<strong>From:</strong>
{{$data['name'] }} - <i>( {{$data['email'] }} )</i>

<strong>Message:</strong>
<p>{{$data['message'] }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
