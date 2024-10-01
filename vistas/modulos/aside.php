    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">INVENTARIOS D47G</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
       

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                
                <?php 
                    if($_SESSION['nivel']>5)
                    {
                    ?>
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="sucursales();">
                            <!-- <i class="nav-icon fas fa-th"></i> -->
                            <p>
                                Sucursales
                            </p>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                    <?php  
                    if($_SESSION['nivel']==7 ) 
                    {
                        // if() {
                    ?>           
                        <li class="nav-item">
                            <a style="cursor:pointer;" class="nav-link" onclick="users();">
                                <!-- <i class="nav-icon fas fa-th"></i> -->
                                <p>
                                    Usuarios
                                </p>
                            </a>
                        </li>
                    <?php 
                        // } 
                    } 
                    
                    ?>


                    <?php 
                    if($_SESSION['nivel']>5  )
                    {
                    ?>
                    <li class="nav-item">
                        <a style="cursor:pointer;" class="nav-link" onclick="perfiles();">
                            <!-- <i class="nav-icon fas fa-th"></i> -->
                            <p>
                                Perfiles
                            </p>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                    
                    <?php 
                    if($_SESSION['nivel']>4)
                    {
                    ?>
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="inventarios();">
                            <!-- <i class="nav-icon fas fa-th"></i> -->
                            <p>
                                Inventario
                            </p>
                        </a>
                    </li>
                    <?php
                    }
                    ?>

                  
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="pedidos();">
                            <!-- <i class="nav-icon fas fa-th"></i> -->
                            <p>
                                Pedidos
                            </p>
                        </a>
                    </li>
               

                     <?php 
                    if($_SESSION['nivel']>5)
                    {
                    ?>
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="clientes();">
                            <!-- <i class="nav-icon fas fa-th"></i> -->
                            <p>
                                Clientes
                            </p>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="hojasdevida();">
                            <!-- <i class="nav-icon fas fa-th"></i> -->
                            <p>
                                Hojas de Vida
                            </p>
                        </a>
                    </li>

                    <?php 
                    if($_SESSION['nivel']>5)
                    {
                    ?>
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="tablerotecnicos();">
                           
                            <p>
                                Tecnicos
                            </p>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                     <?php 
                    if($_SESSION['nivel']>5)
                    {
                    ?>
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="reportes();">
                       
                            <p>
                                Reportes
                            </p>
                        </a>
                    </li>
                    <?php
                    }
                    ?>
                        <li class="nav-item">
                        <a style="cursor:pointer;" class="nav-link" onclick="cambiarClave();">
                                <!-- <i class="nav-icon fas fa-th"></i> -->
                                <p>
                                    Cambiar Clave
                                </p>
                            </a>
                        </li>
                    <li class="nav-item">
                    <a style="cursor:pointer;" class="nav-link" onclick="salir();">
                            <!-- <i class="nav-icon fas fa-th"></i> -->
                            <p>
                                Salir
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <script>
        $(".nav-link").on('click',function(){
            $(".nav-link").removeClass('active');
            $(this).addClass('active');
        })
    </script>