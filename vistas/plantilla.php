<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INVENTARIO D47G </title>

    <link rel="shortcut icon" href="dist/img/AdminLTELogo.png" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    <?php
      session_start();
        //        echo '<pre>'; 
        // print_r($_SESSION); 
        // echo '</pre>';
        // die(); 
      if(!isset($_SESSION['id_usuario']))
      {
          echo 'la sesion ha caducado';
        //   echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
          die();
      }
     include("modulos/navbar.php");
     include("modulos/aside.php");

    ?>

    

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="div_content_wrapper">
          <?php 
            // include "vistas/dashboard.php"   
          ?>
        </div>
        <!-- /.content-wrapper -->

    <?php   include("modulos/footer.php"); ?>

  

     
    </div>
    <!-- ./wrapper -->
    <script>
        function CargarContenido(pagina_php,contenedor)
        {
            $("."+ contenedor).load(pagina_php);
        }
    </script>
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>