@extends('master')

@section('content')
<div class="row">
  <div class="col-md-3 col-md-offset-4">
    <div class="form-group">
    {{Form::open()}}
      {{Form::text('username',Input::old('username'), [
        'class'=>'form-control',
        'placeholder'=>'Username',
        'autocomplete'=>'off'
      ])}}
      {{Form::password('password', [
        'class'=>'form-control',
        'placeholder'=>'Password',
        'autocomplete'=>'off',
      ])}}
      {{Form::submit('Log In', [
        'class'=>'btn btn-light btn-block'
      ])}}
      {{Form::close()}}
    </div>
  </div>

</div>
@stop

@section('scripts')
@stop

@section('styles')
@stop
