@extends('master')

@section('content')
{{Form::token(['id'=>'_csrf'])}}
<div ng-view>
</div>
@stop

@section('scripts')
<script src="{{ asset('assets/vendors/js/angular.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/angular-route.min.js') }}"></script>
<script src="{{ asset('assets/js/templates.js') }}"></script>
@stop
