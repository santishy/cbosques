<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reporte</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
  </head>
  <body>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>Descripcion</th>
          <th>IVA</th>
          <th>Monto</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($quotations as $quotation)
          <tr>
            <td>
              {{$quotation->id}}
            </td>
            <td>{{$quotation->user_name}}</td>
            <td>{{$quotation->description}}</td>
            <td>${{number_format($quotation->iva,2)}}</td>
            <td>${{number_format($quotation->qty,2)}}</td>
            <td>${{number_format($quotation->total,2)}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
