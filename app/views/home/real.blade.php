@extends('master')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/vendors/css/epoch.min.css')}}">
@stop

@section('content')
<div id="messages">
  <h1>Real Time</h1>
  <!-- <div id="myChart" class="epoch category10b" style="width: 800px; height: 200px"></div> -->
  <hr>
  <div class="row">
    <div class="col-md-6">
      <div id="map-canvas" style="height: 400px; width: 100%"></div>
    </div>
    <div class="col-md-6">
      <!-- <button class="btn btn-primary" id="btn-turn-gps-on">Iniciar GPS</button>
      <button class="btn btn-primary" id="btn-turn-gps-off">Detener GPS</button>
      <button class="btn btn-primary" id="btn-start-braking">Frenar</button> -->
      <div id="commands">
        <h4>Comandos</h4>
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{asset('assets/vendors/js/sockjs-0.3.4.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/d3.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/epoch.min.js')}}"></script>
<script src="{{asset('assets/foobar.js')}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script src="{{asset('assets/js/real-time.js')}}"></script>
@stop
