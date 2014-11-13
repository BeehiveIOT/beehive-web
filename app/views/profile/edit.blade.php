@extends('master')

@section('content')
<div class="row">
  <div class="col-md-5 col-md-offset-2">
    <div class="panel panel-dark">
      <div class="panel-heading"><b>Basic Information</b></div>
      <div class="panel-body">
        {{Form::open()}}
        <div class="form-group">
          {{Form::label('username', 'Username')}}
          {{Form::text('username', $model->username, [
            'class'=>'form-control',
            'disabled'=>'true',
            'autocomplete'=>'off'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('email', 'Email')}}
          {{Form::email('email', $model->email, [
            'class'=>'form-control',
            'placeholder'=>'e.g. foo@bar.com',
            'disabled'=>'true',
            'autocomplete'=>'off'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('name', 'Name')}}
          {{Form::text('name', $model->name, [
            'class'=>'form-control',
            'placeholder'=>'John Smith',
            'autocomplete'=>'off'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('country', 'Country')}}
          {{Form::select('country', $countries, $model->country, [
            'class'=>'form-control'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('organization', 'Organization')}}
          {{Form::text('organization', $model->organization, [
            'class'=>'form-control',
            'placeholder'=>'e.g. Umbrella',
            'autocomplete'=>'off'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('website', 'Website')}}
          {{Form::text('website', $model->website, [
            'class'=>'form-control',
            'placeholder'=>'http://example.com',
            'autocomplete'=>'off'
          ])}}
        </div>
        <div class="form-group">
          {{Form::submit('Save Changes', [
            'class'=>'btn btn-light btn-block'
          ])}}
        </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-dark profile-upload">
      <div class="panel-heading"><b>Profile Picture</b></div>
      <div class="panel-body">
        <a href="{{url("profile")}}">
          <img id="avatar"
            src='{{asset("uploads/avatars/$model->picture_url")}}' class="img-circle" />
        </a>
        <!-- <input id="avatarUploader" type="file" name="picture_url"> -->
        <div class="btn btn-light fileinput-button">
          <span>Upload Image</span>
          <!-- The file input field used as target for the file upload widget -->
          <input id="avatarUploader" type="file" name="picture_url">
        </div>
      </div>
    </div>
    <div class="panel panel-dark">
      <div class="panel-heading"><b>Security Information</b></div>
      <div class="panel-body">
        {{Form::open(['url'=>url('profile/changepassword')])}}
        <div class="form-group">
          {{Form::label('password', 'Current Password')}}
          {{Form::password('password', [
            'class'=>'form-control',
            'placeholder'=>'Type your password'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('newpassword', 'New Password')}}
          {{Form::password('newpassword', [
            'class'=>'form-control',
            'placeholder'=>'Type your new password'
          ])}}
        </div>
        <div class="form-group">
          {{Form::label('confirm', 'Confirm Password')}}
          {{Form::password('confirm', [
            'class'=>'form-control',
            'placeholder'=>'Confirm your new password'
          ])}}
        </div>
        <div class="form-group">
          {{Form::submit('Change Password', ['class'=>'btn btn-light btn-block'])}}
        </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{asset('assets/vendors/js/upload.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#avatarUploader').fileupload({
      url: '{{url('profile/upload')}}',
      dataType: 'json',
      done: function (e, data) {
        if (data.result.status === 'ok') {
          var tpl = '<div class="alert alert-success alert-dismissable">';
          tpl += '<button type="button" class="close" ';
          tpl += 'data-dismiss="alert" aria-hidden="true">';
          tpl += '&times;</button>';
          tpl += 'Picture updated successfully</div>';
          $('#avatar').attr('src', '/uploads/avatars/' + data.result.fileName);
          $('#navbar-profile').attr('src', '/uploads/avatars/' + data.result.fileName);
          $('#messages').append(tpl);
        }
      },
  }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
@stop
