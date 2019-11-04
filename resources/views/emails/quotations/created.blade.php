@component('mail::message')
# COTIZACIÓN CREADA

<b>{{$notifiable->name}}</b> a creado una nueva cotización:

@component('mail::table')
  |DESCRIPCIÓN|COSTO|IVA|TOTAL|
  |:-----------:|:--------------------:|:-------------------:|:-------------------:|
  |{{$quotation->description}}|{{$quotation->qty}}|{{$quotation->iva()}}|{{$quotation->total()}}
@endcomponent
<p>Para responder a esta cotización, verifique la notificación en el sistema</p>
@component('mail::button', ['url' => url('/'),'color' => 'primary'])
Ir
@endcomponent

Gracias por su atención,<br>
{{ config('app.name') }}
@endcomponent
