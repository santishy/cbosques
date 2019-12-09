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
  <div class="col-md-12">
    <h1 class="text-center">Reporte General</h1>
  </div>
</div>
<div class="row">
  <table class="table table-striped text-center">
    <thead>
      <tr>
        <th>ID</th>
        <th>Concepto</th>
        <th>Monto Inicial</th>
        <th>Monto Actual</th>
        <th>Monto Cotizaciones</th>
        <th>Nom. Cotizaciones A.</th>
      </tr>
    </thead>
    <tbody>
      @foreach($budgets as $budget)
        <tr class="table-primary font-weight-bolder">
          <td>{{$budget->id}}</td>
          <td>{{$budget->specification->concept}}</td>
          <td>${{number_format($budget->specification->qty+$budget->total+$items_total[$budget->id],2)}}</td>
          <td>${{number_format($budget->specification->qty,2)}}</td>
          <td>${{number_format($budget->total,2)}}</th>
          <td>#{{$budget->quotations_count}}</td>
        </tr>
        @foreach($budget->items as $item)
          <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->specification->concept}}</td>
            <td>${{number_format($item->specification->qty+$item->total,2)}}</td>
            <td>${{number_format($item->specification->qty,2)}}</td>
            <td>${{number_format($item->total,2)}}</th>
            <td>#{{$item->quotations_count}}</td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
</div>

@endsection
