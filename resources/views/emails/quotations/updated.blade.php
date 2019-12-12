@component('mail::message')
# Tu cotización a sido respondida.

<p>
  Tu presupuesto, con descripcion: {{$quotation->description}}
  a sido: <b>{{$quotation->status}}</b>
</p>


@isset($quotation->message)
  {{$quotation->message}}
@endisset

@component('mail::button', ['url' => url('/'), 'color' => 'green'])
View Invoice
@endcomponent

Gracias por su atención,<br>
{{ config('app.name') }}
@endcomponent
