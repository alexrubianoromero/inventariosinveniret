<?php

class perfilesView
{

    public function perfilesMenu ($perfiles)
    {
        ?>
        <div class="row" style="padding:10px;" >
            <h3>Perfiles</h3>
            <div id="botones">
             
            </div>
            <div id="resultados">
                <table class="table table-striped hover-hover">
                    <thead>
                        <!-- <th>Id</th> -->
                        <th>Nombre Perfil</th>
                        <!-- <th>Direccion</th> -->
                    </thead>
                    <tbody>
                        
                        <?php
                      foreach($perfiles as $perfil)
                      {
                          echo '<tr>'; 
                        //   echo '<td>'.$perfil['id_perfil']. '</td>';
                          echo '<td>'.$perfil['nombre_perfil']. '</td>';
                        //   echo '<td>'.$sucursal['direccion'].'</td>';
                          echo '</tr>';  
                        }
                        ?>
                    </tbody>
                </table> 
            </div>
            <?php  
                // $this->modalSucursal();  
                ?>
        </div>
        <?php
    } 
}


?>