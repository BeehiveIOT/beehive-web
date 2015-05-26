<!DOCTYPE html>
<html>
<head>
  <title>Beehive prueba de diseño !!! :D</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/font-awesome.min.css')}}">

  <style type="text/css" media="screen">
  .navbar-merx {
  background-color: #26C566;
  border: 0;
  min-height: auto;
  -webkit-box-shadow: 0px 3px 6px 0px rgba(50, 50, 50, 0.36);
  -moz-box-shadow: 0px 3px 6px 0px rgba(50, 50, 50, 0.36);
  box-shadow: 0px 3px 6px 0px rgba(50, 50, 50, 0.36);
}
.navbar-merx .navbar-brand-head {
  margin-top: 20px;
}
.navbar-merx .navbar-brand {
  color: #ffffff;
}
.navbar-merx .navbar-brand:hover, .navbar-merx .navbar-brand:focus {
  color: #ffffff;
}
.navbar-merx .navbar-text {
  color: #ffffff;
}
.navbar-merx .navbar-form {
  line-height: 75px;
  height: 75px;
}
.navbar-merx .navbar-form input[type=text] {
  background-color: #fff;
}
.navbar-merx .navbar-nav > li > a {
  font-size: 14px;
  font-weight: bold;
  text-transform: uppercase;
  color: #ffffff;
  line-height: 100px;
  height: 100px;
  padding-top: 0;
  padding-left: 30px;
  padding-right: 30px;
  padding: 0 30px 0 30px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: border-bottom 0.3s;
  transition: border-bottom 0.3s;
}
.navbar-merx .navbar-nav > li > a:hover, .navbar-merx .navbar-nav > li > a:focus {
  color: #ffffff;
  background-color: #f6f6f6;
  border-bottom: 4px #E5D438 solid;
}
.navbar-merx .navbar-nav > .active > a, .navbar-merx .navbar-nav > .active > a:hover, .navbar-merx .navbar-nav > .active > a:focus {
  color: #ffffff;
  background-color: #f6f6f6;
}
.navbar-merx .navbar-nav > .open > a, .navbar-merx .navbar-nav > .open > a:hover, .navbar-merx .navbar-nav > .open > a:focus {
  color: #ffffff;
  background-color: #f6f6f6;
}
.navbar-merx .navbar-toggle {
  border-color: #f6f6f6;
}
.navbar-merx .navbar-toggle:hover, .navbar-merx .navbar-toggle:focus {
  background-color: #f6f6f6;
}
.navbar-merx .navbar-toggle .icon-bar {
  background-color: #ffffff;
}
.navbar-merx .navbar-collapse,
.navbar-merx .navbar-form {
  border-color: #ffffff;
}
.navbar-merx .navbar-link {
  color: #ffffff;
}
.navbar-merx .navbar-link:hover {
  color: #ffffff;
}

@media (max-width: 767px) {
  #wrapper {
    margin-top: 0;
  }
  .navbar-merx .navbar-brand-head {
    width: 40px;
    height: 40px;
    margin-left: 10px;
    margin-top: 0;
  }
  .navbar-merx .navbar-nav > li > a {
    line-height: 40px;
    height: 30px;
    padding: 0;
  }
  .navbar-merx .navbar-nav > li > a:hover, .navbar-merx .navbar-nav > li > a:focus {
    border-bottom: 0 transparent solid;
  }
  .navbar-merx .navbar-nav .open .dropdown-menu > li > a {
    color: #ffffff;
  }
  .navbar-merx .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-merx .navbar-nav .open .dropdown-menu > li > a:focus {
    color: #ffffff;
  }
  .navbar-merx .navbar-nav .open .dropdown-menu > .active > a, .navbar-merx .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-merx .navbar-nav .open .dropdown-menu > .active > a:focus {
    color: #ffffff;
    background-color: #f6f6f6;
  }
}
.navbar-merx .navbar-nav .icon {
  color: #F2554A;
  font-size: 32px;
  position: relative;
  -webkit-transition: color 0.5s;
  transition: color 0.5s;
}
.navbar-merx .navbar-nav .icon.cart {
  color: #F2554A;
}
.navbar-merx .navbar-nav .icon.cart:hover {
  color: #ac1c1c;
}
.navbar-merx .navbar-nav .icon .badge {
  top: 0;
}
.navbar-merx .navbar-nav .icon:hover {
  color: #ffffff;
  border-bottom: 0;
}

    #wrapper {
        padding-left: 0;
        margin-top: 100px;
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
        background: #3E5050;
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
<nav class="navbar navbar-merx navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a id="menu-toggle" href="javascript:void(0)" style="display:inline-block;width:25px;margin-top: 13px; margin-left:9px ;font-size: 18px">
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
        <li>
          <a href="/shopping-cart" title="Carrito de Compra" class="pulse-shrink icon cart">
            <i class="fa fa-shopping-cart"></i>
            <span id="shopping-badge" class="badge badge-primary"></span>
          </a>
        </li>
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
        <a href="#">Manage Devices</a>
      </li>
      <li>
        <a href="#">Manage Templates</a>
      </li>
      <li>
        <a href="#">Shared Devices</a>
      </li>
      <li>
        <a href="#">History Data</a>
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
