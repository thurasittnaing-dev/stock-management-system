@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   
@stop

@section('content')

  {{-- Breadcrum Start --}}
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="">App</a></li>
      <li class="breadcrumb-item active" aria-current="page">Main Dashboard</li>
    </ol>
  </nav>
  {{-- Breadcrum End --}}

    <div class="card p-2">
    </div>
@stop

@section('css')
    <style></style>
@stop

@section('js')
  <script>
    $(document).ready(function(){
    });
  </script>
@stop