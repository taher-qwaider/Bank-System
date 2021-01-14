@component('mail::message')
# WellCome {{ $admin->full_name }} in Bank System

We are happy to see you here.
@component('mail::panel')
Your password : password.
@endcomponent

@component('mail::button', ['url' => 'http://127.0.0.1:8000/cms/admin/login'])
login cms Admin
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
