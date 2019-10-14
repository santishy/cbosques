@component('mail::message')
# Presupuestos

Se a creado una nueva cotización

@component('mail::button', ['url' => $url,'color' => 'primary'])
Ir
@endcomponent

Gracias por su atención,<br>
{{ config('app.name') }}
@endcomponent
