@extends('master')

@section('content')
<div class="row" ng-app="deviceEdit">
  <div class="col-md-8 col-md-offset-2 device-edit">
    <div class="row">
      <div class="col-md-2 menu">
        <a href="#/" title="Device Information">Device Information</a>
        <br>
        <a href="#/commands" title="Device Commands">Device Commands</a>
        <br>
        <img src="{{ asset('assets/img/spinner.gif') }}" ng-show="loading">
      </div>
      <div class="col-md-10" ng-view>
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/vendors/js/angular.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/angular-route.min.js') }}"></script>
<script src="{{ asset('assets/js/device-edit.js') }}"></script>
@stop
