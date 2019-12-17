@component('mail::message')
# Usuario Registrado


@component('mail::table')
  |NOMBRE|EMAIL|ROLES|
  |:-----------:|:--------------------:|:-------------------:|
  |{{$user->name}}|{{$user->email}}|{{$user->roles->pluck('display_name')->implode(", ")}}|
@endcomponent

@component('mail::panel')
<h3>Credenciales de acceso</h3>
<ul>
  <li> <b> usuario: </b> {{ $user->email }}  </li>
  <li> <b> password: </b> {{$decryptedPassword}}  </li>
</ul>
@endcomponent

@component('mail::button', ['url' => url('/'),'color' => 'primary'])
Control Presupuestal
@endcomponent

Gracias por su atención,<br>
{{ config('app.name') }}
@endcomponent
