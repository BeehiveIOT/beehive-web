<!DOCTYPE html>
<html>
<head>
  <title>Beehive prueba de diseño !!! :D</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/font-awesome.min.css')}}">

  <style type="text/css" media="screen">
    #wrapper {
        padding-left: 0;
        margin-top: 50px;
        /* For content animation when toggle */
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #wrapper.toggled {
        padding-left: 220px;
    }

    #sidebar-wrapper {
        z-index: 1000;
        position: fixed;
        left: 220px;
        width: 0;
        height: 100%;
        margin-left: -220px;
        overflow-y: auto;
        background: #161616;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 220px;
    }

    #page-content-wrapper {
        width: 100%;
        position: absolute;
        padding: 15px;
    }

    #wrapper.toggled #page-content-wrapper {
        position: absolute;
        margin-right: -220px;
    }

    /* Sidebar Styles */

    .sidebar-nav {
        position: absolute;
        top: 0;
        width: 220px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .sidebar-nav li {
        text-indent: 20px;
        line-height: 40px;
    }

    .sidebar-nav li a {
        display: block;
        text-decoration: none;
        color: #999999;
    }

    .sidebar-nav li a:hover {
        text-decoration: none;
        color: #fff;
        background: rgba(255,255,255,0.2);
    }

    .sidebar-nav li a:active,
    .sidebar-nav li a:focus {
        text-decoration: none;
    }

    .sidebar-nav > .sidebar-brand {
        height: 65px;
        font-size: 18px;
        line-height: 60px;
    }

    .sidebar-nav > .sidebar-brand a {
        color: #999999;
    }

    .sidebar-nav > .sidebar-brand a:hover {
        color: #fff;
        background: none;
    }

    @media(min-width:768px) {
        #wrapper {
            padding-left: 220px;
        }

        #wrapper.toggled {
            padding-left: 0;
        }

        #sidebar-wrapper {
            width: 220px;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 0;
        }

        #page-content-wrapper {
            padding: 20px;
            position: relative;
        }

        #wrapper.toggled #page-content-wrapper {
            position: relative;
            margin-right: 0;
        }
    }
  </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background: #161616; border-bottom: 0;">
  <!-- Brand and toggle get grouped for better mobile display -->
<div class="container">
  <div class="navbar-header">
    <a id="menu-toggle" href="javascript:(0)" style="display:inline-block;width:25px;margin-top: 13px; margin-left:9px ;font-size: 18px">
      <i class="fa fa-bars"></i>
    </a>
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <i class="fa fa-bars"></i>
    </button>
    <a class="navbar-brand" href="#">Beehive</a>

  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a href="/real-time">Prueba Real-Time</a></li>
    </ul>
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
          Donkeysharp
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
</div>
</nav>
<div id="wrapper">
<!-- Sidebar -->
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li>
        <a href="#">Dashboard</a>
      </li>
      <li>
        <a href="#">Shortcuts</a>
      </li>
      <li>
        <a href="#">Overview</a>
      </li>
      <li>
        <a href="#">Events</a>
      </li>
      <li>
        <a href="#">About</a>
      </li>
      <li>
        <a href="#">Services</a>
      </li>
      <li>
        <a href="#">Contact</a>
      </li>
    </ul>
  </div>
  <!-- /#sidebar-wrapper -->

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1>Simple Sidebar</h1>
          <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
          <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
          <br><br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br><br>
          <br><br><br><br><br><br><br><br><br><br><br>
        </div>
      </div>
    </div>
  </div>
  <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<script src="{{asset('assets/vendors/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/bootstrap.min.js')}}"></script>
<!-- Menu Toggle Script -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
</body>
</html>
