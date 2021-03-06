@extends('master')

@section('content')
<input type="hidden" id="deviceId" value="{{$deviceId}}" />
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-dark">
      <div class="panel-heading"><b>Device Information</b></div>
      <div class="panel-body" id="device-information-panel">
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6 col-md-offset-1">
    <div class="panel panel-dark">
      <div class="panel-heading"><b>Device Data Streams</b></div>
      <div class="panel-body" id="data-stream-panel">
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-dark">
      <div class="panel-heading"><b>Device Commands</b></div>
      <div class="panel-body" id="command-panel"></div>
    </div>
    <div class="panel panel-dark">
      <div class="panel-heading"><b>Command Execution Log</b></div>
      <div class="panel-body" id="execution-log-panel"></div>
    </div>
  </div>
</div>
@stop

@section('styles')
@stop

@section('scripts')
<script src="{{asset('assets/vendors/js/react.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/reflux.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/sockjs-0.3.4.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/jquery.flot.min.js')}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script src="{{asset('assets/foobar.js')}}"></script>
<script src="{{asset('assets/js/frontpage.js')}}"></script>
<script src="{{asset('assets/js/devicePanel.js')}}"></script>
@stop
