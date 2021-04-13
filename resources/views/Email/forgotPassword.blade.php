@component('mail::message')
# Change Password

@component('mail::button', ['url' => 'http://localhost:4200/updatePass?token='.$token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent