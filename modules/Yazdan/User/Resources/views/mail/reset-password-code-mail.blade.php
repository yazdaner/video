@component('mail::message')
# کد تغییر رمز عبور:

@component('mail::panel')
{{$code}}
@endcomponent

با تشکر<br>
{{ config('app.name') }}
@endcomponent
