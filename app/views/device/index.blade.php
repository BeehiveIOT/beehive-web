@extends('master')

@section('content')
{{Form::token(['id'=>'foobar'])}}
<div ng-view>

</div>
@stop

@section('scripts')
<script src="{{ asset('assets/vendors/js/angular.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/angular-route.min.js') }}"></script>
<script src="{{ asset('assets/js/devices.js') }}"></script>
@stop
