<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/clientes/models/ClienteModel.php'); 
require_once($raiz.'/clientes/models/TipoContribuyenteModel.php'); 
// require_once($raiz.'/subtipos/models/SubtipoParteModel.php'); 
// require_once($raiz.'/marcas/models/MarcaModel.php'); 

class clientesView
{
 protected $model; 
 protected $tipoContriModel; 

 public function __construct()
 {
    $this->model= new ClienteModel(); 
    $this->tipoContriModel= new TipoContribuyenteModel(); 
 }   
 public function clientesMenu($clientes)
 {
    
    ?>
    <div style="padding:5px;">
        <div class="row">
            <div class="col-lg-3">
                <button 
                data-bs-toggle="modal" 
                data-bs-target="#modalNuevoCliente"
                class="btn btn-primary" 
                onclick="formuNuevoCliente();"
                >Nuevo Cliente</button>
            </div>
            <div class="col-lg-3">
                <select id = "idCliente" name="idCliente" onchange="listarClienteFiltradoDesdeClientes();" class="form-control" >
                       <option value="-1">SeleccionarCliente</option>
                       <?php  
                           foreach($clientes as $cliente)
                           {
                               echo '<option value ='.$cliente['idcliente'].'>'.$cliente['nombre'].'</option>'; 
                           }
                       ?>
                </select>
            </div>

        </div>
        <div id="div_resultados_clientes" class="mt-3">
               <?php  $this->mostrarCLientes($clientes);   ?>
        </div>

        <?php   $this->modalNuevoCliente(); ?>
    </div>
    <?php
 }

 public function mostrarCLientes($clientes)
 {
    // $clientes = $this->model->traerClientes(); 
    echo '<table class="table table-striped">';
        echo '<tr>'; 
        echo '<th>Nombre/Razon Social</th>';
        echo '<th>Nit</th>';
        echo '<th>Telefono</th>';
        echo '<th>Correo</th>';
        echo '<th>Direccion</th>';
        echo '<th>Ciudad</th>';
        echo '<th>TipoCont.</th>';
        echo '<th>Sede.</th>';
        echo '</tr>';
        foreach($clientes as $cliente)
        {
            $tipoCont =  $this->tipoContriModel->traerTipoId($cliente['idTipoContribuyente']);
            echo '<tr>'; 
            echo '<td>'.$cliente['nombre'].'</td>'; 
            echo '<td>'.$cliente['identi'].'</td>'; 
            echo '<td>'.$cliente['telefono'].'</td>'; 
            echo '<td>'.$cliente['email'].'</td>'; 
            echo '<td>'.$cliente['direccion'].'</td>'; 
            echo '<td>'.$cliente['ciudad'].'</td>'; 
            echo '<td>'.$tipoCont['descripcion'].'</td>'; 
            echo '<td>'.$cliente['sede'].'</td>'; 
            echo '</tr>';
        }
    echo '</table>';   
 }
 public function modalNuevoCliente()
 {
     ?>
         <!-- Modal -->
         <div class="modal fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="exampleModalLabel">Info Cliente</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body" id="modalBodyNuevoCliente">
                 
             </div>
             <div class="modal-footer">
                 <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="listarClientes();" >Cerrar</button>
                 <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="grabarCliente();" >Grabar Cliente</button>
             </div>
             </div>
         </div>
         </div>

     <?php
 }


 public function formuNuevoCliente()
 {
   
     ?>
     <div class="row">
             <div class="col-md-6">
                 <label for="">Nombre/Razon Social:</label>
                   <input class ="form-control" type="text" id="nombre">          
             </div>
             <div class="col-md-6">
                 <label for="">Nit:</label>
                   <input class ="form-control" type="text" id="nit">          
             </div>
     </div>

     <div class="row">
             <div class="col-md-6">
                 <label for="">Telefono/Celular:</label>
                   <input class ="form-control" type="text" id="telefono">          
             </div>
             <div class="col-md-6">
                 <label for="">Correo:</label>
                   <input class ="form-control" type="text" id="email">          
             </div>
     </div>
     <div class="row">
             <div class="col-md-6">
                 <label for="">Direccion:</label>
                   <input class ="form-control" type="text" id="direccion">          
             </div>
             <div class="col-md-6">
                 <label for="">Ciudad:</label>
                   <input class ="form-control" type="text" id="ciudad">          
             </div>
     </div>
     <div class="row">
             <div class="col-md-6">
                 <label for="">Tipo Contribuyente:</label>
                 <select id="idTipoContribuyente" class ="form-control">
                     <option value ="">Seleccione...</option>
                     <?php
                          $tipoContribuyentes =  $this->tipoContriModel->traerTipoContribuyente();
                         foreach($tipoContribuyentes as $tipoContribuyente)
                         {
                             echo '<option value ="'.$tipoContribuyente['id'].'" >'.$tipoContribuyente['descripcion'].'</option>';
                         }
                     ?>

                 </select>   
                   <!-- <input class ="form-control" type="text" id="id">           -->
             </div>
             <div class="col-md-6">
                 <label for="">Sede:</label>
                   <input class ="form-control" type="text" id="sede">          
             </div>


            
     </div>

     <?php
 }

}