<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Usuario</th>
      <th>Descripcion</th>
      <!--
       Aqui comento el iva por que asi se me pidio
      -->
      {{-- <th>IVA</th> --}}
      <th>Monto</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($quotations as $quotation)
      <tr>
        <td>{{$quotation->id}}</td>
        <td>{{$quotation->user->name}}</td>
        <td>{{$quotation->description}}</td>
        <!--
         Aqui comento el iva por que asi se me pidio
        -->
        {{-- <td>${{number_format($quotation->iva,2)}}</td> --}}
        <td>${{number_format($quotation->qty,2)}}</td>
        <td>${{number_format($quotation->total,2)}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
