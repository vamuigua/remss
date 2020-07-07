@component('mail::message')
# You have a new {{$data['subject'] }} From REMSS!

<strong>From:</strong>
{{$data['name'] }} - <i>( {{$data['email'] }} )</i>

<strong>Message:</strong>
<p>{{$data['message'] }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
