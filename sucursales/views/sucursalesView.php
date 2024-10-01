<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/sucursales/models/SucursalModel.php'); 
class sucursalesView
{
    protected $model;
    public function __construct()
    {
        $this->model = new SucursalModel();
    }

    public function sucursalesMenu ($sucursales)
    {
        ?>
        <div class="row" style="padding:10px;" >
            <h3>Sucursales</h3>
            <div id="botones" >
                <!-- Button trigger modal -->
                <button type="button" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalSucursal"
                    class="btn btn-primary" 
                    onclick="pedirInfoSucursal();"
                    >
                    Crear Sucursal
                </button>
            </div>
            <div id="resultados" class ="mt-3">
                <table class="table table-striped hover-hover">
                    <thead>
                        <!-- <th>Id</th> -->
                        <th>Sucursal</th>
                        <th>Direccion</th>
                        <th>Ciudad</th>
                    </thead>
                    <tbody>
                        
                        <?php
                      foreach($sucursales as $sucursal)
                      {
                          echo '<tr>'; 
                        //   echo '<td>'.$sucursal['id']. '</td>';
                          echo '<td>'.$sucursal['nombre']. '</td>';
                          echo '<td>'.$sucursal['direccion'].'</td>';
                          echo '<td>'.$sucursal['ciudad'].'</td>';
                          echo '</tr>';  
                        }
                        ?>
                    </tbody>
                </table> 
            </div>
            <?php  $this->modalSucursal();  ?>
        </div>
        <?php
    } 

    
    public function modalSucursal()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalSucursal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Creacion de Sucursal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodySucursal">
                    ...
                </div>
                <div class="modal-footer">
                    <button onclick="sucursales();" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button onclick ="crearSucursal();" type="button" class="btn btn-primary">Crear Sucursal</button>
                </div>
                </div>
            </div>
            </div>

        <?php
    }

    public function pedirInfoSucursal()
    {
        ?>
        <div class="row">
                <div class="col-md-6">
                    <label for="">Nombre Sucursal:</label>
                      <input class ="form-control" type="text" id="nombreSucursal">          
                </div>
                <div class="col-md-6">
                    <label for="">Direccion:</label>
                      <input class ="form-control" type="text" id="direccionSucursal">          
                </div>
        </div>
        <div class="row">
                <div class="col-md-6">
                    <label for="">Ciudad:</label>
                      <input class ="form-control" type="text" id="ciudad">          
                </div>
                <div class="col-md-6">
                   
                </div>
        </div>
        <!-- <div class="row">
                <div class="col-md-6">
                    <label for="">Password:</label>
                      <input class ="form-control" type="text" id="password">          
                </div>
                <div class="col-md-6">
                    <label for="">email:</label>
                      <input class ="form-control" type="text" id="email">          
                </div>
        </div> -->

        <?php
    }

    public function mostrarSelectSucursales()
    {
        $sucursales =  $this->model->traerSucursales();
        
        echo '<select id="idNuevaSucursal">';
        echo ' <option value = "-1">Seleccionar...</option>';
            foreach($sucursales as $sucursal)
            {
                echo '<option value="'.$sucursal['id'].'">'.$sucursal['nombre'].'</option>';
            }
        echo '</select>';

        
    }


    
}

?>