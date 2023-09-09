@component('mail::message')
# کد ثبت نام:

@component('mail::panel')
{{$code}}
@endcomponent

با تشکر<br>
{{ config('app.name') }}
@endcomponent
