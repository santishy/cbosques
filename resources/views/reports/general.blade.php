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
  @include('reports.tables.general')
</div>

@endsection
