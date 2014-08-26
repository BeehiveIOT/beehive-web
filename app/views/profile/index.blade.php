@extends('master')

@section('content')
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="panel panel-dark profile">
      <div class="panel-body">
        <div class="avatar-container">
          <img src="{{ViewHelper::avatar($model->picture_url)}}" class="img-circle">
          <h2>{{{$model->name}}}</h2>
          <span><i>{{$model->username}}</i></span>
          <h3>{{ViewHelper::country($model->country)}}</h3>
          <a href="mailto:{{$model->email}}?subject=feedback">{{$model->email}}</a>
          @if($model->organization)
            <br>I'm part of
            <span><i>{{{$model->organization}}}</i></span>
          @endif
          @if($model->website)
            <br>
            <a href="{{{$model->website}}}">{{$model->website}}</a>
          @endif
        </div>
        @if(Auth::user()->id === $model->id)
          <div class="edit-option">
            <a href="{{url('profile/edit')}}" title="Edit" class="btn btn-default">
              <i class="fa fa-pencil"></i>
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@stop

