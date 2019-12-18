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
          <h5 class="card-title">Reporte de el mes de {{$month}}</h5>
        @elseif(isset($initialDate))
          <h5 class="card-title">Reporte de: {{$initialDate}} a {{$finalDate}}</h5>
        @else
          <h5>Reporte de la cuenta: {{$concept}}</h5>
        @endif
        @include('reports.tables.quotations')
      </div>
    </div>
  </div>
@endsection
