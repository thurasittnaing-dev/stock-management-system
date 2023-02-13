@extends('adminlte::page')

@section('title', 'Locations Map')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('location.index') }}">Location</a></li>
            <li class="breadcrumb-item active" aria-current="page">Map</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        <h1>Map</h1>
        <div id="map"></div>
    </div>
@stop

@section('css')
    <style></style>
@stop

@section('js')
    <script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap" ></script>
    <script>
        $(document).ready(function() {
          function initMap() {
              map = new google.maps.Map(document.getElementById("map"), {
                  center: new google.maps.LatLng(lat, lng),
                  zoom: 16,
              });

              let locations = @json($locations);
              $.each(locations, function(index, value) {
                  // console.log(value);
                  const contentString = "<h1>Hello</h1>";

                  const infowindow = new google.maps.InfoWindow({
                      content: contentString
                  });
                  const marker = new google.maps.Marker({
                      position: new google.maps.LatLng(value.lat, value.lng),
                      icon: baseurl + "/uploads/home1.png",
                      title: name,
                      map: map,
                      optimized: true
                  });

                  marker.addListener("click", () => {
                      infowindow.open(map, marker);
                  });
              });
          }
        });
    </script>
@stop
