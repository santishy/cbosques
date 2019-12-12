@component('mail::message')
# COTIZACIÓN CREADA

<b> {{$quotation->user->name}} </b> a creado una nueva cotización:

<h2>Detalles</h2>
@component('mail::panel')
<ul>
  <li> <b> Departamento: </b> {{ $quotation->department->name }}  </li>
  <li> <b> Cuenta: </b> {{$quotation->item->specification->concept}}  </li>
  <li> <b> Fondos de cuenta: </b>  $ {{number_format($quotation->item->specification->qty,2)}} </li>
</ul>
@endcomponent


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
