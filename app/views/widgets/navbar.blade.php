<nav class="navbar navbar-beehive navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a id="menu-toggle" href="javascript:(0)" style="display:inline-block;width:25px;margin-top: 13px; margin-left:9px ;font-size: 18px">
        <img src="{{asset('assets/img/beehive_logo.png')}}" class="navbar-brand-head hidden-sm hidden-xs">
        <img src="{{asset('assets/img/beehive_bee.png')}}" class="navbar-brand-head visible-sm visible-xs">
      </a>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <i class="fa fa-bars"></i>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
      @if(!Auth::check())
        <li class="hidden-xs">
          <a href="/register" title="Registro" class="icon">
            <i class="fa fa-user-plus"></i>
            <span class="visible-xs">Registro</span>
          </a>
        </li>
        <li class="visible-xs">
          <a href="/register" title="Registro">
            <span class="visible-xs">Registro</span>
          </a>
        </li>
        <li class="visible-xs">
          <a href="/login" title="Iniciar Sesión">
            <span class="visible-xs">Inciar Sesión</span>
          </a>
        </li>
        <li class="hidden-xs">
          <a href="/login" title="Iniciar Sesión" class="icon">
            <i class="fa fa-sign-in"></i>
            <span class="visible-xs">Inciar Sesión</span>
          </a>
        </li>
      @else
        <li>
          <a href="#">API Docs</a>
        </li>
        <li class="dropdown">
        <a href="" class="dropdown-toggle" data-toggle="dropdown">
          <img id="navbar-profile" src="{{ViewHelper::avatar(Auth::user()->picture_url)}}" width="35px" height="35px" class='img-circle'>
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
      @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div>
</nav>
