<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/hojasdevida/models/HojadeVidaModel.php'); 
require_once($raiz.'/tipoParte/models/TipoParteModel.php'); 
require_once($raiz.'/subtipos/models/SubtipoParteModel.php');  
require_once($raiz.'/hardware/models/HardwareModel.php');  
require_once($raiz.'/pedidos/models/EstadoInicioPedidoModel.php');  
require_once($raiz.'/vista/vista.php');  

class hojasdeVidaView extends vista
{

    protected $model ; 
    protected $tipoParteModel ; 
    protected $subTipoParteModel ; 
    protected $HardwareModel ; 
    protected $estadoInicioPedidoModel ; 

    public function __construct()
    {
        session_start();
        $this->model = new HojadeVidaModel();
        $this->tipoParteModel = new TipoParteModel();
        $this->subTipoParteModel = new SubTipoParteModel();
        $this->HardwareModel = new HardwareModel();
        $this->estadoInicioPedidoModel = new EstadoInicioPedidoModel();
       
    }
    public function hojasdeVidaMenu()
    {
      ?>
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>
          <div style="padding:10px;"  id="div_general_hojasdevida">
               <h2>Hojas de Vida Hardware</h2>
                <div class="row" id="div_botonesyfiltros">
                  <label class="col-lg-2">SERIAL:</label>
                  <div class="col-lg-4 ">
                      <input 
                           placeholder ="SERIAL"
                           class="form-control" 
                           type="text" 
                           id="inputBuscarHardware" 
                           onkeyup="fitrarHardwareHojasDeVida();">
                  </div>  
                <br>
               </div>
               <div id="div_movimientos_hardware" class="mt-3">
                   <?php  
                       $hardwards = $this->HardwareModel->traerHardwareTodosLosEstados(); 
                       $this->traerHardwareHojasDeVida($hardwards);  
                   ?>
               </div>
          </div>
          <?php  $this->modalDevolucionABodega(); ?>
          <?php  $this->modalHardwareMostrarHojasDeVida(); ?>
          <?php  $this->modalCrearMovimientoManual(); ?>
      </body>
      </html>
      
      <?php
    }
 

    public function traerHardwareHojasDeVida($hardwards)
    {
        
        ?>
        <table class="table table-striped hover-hover">
            <thead>
                <th>Serial</th>
                <th>No Importacion</th>
                <th>Estado</th>
                <th>Ver mas</th>
                <th>Devolver</th>
                <th>Dar Baja</th>
                
                
                <th>Ver</th>
            </thead>
            <tbody>
                <?php
                    foreach($hardwards as $hardward)
                    {
                        $infoEstado = $this->estadoInicioPedidoModel->traerEstadosInicioPedidoId($hardward['idEstadoInventario']);      
                        // $this->printR($estado);
                       $estado =  $hardward['idEstadoInventario'];
                       echo '<tr>'; 
                       echo '<td>'.$hardward['serial'].'</td>';
                       echo '<td>'.$hardward['idImportacion'].'</td>';
                       echo '<td>'.$infoEstado['descripcion'].'</td>';
                       echo '<td>';
                       echo '<button 
                       data-bs-toggle="modal" 
                       data-bs-target="#modalHardwareMostrarHojasDeVida"
                       onclick="verHardwareHojasDeVida('.$hardward['id'].');" class="btn btn-primary btn-sm ">
                       Ver
                       </button>' ;
                       echo '</td>';
                       if($hardward['idEstadoInventario']>0)
                       {
                            if($_SESSION['nivel'] >6 || $_SESSION['nivel'] ==5)
                            {
                                echo '<td><button 
                                    class="btn btn-info btn-sm"
                                     data-bs-toggle="modal" 
                                    data-bs-target="#modalDevolucionABodega"
                                    onclick="formuRealizarDevolucionABodega('.$hardward['id'].');"
                                    >Devolucion</button></td>';
                            }else { echo '<td></td>';}    
                       }else{
                        echo '<td></td>';
                       }

                       $dadodebaja = 4;
                       if($estado == $dadodebaja)
                       {

                           echo '<td><button 
                                       class="btn btn-secondary btn-sm " 
                                       onclick="habilitarHardware('.$hardward['id'].');"
                                       >Habilitar</button></td>';
                       }else{
                           if($_SESSION['nivel'] >6 || $_SESSION['nivel'] ==5)
                           {
                                    echo '<td><button 
                                    class="btn btn-primary btn-sm " 
                                    onclick="verificarDarDeBaja('.$hardward['id'].');"
                                    >Dar Baja</button></td>';
                           }else {
                            echo '<td></td>';
                           }
                       }

                       echo '<td><button 
                                   class="btn btn-primary btn-sm " 
                                   onclick="verMovimientosHardware('.$hardward['id'].');"
                                   >Historial</button></td>';
                       echo '</tr>';  
                      }
                      ?>
                  </tbody>
              </table> 
      <?php
      

    }
 

    public function modalDevolucionABodega()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalDevolucionABodega" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Devolucion Serial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyDevolucionABodega">
                    
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hojasdevida();" >Cerrar</button>

                </div>
                </div>
            </div>
            </div>

        <?php
    }
  

    public function modalHardwareMostrarHojasDeVida()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalHardwareMostrarHojasDeVida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Info Hardware</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyHardwareMostrarHojasDeVida">
                    ...
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hardwareMenu();">Cerrar</button>
                    <!-- <button onclick ="actualizarProducto();" type="button" class="btn btn-primary">Actualizar Producto</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }

    public function modalCrearMovimientoManual()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalCrearMovimientoManual" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO HISTORIAL</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodymodalCrearMovimientoManual">
                    
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hojasdevida();" >Cerrar</button>

                </div>
                </div>
            </div>
            </div>

        <?php
    }
    public function traerHardwareFiltrado($inputBuscarHardware)
    {
        $hardwards = $this->HardwareModel->traerHardwareFiltro($inputBuscarHardware); 
        ?>
        <table class="table table-striped hover-hover">
                  <thead>
                      <th>Serial</th>
                      <th>No Importacion</th>
                    
                      <th>Ver</th>
                  </thead>
              <tbody>
                  <?php
                    foreach($hardwards as $hardward)
                    {
            
                         echo '<tr>'; 
                        echo '<td>'.$hardward['serial'].'</td>';
                        echo '<td>'.$hardward['idImportacion'].'</td>';
                         echo '<td><button 
                                   class="btn btn-primary btn-sm " 
                                   onclick="verMovimientosHardware('.$hardward['id'].');"
                                   >Ver</button></td>';
                         echo '</tr>';  
                      }
                      ?>
                  </tbody>
              </table> 
      <?php
      

    }
    public function traerHardwareFiltradoHojasDeVida($inputBuscarHardware)
    {
        $hardwards = $this->HardwareModel->traerHardwareFiltroHojasDeVida($inputBuscarHardware); 
        ?>
        <table class="table table-striped hover-hover">
                  <thead>
                      <th>Serial</th>
                      <th>No Importacion</th>
                    
                      <th>Ver</th>
                  </thead>
              <tbody>
                  <?php
                    foreach($hardwards as $hardward)
                    {
            
                         echo '<tr>'; 
                        echo '<td>'.$hardward['serial'].'</td>';
                        echo '<td>'.$hardward['idImportacion'].'</td>';
                         echo '<td><button 
                                   class="btn btn-primary btn-sm " 
                                   onclick="verMovimientosHardware('.$hardward['id'].');"
                                   >Ver</button></td>';
                         echo '</tr>';  
                      }
                      ?>
                  </tbody>
              </table> 
      <?php
      

    }


}