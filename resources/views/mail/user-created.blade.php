@component('mail::message')
# Welcome to online book library!


Your randomly generated password is "{{ $password }}".
Use this password and your email address to login to the application and change the password after it.

@component('mail::button', ['url' => url('/home')])
Login now
@endcomponent

Thanks,<br>
Online Book Library
@endcomponent
