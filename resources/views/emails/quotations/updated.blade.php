@component('mail::message')
# cotización {{$quotation->status}}

@isset($quotation->message)
  {{$quotation->message}}
@endisset

@component('mail::button', ['url' => $url,'color' => 'primary'])
Ir
@endcomponent

Gracias por su atención,<br>
{{ config('app.name') }}
@endcomponent