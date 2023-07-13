@component('mail::message')
# کد :

@component('mail::panel')
{{$code}}
@endcomponent

با تشکر<br>
{{ config('app.name') }}
@endcomponent
