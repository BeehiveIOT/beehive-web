<!doctype html>
<html>
<head>
  <meta charset="utf8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Beehive | @yield('title', 'Open Source Internet Of Things Platform')</title>
@if (App::environment('local'))
  <link rel="stylesheet" href="{{asset('assets/vendors/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/font-awesome.min.css')}}">
@else
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"
    rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"
    rel="stylesheet">
@endif
  <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
  @yield('styles')
</head>
<body ng-app="beehive">

@include('widgets.navbar')

<div id="wrapper">
  <!-- Sidebar -->
  @include('widgets.sidebar')
  <!-- /#sidebar-wrapper -->

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="container-fluid">
      @yield('content')
    </div>
  </div>
</div>
<div class="message-log" id="messages" my-messages>
@if($errors->has())
  <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      &times;
    </button>
    @foreach($errors->all() as $error)
      {{ $error }}<br>
    @endforeach
  </div>
@endif
@if(Session::has('error'))
  <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      &times;
    </button>
    {{Session::get('error')}}
  </div>
@endif
@if(Session::has('message'))
  <div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      &times;
    </button>
    {{Session::get('message')}}
  </div>
@endif
</div>

@if (App::environment('local'))
<script src="{{asset('assets/vendors/js/jquery.min.js')}}"></script>
@else
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
@endif
<script src="{{asset('assets/vendors/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
{{-- Scripts --}}
@yield('scripts')
{{-- Templates --}}
@yield('templates')
</body>
</html>
