@extends('master')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/vendors/css/epoch.min.css')}}">
@stop

@section('content')
<div id="messages">
  <h1>Real Time PoC</h1>
  <div id="myChart" class="epoch category10b" style="width: 800px; height: 200px"></div>
  <hr>
  <div id="map-canvas"></div>
</div>
@stop

@section('styles')
<style type="text/css" media="screen">
   #map-canvas { height: 100%; margin: 0; padding: 0;}
</style>
@stop

@section('scripts')
<script src="{{asset('assets/vendors/js/sockjs-0.3.4.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/d3.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/epoch.min.js')}}"></script>
<script src="{{asset('assets/foobar.js')}}"></script>
<script type="text/javascript">
  var myChart;
  var foobar = function() {
    var myData = [
      // The first layer
      {
        label: "Layer 1",
        values: [
          {time: 0, y: 0},
        ]
      },
    ];
    window.myChart = $('#myChart').epoch({
      type: 'time.bar',
      data: myData,
      axes: ['left', 'bottom']
    });
  };

  $(document).ready(function() {
    var messages = $('#messages');
    var x = new BeehiveBridge({
      wsUrl: 'http://localhost:9999/echo',
      deviceKey: 'sergio'
    });

    // When connecting
    x.on('connect', function() {
      foobar();
      console.log('TEST CONNECTED');

      x.subscribe('sensor/temperature', function(data) {
      });
      var d = new Date();
      x.subscribe('sensor/smoke', function(data) {
        if (myChart) {
          myChart.push([{time: d.getTime(), y: parseInt(data.data, 10)}]);
        }
      });
    });

    // x.subscribe('foo/barr/#', function(data) {

    // });

    x.on('error', function(err) {
      console.log('TEST ERROR', err);
    });

    x.connect();
  });
</script>
@stop
