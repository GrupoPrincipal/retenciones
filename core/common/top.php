<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Grupo Principal</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles/plugins/fonts/font-awesome.css">
  <link rel="stylesheet" href="styles/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="styles/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="styles/components.min.css">
  <link rel="stylesheet" href="styles/plugins/jqueryui/jquery-ui.css"> 
  <link rel="stylesheet" href="styles/plugins/daterangepicker/jquery.comiseo.daterangepicker.css">
  <link rel="stylesheet" href="styles/plugins/datatables/datatables.css">
  <link rel="stylesheet" href="styles/plugins/select2/select2.css">
  <link rel="stylesheet" href="styles/mystyle.css">
  <link rel="stylesheet" href="styles/jqueryui/jquery-ui.css"> 
  <link rel="stylesheet" href="styles/fancybox/jquery.fancybox.css"> 
  
  <link rel="stylesheet" href="styles/mystyle.css">
  
  
  
  <link rel="icon" href="styles/images/icono.png">
    
    <!-- ./wrapper -->
    <!-- REQUIRED JS SCRIPTS -->
    <!-- jQuery 2.2.3 -->
    <script src="styles/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="styles/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="styles/dist/js/app.min.js"></script>
    <script src="styles/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="styles/plugins/jqueryui/jquery-ui.min.js"></script>
    <script src="styles/plugins/daterangepicker/moment.min.js"></script>
    <script src="styles/plugins/daterangepicker/jquery.comiseo.daterangepicker.js"></script>
    
    <script src="styles/plugins/datatables/datatables.js"></script>
    <script src="styles/plugins/select2/select2.full.js"></script>

<script type="text/javascript" src="styles/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="styles/fancybox/jquery.fancybox.js"></script>
    
    <script>
        function salir(){
            $.post("app/salir.php", function(){
                window.location = "http://www.gdp.com.ve/wp-content/themes/Impreza/logaut.php";
            })
        }
    </script>
</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?php echo APPROOT ?>index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
          <img src="styles/images/icono.png" style="width:100%;">
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Distribuciones Principal</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only"></span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">tienes 4 pedidos pendientes</li>
              <li>
                <ul class="menu">
                    <a href="#">
                      <div class="pull-left">
                        <img src="styles/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        aplicacion
                        <small><i class="fa fa-clock-o"></i> 2 dias</small>
                      </h4>
                      <p>pedido?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">todos los pedidos</a></li>
            </ul>
          </li>
           /.messages-menu -->

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <!-- foto del usuario
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              -->
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $_SESSION['user_gdp']['login'] ?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">

                <!-- foto del usuario
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> 
                -->

                <p>
                  <?php echo $_SESSION['user_gdp']['user'] ?> 
                  <small><?php echo date("d-m-Y"); ?></small>
                </p>
              </li>
              <!-- Menu Body 
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Seguidores</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Ventas</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Amigos</a>
                  </div>
                </div>
                <!-- /.row 
              </li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div> -->
                <div class="pull-right">
                  <a href="#" onclick="salir()" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button  menu lateral derecho-->
          <!--
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
            <span class="img-circle" style="width:40px;height:40px;display:block;background:#fff;"></span>
          <!-- <img src="styles/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['user_gdp']['login'] ?> </p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header" >Menu</li>
         <li ><a href="https://www.gdp.com.ve/iniciar/"><i class="fa fa-home"></i> <span>INICIO</span></a>
               <ul class="treeview-menu menu-open">
                   <li><a href="https://www.gdp.com.ve/iniciar/"><i class="fa fa-home"></i>Inicio </a></li>
                   <li><a href="http://www.gdp.com.ve/"><i class="fa fa-file-o"></i>Pagina web </a></li>
              </ul>
          </li>
        <li ><a href="#"><i class="fa fa-clone"></i> <span>Retenciones</span></a>
               <ul class="treeview-menu menu-open">
                   <li><a href="?view=consultar"><i class="fa fa-ticket"></i>Consultar </a></li>
              </ul>
          </li>
                
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    