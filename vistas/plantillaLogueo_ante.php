<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>INVENTARIOS </title>
    <link rel="shortcut icon" href="dist/img/AdminLTELogo.png" type="image/x-icon">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="divInicialInventarios">
    <input type="hidden" id="id_usuario" style="color:black">
    <input type="hidden" id="usuario" style="color:black">
    <input type="hidden" id="nivel"  style="color:black">
    <div id ="div_principal_inventarios">
        <div>
            <img src="otrologo.jpg">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="form group row">
                                <label for="" class="col-md-4 col-form-label" align="right" >Usuario:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control " id="txtUsuario" value="">
                                </div>
                            </div>                    
                            <div class="form group row mt-3">
                                <label for="" class="col-md-4 col-form-label" align="right">Clave:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control " id="txtClave" value="">
                                </div>
                            </div>                    
                            <div class="row mt-3">
                                    <button  onclick ="verifiqueCredeciales();"   class="btn btn-primary float-center">Ingresar</button>
                                </div>   
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            
            
        </div>
            
            
        </body>
        </html>
           <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
        <script src="js/inicio.js"></script>  
        <script src="users/js/users.js"></script>  
        <script src="sucursales/js/sucursales.js"></script>  
        <script src="inventarios/js/inventarios.js"></script>  
        <script src="hardware/js/hardware.js"></script>  
        <script src="movimientos/js/movimientosPartes.js"></script>  
        <script src="pedidos/js/pedidos.js"></script>  
        <script src="pedidos/js/itemsInicialPedido.js"></script>  
        <script src="clientes/js/clientes.js"></script>  
        <script src="subtipos/js/subtipos.js"></script>  
        <script src="partes/js/partes.js"></script>  
        <script src="hojasdevida/js/hojasdevida.js"></script>  
        <script src="tablerotecnicos/js/tablerotecnicos.js"></script>  
        <script src="pagos/js/pagos.js"></script>  
        <script src="reportes/js/reportes.js"></script>  
        <script>
        function CargarContenido(pagina_php,contenedor)
        {
            $("."+ contenedor).load(pagina_php);
        }
    </script>