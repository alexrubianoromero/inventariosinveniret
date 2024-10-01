<?php


class loginView
{

    public function __construct()
    {

    }

    public function pantallaInicial()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&family=Montserrat:wght@800&display=swap" rel="stylesheet">
            <script src="https://kit.fontawesome.com/6f07c5d6ff.js" crossorigin="anonymous"></script>
            <title>Document</title>
        </head>
        <body>
        <div id="divTotal" align="center" class="container">
            <input type="hidden" id="id_usuario" style="color:black">
             <input type="hidden" id="usuario" style="color:black">
            <input type="hidden" id="nivel"  style="color:black">
                <div id="div_principal">
                    <?php  $this->pantallaLogueo();  ?>
                </div>
            </div>
            <script src="login/js/login.js"></script>  
        </body>
        </html>
        <!-- <script src="../js/jquery-2.1.1.js"></script>       
    <script src="../js/bootstrap.min.js"></script> -->
        <?php
    }

    public function pantallaLogueo()
    {
        ?>
            <div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="form group row">
                                    <label for="" class="col-md-4 col-form-label" align="right" >Usuario:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control " id="txtUsuario" value="admin">
                                    </div>
                                </div>                    
                                <div class="form group row mt-3">
                                    <label for="" class="col-md-4 col-form-label" align="right">Clave:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control " id="txtClave" value="1234">
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
        <?php
    }


    public function menuPrincipal($request)
    {
        
        if($_SESSION['nivel'] > 2 || $request['nivel']>2)
        {
        }

        ?>
            <h1>Menu Principal</h1>

            <button onclick="usersMenu();" class="btn btn-primary">Usuarios</button>
            <button onclick="profilesMenu();" class="btn btn-primary">Perfiles</button>
            <button class = "btn btn-default bontonsalir" id="btn_salir" onclick="salirSistema();">SALIR <i class="fas fa-sign-out-alt"></i></button>
        <?php
    }

}



?>