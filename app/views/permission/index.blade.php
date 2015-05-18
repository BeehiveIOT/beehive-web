@extends('master')

@section('content')
{{Form::token(['id'=>'_csrf'])}}
<div id="permission-panel">
</div>
@stop

@section('scripts')
<script src="{{asset('assets/vendors/js/react.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/ReactRouter.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/reflux.min.js')}}"></script>
<script src="{{asset('assets/js/frontpage.js')}}"></script>
<script src="{{asset('assets/js/permissions.js')}}"></script>
@stop
