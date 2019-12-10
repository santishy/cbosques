@extends('layouts.report')
@section('content')
  <div class="row justify-content-between">
    <div style="max-width:30%;overflow-x:hidden;" class="mb-5">
      <img src="{{asset('images/logo-cursiva.png')}}" alt="" class="img-fluid">
    </div>
    <div class="mb-5 float-right">
      <p class="text-black-50">{{$date}}</p>
    </div>
  </div>
  <div class="row">
    <div class="card">
      <div class="card-body">
        @if(isset($month))
          <h4 class="card-title">Reporte de el mes de {{$month}}</h4>
        @endif
        @if(isset($initialDate))
            <h4 class="card-title">Reporte de: {{$initialDate}} a {{$finalDate}}</h4>
        @endif
        <table class="table table-striped table-responsive-xl table-responsive-sm">
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
                <td>{{$quotation->user->name}}</td>
                <td>{{$quotation->description}}</td>
                <td>${{number_format($quotation->iva,2)}}</td>
                <td>${{number_format($quotation->qty,2)}}</td>
                <td>${{number_format($quotation->total,2)}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
