@extends('master')

@section('content')
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-dark">
      <div class="panel-heading"><b>Device Information</b></div>
      <div class="panel-body">
      {{Form::model($model, ['method'=>$method, 'url'=>url("models/$model->id")])}}
        <div class="form-group">
          {{Form::label('name', 'Name')}}
          {{Form::text('name', null, [
            'class'=>'form-control',
            'placeholder'=>'e.g. The X-33 model',
            'autocomplete'=>'off'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('communication_type', 'Communication Type')}}
          {{Form::select('communication_type', $communication_types, null, [
            'class'=>'form-control'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('description', 'Description')}}
          {{Form::textArea('description', null, [
            'class'=>'form-control'
          ])}}
        </div>
        <div class="form-group">
          {{Form::submit('Register New Device Model', [
            'class'=>'btn btn-light btn-block'])}}
        </div>
      {{Form::close()}}
      </div>
    </div>
  </div>
</div>
@stop
