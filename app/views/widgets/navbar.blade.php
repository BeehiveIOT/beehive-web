<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <i class="fa fa-bars"></i>
    </button>
    <a class="navbar-brand" href="#">Beehive</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="active"><a href="/real-time">Prueba Real-Time</a></li>
      <!-- <li><a href="#">Link</a></li> -->
    </ul>
    <form class="navbar-form navbar-left" role="search">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <button type="submit" class="btn btn-light"><i class="fa fa-search"></i></button>
    </form>
    <ul class="nav navbar-nav navbar-right">
      @if (Auth::check())
      <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">Actions <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="{{url('devices')}}">Manage Devices</a></li>
          <li><a href="{{url('templates')}}">Manage Templates</a></li>
          <!-- <li class="divider"></li> -->
        </ul>
      </li>
      <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">
          <img id="navbar-profile" src="{{ViewHelper::avatar(Auth::user()->picture_url)}}" width="35px" height="35px" class='img-circle'>
          {{--Auth::user()->username--}}
          <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="{{url('profile')}}">Profile</a></li>
          <li class="divider"></li>
          <li>
            <a href="javascript:document.getElementById('logout').submit()" title="">
              Logout
            </a>
          </li>
        </ul>
          {{Form::open(['id'=>'logout', 'url'=>'logout'])}}
          {{Form::close()}}
      </li>
      @else
        <li><a href="{{url('login')}}" title="Log In">Log In</a></li>
      @endif
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
