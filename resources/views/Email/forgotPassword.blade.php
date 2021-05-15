@component('mail::message')
# Cambiar contraseña

@component('mail::button', ['url' => 'http://localhost:4200/updatePass?token='.$token])
Recuperar contraseña
@endcomponent

Gracias,<br>
MyPet
@endcomponent