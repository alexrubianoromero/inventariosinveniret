<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/prioridades/models/PrioridadModel.php'); 
require_once($raiz.'/login/models/UsuarioModel.php'); 
require_once($raiz.'/clientes/models/ClienteModel.php'); 
require_once($raiz.'/pedidos/models/EstadoInicioPedidoModel.php'); 
require_once($raiz.'/pedidos/models/EstadoProcesoItemModel.php'); 
require_once($raiz.'/pedidos/models/PedidoModel.php'); 
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 
require_once($raiz.'/pedidos/views/itemInicioPedidoView.php'); 
require_once($raiz.'/tipoParte/models/TipoParteModel.php'); 
require_once($raiz.'/prioridades/models/PrioridadModel.php'); 
require_once($raiz.'/hardware/models/HardwareModel.php'); 
require_once($raiz.'/impuestos/models/ImpuestoModel.php'); 
require_once($raiz.'/pagos/models/PagoModel.php'); 
require_once($raiz.'/vista/vista.php'); 

// require_once($raiz.'/subtipos/models/SubtipoParteModel.php'); 

class pedidosView extends vista
{
    protected $pedidoModel;
    protected $prioridadModel;
    protected $usuarioModel;
    protected $clienteModel;
    protected $estIniPedModel;
    protected $itemInicioPedidoView;
    protected $tipoParteModel;
    protected $hardwareModel;
    protected $impuestoModel;
    protected $estadoProcesoItemModel;
    protected $itemInicioPedidoModel;
    protected $pagoModel;

    public function __construct()
    {
        session_start();
        if(!isset($_SESSION['id_usuario']))
        {
            echo 'la sesion ha caducado';
            echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
            die();
        }
        $this->pedidoModel = new PedidoModel();
        $this->prioridadModel = new PrioridadModel();
        $this->usuarioModel = new UsuarioModel();
        $this->clienteModel = new ClienteModel();
        $this->estIniPedModel = new EstadoInicioPedidoModel();
        $this->itemInicioPedidoView = new iteminicioPedidoView();
        $this->tipoParteModel = new TipoParteModel();
        $this->hardwareModel = new HardwareModel();
        $this->impuestoModel = new ImpuestoModel();
        $this->estadoProcesoItemModel = new EstadoProcesoItemModel();
        $this->itemInicioPedidoModel = new ItemInicioPedidoModel();
        $this->pagoModel = new PagoModel();
    }
    

    public function pedidosMenu($pedidos)
    {
        $clientes = $this->clienteModel->traerClientes();
        ?>
        <div style="padding:10px;"  id="div_general_pedidos" class="row">

            <div id="botones" class="row">
                <!-- <div class="col-lg-3">
                    <button type="button" 
                    class="btn btn-primary " 
                    onclick="pedidosPorCompletar();"
                    >
                    PEDIDOS POR COMPLETAR
                    </button> 
                </div> -->
                <div class="col-lg-3">
                    <button type="button" 
                    class="btn btn-primary " 
                    onclick="pedidosConItemsIniciopendientes();"
                    >
                    PEDIDOS ITEMS X COMPLETAR 
                    </button> 
                </div>

                <?php   
                if($_SESSION['nivel']!=4)
                {
                ?>   
                <div class="col-lg-3">
                    <button type="button" 
                    class="btn btn-primary " 
                    onclick="itemsCompletadosHistorial();"
                    >
                    ITEMS COMPLETADOS
                    </button> 
                </div>
                <?php 
                }
                ?>  
                <div class="col-lg-3">
                    <select id = "idCLiente" onchange="pedidosFiltrados();" class="form-control" >
                       <option value="-1">SeleccionarCliente</option>
                       <?php  
                           foreach($clientes as $cliente)
                           {
                               echo '<option value ='.$cliente['idcliente'].'>'.$cliente['nombre'].'</option>'; 
                           }
                       ?>
                    </select>
                </div>
                <?php   
                if($_SESSION['nivel']>5)
                {
                ?>           
                    <div class="col-lg-3">
                        <button type="button" 
                        class="btn btn-primary " 
                        onclick="pedirInfoNuevoPedido();"
                        >
                        <!-- data-bs-toggle="modal" 
                        data-bs-target="#modalPedido" -->
                    NUEVO PEDIDO
                        </button> 
                    </div>
                <?php 
                    }
                ?>           


                <div class="col-lg-3">

                </div>
            </div>
            <br>
            <!-- <div id="divMostrarItemsPedidoTecnico" style="padding:5px; border:1px solid black;"></div> -->
            <div id="divMostrarItemsPedidoTecnico" style="padding:5px;"></div>
            <div id="divResultadosPedidos" class="row mt-3">
                 <?php $this->mostrarPedidos($pedidos); ?>
                
            </div>
                
                <?php  
            $this->modalPedido();  
            $this->modalPedidoAsignartecnico();  
            $this->modalPedidoActualizar();  
            $this->modalPedidoVerItemTecnico();  
            $this->modalPedidoBuscarParteOSerial(); 
            $this->modalPedidoActualizar2();  
       
        
            ?>
            
            
        </div>
        <?php
    }
    
    public function mostrarPedidos($pedidos)
    {
        ?>
            <table class="table table-striped hover-hover">
                    <thead>
                        <th>IdPedido.</th>
                        <th>Fecha.</th>
                        <th>Cliente</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                        <th>Ver</th>
                        <th>Imprimir</th>
                    </thead>
                <tbody>
                    <?php
                      foreach($pedidos as $pedido)
                      {
                        $infoCliente = $this->clienteModel->traerClienteId($pedido['idCliente']); 
                           echo '<tr>'; 
                          echo '<td>'.$pedido['idPedido'].'</td>';
                          echo '<td>'.$pedido['fecha'].'</td>';
                          echo '<td>'.$infoCliente[0]['nombre'].'</td>';
                           echo '<td>'.$pedido['observaciones'].'</td>';
                           echo '<td>'.$pedido['idestadoPedido'].'</td>';
                           if($_SESSION['nivel']>6)
                           {
                               echo '<td><button 
                               class="btn btn-primary btn-sm " 
                               onclick="siguientePantallaPedido('.$pedido['idPedido'].');"
                               >Ver</button></td>';
                            }else {
                                echo '<td></td>';
                            }
                           echo '<td>';
                           echo '<a href="pedidos/pdf/ordenPdf3.php?idPedido='.$pedido['idPedido'].'" target="_blank" >PDF</a>'; 
                           echo '</td>';
                           echo '</tr>';  
                        }
                        ?>
                    </tbody>
                </table> 
               
        <?php
    }
    public function modalPedidoBuscarParteOSerial()
    {
            ?>
            <!-- Modal -->
            <div class="modal fade" id="modalPedidoBuscarParteOSerial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buscar Serial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyPedidoBuscarParteOSerial">
                    
                </div>
                <div class="modal-footer">
                    <!-- <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="pedidosPorCompletar();" >Cerrar</button> -->
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="pedidosConItemsIniciopendientes();" >Cerrar</button>
                    <!-- <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="realizarCargaArchivo();" >Crear Pedido</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }

    public function modalPedido()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyPedido">
                    
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hardwareMenu();" >Cerrar</button>
                    <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="realizarCargaArchivo();" >Crear Pedido</button>
                </div>
                </div>
            </div>
            </div>

        <?php
    }
    public function modalPedidoVerItemTecnico()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalPedidoVerItemTecnico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ver Item Asignado </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyPedidoVerItemTecnico">
                    
                </div>
                <div class="modal-footer">
                    <!-- <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hardwareMenu();" >Cerrar</button>
                    <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="realizarCargaArchivo();" >Crear Pedido</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }

    public function modalPedidoActualizar()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalPedidoActualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input id="idPedidoActualizar" type="hidden">
                <div class="modal-body" id="modalBodyPedidoActualizar">
                </div>
                <div class="modal-footer">
                    <button  
                    type="button" 
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal"
                     onclick="llamarSiguientePantallaPedido();" 
                     >Cerrar</button>
                    <!-- <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="realizarCargaArchivo();" >Crear Pedido</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }
  
   
    public function modalPedidoAsignartecnico()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalPedidoAsignartecnico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyPedidoAsignartecnico">
                    
                </div>
                <div class="modal-footer">
                    <!-- <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hardwareMenu();" >Cerrar</button>
                    <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="realizarCargaArchivo();" >Crear Pedido</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }

    public function pedirInfoNuevoPedidoAnte($request)
    {
        $prioridades = $this->prioridadModel->traerPrioridades();
        $tecnicos =  $this->usuarioModel->traerTecnicos(); 
        $clientes = $this->clienteModel->traerClientes();
        $estIniPedModel = $this->estIniPedModel->traerEstadosInicioPedido();
       

        //  echo '123<pre>';
        // print_r($tecnicos); 
        // echo '</pre>';
        // die();
        ?>
         <div>
            <div class="row">
                <div class="col-lg-3">
                    CLIENTE:
                </div>
                <div class="col-lg-9">
                    <select class="form-control" name="idEmpresaCliente" id="idEmpresaCliente" onchange="buscarSucursal123();">
                        <option value ='-1'>Seleccione..</option>
                        <?php
                              foreach($clientes as $cliente)       
                              {
                                 echo '<option value ="'.$cliente['idcliente'].'">'.$cliente['nombre'].'</option>';
                              }
                        ?>

                    </select>
                </div>

            </div>
            <div id="divInfoNuevoPedido" class="row mt-3">
                <div class="col-lg-6">
                    Urgencia:
                    <select  id="idPrioridad">
                            <option value="">Seleccione...</option>
                            <?php
                                 foreach($prioridades as $prioridad)       
                                 {
                                    echo '<option value ="'.$prioridad['id'].'">'.$prioridad['descripcion'].'</option>';
                                 }
                            ?>
                    </select>
                </div>
            
           </div>
     
         </div>   


        <?php
    }

    public function pedirInfoNuevoPedido($request)
    {
        $prioridades = $this->prioridadModel->traerPrioridades();
        $tecnicos =  $this->usuarioModel->traerTecnicos(); 
        $clientes = $this->clienteModel->traerClientes();
        $estIniPedModel = $this->estIniPedModel->traerEstadosInicioPedido();

        //  echo '123<pre>';
        // print_r($tecnicos); 
        // echo '</pre>';
        // die();
        ?>
         <div class="row">
            
                <label class="col-lg-2">
                    CLIENTE:
                </label>
                <div class="col-lg-3">
                    <select class="form-control" name="idEmpresaCliente" id="idEmpresaCliente" onchange="buscarSucursal123();">
                        <option value ='-1'>Seleccione..</option>
                        <?php
                              foreach($clientes as $cliente)       
                              {
                                 echo '<option value ="'.$cliente['idcliente'].'">'.$cliente['nombre'].'</option>';
                              }
                        ?>

                    </select>
                </div>


        </div >
            <div>
                    <button class="btn btn-primary" onclick="continuarAItemsPedido();">Continuar</button>
           </div>
        <?php
    }


   public  function siguientePantallaPedido($idPedido)
   {
        $infoPedido    = $this->pedidoModel->traerPedidoId($idPedido);
        $infoCliente   = $this->clienteModel->traerClienteId($infoPedido['idCliente']);
        $estadosInicio = $this->estIniPedModel->traerEstadosInicioPedido(); 
        $tiposPartes   =   $this->tipoParteModel->traerTodasLosTipoPartes();
        $prioridades   =  $this->prioridadModel->traerPrioridades();
        $tecnicos      = $this->usuarioModel->traerTecnicos();
        $impuestos    = $this->impuestoModel->traerImpuestos();

        //    echo '<pre>'; 
        //     print_r($infoCliente); 
        //     echo '</pre>';
        //     die(); 
        echo '<input type="hidden" id="idPedido" value = "'.$idPedido.'">';
    ?>  
        <div>
            <div class="row" style="padding:5px;">
                <div class="col-lg-4">
                    <label class="col.lg-1"> Fecha:</label>
                    <span class="col-lg-1"><?php  echo $infoPedido['fecha'];  ?></span>
                </div>
                <div class="col-lg-2">
                    <label>OC:</label>
                    <span class="col-lg-2"><?php  echo $infoPedido['idPedido'];  ?></span>
                </div>
                <div class=" row col-lg-4">
                    <div class="col-lg-3">% Retef.
                        <input id="porcenretefuente" value = "<?php  echo $infoPedido['porcenretefuente']; ?>" size="4" >
                    </div>
                    <div class="col-lg-3">% ReteIca
                        <input id="porcenreteica" value = "<?php  echo $infoPedido['porcenreteica'];  ?>" size="4" >

                    </div>
                  
                </div>
                <div class =" row col-lg-2">
                <?php           
                  $saldo =   $this->pedidoModel->traerSaldoPedido($idPedido);                   
                  echo '<button 
                        class="btn btn-success" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalPedidoActualizar"
                        onclick = "actualizarPedido('.$idPedido.');"
                        >Actualizar Pedido
                        </button>';
                  echo '<button 
                        class="btn btn-warning mt-3" 
                        onclick = "verPagosPedido('.$idPedido.');"
                        > Saldo: '.number_format($saldo,0,",",".").'
                        </button>';
                        
                        // data-bs-toggle="modal" 
                        // data-bs-target="#modalPedidoActualizar"
               
                        
                        ?>
                </div>
                
            </div>
        
            <div class="row">
                <div class="col-lg-4">
                    <label class="col.lg-1">Cliente:</label>
                    <span class="col-lg-3"><?php  echo $infoCliente[0]['nombre'];  ?></span>
                </div>
                <div class="col-lg-2">
                    <?php
                      if($infoPedido['wo']==1)  
                      {
                          echo '<label class="col-lg-2" align="rigtht">WO <input type="checkbox" checked  id="checkwo"  onclick="actulizarWoPedido('.$idPedido.');"></label>';
                    }
                    else{
                          echo '<label class="col-lg-2" align="rigtht">WO <input type="checkbox"  id="checkwo"  onclick="actulizarWoPedido('.$idPedido.');"></label>';
                      }
                      if($infoPedido['r']==1)  
                      {
                          echo '<label class="col-lg-2" align="rigtht">R<input type="checkbox" checked  id="checkr"  onclick="actulizarRPedido('.$idPedido.');"></label>';
                    }
                    else{
                          echo '<label class="col-lg-2" align="rigtht">R <input type="checkbox"  id="checkr"  onclick="actulizarRPedido('.$idPedido.');"></label>';
                      }
                      if($infoPedido['i']==1)  
                      {
                          echo '<label class="col-lg-2" align="rigtht">I<input type="checkbox" checked  id="checki"  onclick="actulizarIPedido('.$idPedido.');"></label>';
                    }
                    else{
                          echo '<label class="col-lg-2" align="rigtht">I<input type="checkbox"  id="checki"  onclick="actulizarIPedido('.$idPedido.');"></label>';
                      }

                    ?>
                    
                </div>
             
            </div>
           
            <div class="row">
                 <div class="col-lg-3">
                    Tipo de item Agregar:
                </div>   
                <div class="col-lg-3">
                     <select class="form-control" id = "tipoItem" onchange="mostrarTipoItem();">
                         <option value = "-1">Seleccione</option>
                         <option value = "1">Hardware</option>
                         <option value = "2">Parte</option>
                     </select>

                 </div>   
                 <div class="col-lg-3"></div>   
                 <div class="col-lg-3"></div>   
            </div>

            <div class="row"   style="padding:2px;" class="mt-3">
                    <div id= "divTipoItemPedido"  style="padding:5px;">

                    </div>    
                    <!-- <div id="div_escoger_bodega"></div> -->
                    <div id="div_items_solicitados_pedido" >
                          <?php   $this->itemInicioPedidoView->mostrarItemsInicioPedido($idPedido);  ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- aqui iran los comentarios        -->
                                <textarea 
                                    class="form-control" 
                                    id="comentarios" 
                                    rows = "7"
                                    ><?php  echo   $infoPedido['observaciones']; ?></textarea>
                             </div>            
                                <div class="col-lg-4">
                                    <!-- aqui ira la parte de los calculos totales del pedido  -->
                                    <?php   $this->itemInicioPedidoView->calculoValorespedido($idPedido);  ?>
                                </div>            
                        </div> 
                    </div>
                <div class="row">
                 <?php           
                //   echo '<button 
                //         class="btn btn-primary" 
                //         data-bs-toggle="modal" 
                //         data-bs-target="#modalPedidoActualizar"
                //         onclick = "actualizarPedido('.$idPedido.');"
                //         >Actualizar Pedido
                //         </button>';
                ?>
                </div>

            </div>

            <?php   $this->modalPedidoActualizar();  ?>
          
   <?php
    } 


    public function formuAsignarItemPedidoATecnico($request)
    {
        $prioridades   =  $this->prioridadModel->traerPrioridades();
        $tecnicos      = $this->usuarioModel->traerTecnicos();
      ?>
        <div class="row">
               <div class="col-md-3">
                    <label >Urgencia:</label>
                    <select id="idPrioridad" class="form-control">
                        <option value = ''>Seleccione...</option>
                            <?php
                                    foreach($prioridades as $prioridad)
                                    {
                                        echo '<option value = "'.$prioridad['id'].'">'.$prioridad['descripcion'].'</option>';    
                                    }
                                            
                                ?>
                    </select>         
               </div>

               <div class="col-md-3">
                    <label for="">Tecnico</label>
                      <select id="idTecnico" class="form-control">
                        <option value = ''>Seleccione...</option>
                        <?php
                                foreach($tecnicos as $tecnico)
                                {
                                    echo '<option value = "'.$tecnico['id_usuario'].'">'.$tecnico['nombre'].'</option>';    
                                }
                                        
                            ?>
                      </select>        
               </div>
           
       </div>
       <div class="row">
               <button type="button" 
               class="btn btn-primary  float-right mt-3" 
               onclick="realizarAsignacionTecnicoAItem(<?php echo $request['idItemPedido']  ?>); ";
               data-bs-dismiss="modal"
               >
               Asignar  Tecnico a Item 
           </button>
      </div>
      

      <?php
    }

    
    public function tipoItemHardware($tipoItem)
    {
        $tiposPartes   =   $this->tipoParteModel->traerTipoParteHardware($tipoItem);
        $estadosInicio = $this->estIniPedModel->traerEstadosInicioPedido(); 
        $pulgadas =  $this->hardwareModel->traerInfoCampoTabla('pulgadas');
        $procesadores =  $this->hardwareModel->traerInfoCampoTabla('procesador');
        $generaciones =  $this->hardwareModel->traerInfoCampoTabla('generacion');
        $generaciones =  $this->hardwareModel->traerInfoCampoTabla('generacion');
        $capacidadram =  $this->hardwareModel->traerInfoCampoTabla('capacidadram');
        $capacidaddisco =  $this->hardwareModel->traerInfoCampoTabla('capacidaddisco');
        ?>
        <div class="row" style="padding:2px;">

            <input type="hidden"  id="iobservaciones" value =".">
            <table class="table">
                <thead >
                    
                    <tr>
                       <th>Cantidad</th>
                       <th>Tipo</th>
                       <th>Subtipo</th>
                       <th>Modelo</th>
                       <th>Pulg.</th>
                       <th>Procesador</th>
                       <th>Generacion</th>
                       <th>Ram Tipo</th>
                       <th>Disco Tipo</th>
                       <th>Ram GB</th>
                       <th>Disco GB</th>
                       <th>Estado</th>
                       <th>Precio/Unit</th>
                       <th>Accion</th>
                    </tr>
                </thead> 
                <tbody>
                    
                    <tr>
                        <th><input type="text" id="icantidad" size="1px"></th>
                        <!-- <th><input type="text" id="itipo" size="1px"></th> -->
                        <th>
                            <select id="itipo"  size="1px" onchange="buscarSuptiposParaSelect();">
                                <option value=''>...</option>
                                <?php
                                foreach($tiposPartes as $tipoParte)
                                {
                                    echo '<option value = "'.$tipoParte['id'].'">'.$tipoParte['descripcion'].'</option>';    
                                }
                                
                                ?>
                            </select>
                        </th>
                        <th><select id="isubtipo">222</select> </th>
                        <!-- <th colspan ="6"><input id="iobservaciones" class="form-control"> </th> -->
                        
                        <th><input type="text" id="imodelo" size="1px"></th>
                        <th>
                            <!-- <input type="text" id="ipulgadas" size="1px"> -->
                            <select class ="form-control"  id="ipulgadas" size="1px">
                                <?php  $this->colocarSelectCampoPorDefectoBlanco($pulgadas);  ?>
                            </select>  
                        </th>
                        <th>
                            <select class ="form-control"  id="iprocesador" size="1px">
                                <?php  $this->colocarSelectCampoPorDefectoBlanco($procesadores);  ?>
                            </select>  
                            <!-- <input type="text" id="iprocesador" size="1px"> -->
                        </th>
                        <th>   <select class ="form-control"  id="igeneracion"  size="1px">
                            <?php  $this->colocarSelectCampoPorDefectoBlanco($generaciones);  ?>
                        </select>  
                    </th>
                    <th>
                        <select class ="form-control"  id="iram" size="1px" >
                            <option value ="">Sel..</option>
                            <option value ="DDR2">DDR2</option>
                            <option value ="DDR3">DDR3</option>
                            <option value ="DDR4">DDR4</option>
                        </select>  
                    </th>
                    <th>
                        <select class ="form-control"  id="idisco" size="1px" >
                            <option value ="">Sel..</option>
                            <option value ="Solido">Solido</option>
                            <option value ="Mecanico">Mecanico</option>
                        </select>  
                        
                    </th>
                    <th>
                        <select class ="form-control"  id="icapacidadram"  size="1px">
                            <?php  $this->colocarSelectCampoPorDefectoBlanco($capacidadram);  ?>
                        </select>  
                    </th>
                    <th>
                        <select class ="form-control"  id="icapacidaddisco"  size="1px">
                            <?php  $this->colocarSelectCampoPorDefectoBlanco($capacidaddisco);  ?>
                        </select>  
                    </th>
                    
                        <th>
                            <select id="idEstadoInicio"  size="1px" onchange="verificarSiEsCambioBodega();">
                            <option value="">Seleccione...</option>
                            <?php
                                foreach($estadosInicio as $estadoInicio)
                                {
                                    echo '<option value = "'.$estadoInicio['id'].'">'.$estadoInicio['descripcion'].'</option>';    
                                }
                                
                                ?>
                        </select> 
                        <div id="div_mostrar_opciones_sucursal"></div>
                    </th>
                    <th><input type="text" id="iprecio" size="5px"></th>
                    <?php
                    echo '<th><button class="btn btn-primary btn-sm" onclick="agregarItemInicialPedido('.$tipoItem.');">+</button></th>';
                    ?>           
                    </tr>
                </tbody>
            </table>  
           </div>
            
            <?php

    }

    
    public function tipoItemParte($tipoItem)
    {
        $tiposPartes   =   $this->tipoParteModel->traerTipoParteHardware($tipoItem);
        $estadosInicio = $this->estIniPedModel->traerEstadosInicioPedido(); 
        echo '<input type="hidden"  id="imodelo" value="." >';
        echo '<input type="hidden"  id="ipulgadas"  value="." >';
        echo '<input type="hidden"  id="iprocesador"  value="." >';
        echo '<input type="hidden"  id="igeneracion"  value="." >';
        echo '<input type="hidden"  id="iram"  value="." >';
        echo '<input type="hidden"  id="idisco"  value="." >';
        ?>
        <table class="table">
               <thead >
                   
                   <tr>
                       <th>Cantidad</th>
                       <th>Tipo</th>
                       <th>Subtipo</th>
                       <th>Observaciones</th>
                       <th>Estado</th>
                       <th>Precio</th>
                       <th>Accion</th>
                    </tr>
                </thead> 
                <tbody>

                    <tr>
                        <th><input type="text" id="icantidad" size="1px"></th>
                        <!-- <th><input type="text" id="itipo" size="1px"></th> -->
                        <th>
                            <select id="itipo"  size="1px" onchange="buscarSuptiposParaSelect();">
                                <option value=''>...</option>
                                <?php
                                foreach($tiposPartes as $tipoParte)
                                {
                                    echo '<option value = "'.$tipoParte['id'].'">'.$tipoParte['descripcion'].'</option>';    
                                }
                                
                                ?>
                            </select>
                        </th>
                        <th><select id="isubtipo"></select> </th>
                        <th><input type="text" id="iobservaciones" ></th>
                        <th>
                            <select id="idEstadoInicio"  size="1px" >
                            <option value="">Seleccione...</option>
                            <?php
                                foreach($estadosInicio as $estadoInicio)
                                {
                                    echo '<option value = "'.$estadoInicio['id'].'">'.$estadoInicio['descripcion'].'</option>';    
                                }
                                
                                ?>
                        </select> 
                    </th>
                    <th><input type="text" id="iprecio" size="5px"></th>
                    <?php
                        echo '<th><button class="btn btn-primary btn-sm" onclick="agregarItemInicialPedidoParte('.$tipoItem.');">+</button></th>';
                     ?>           
                    </tr>
            </tbody>
            </table>  

    <?php

    }

    public function pedidosPorCompletar($pedidosPorCompletar)
    {
        // $this->printR($pedidosPorCompletar); 
        // $this->printR($pedidosPorCompletar);
        echo '<div class="row">'; 
        foreach($pedidosPorCompletar as $pedido)
        {
            //con este arreglo traigo cuantos tecnicos estan asignados al pedido
            if($_SESSION['nivel']==4)
            {
                $tecnicos = $this->pedidoModel->traerLosTecnicosConAsginacionIdPedidoSoloTecnicoLogueado($pedido['idPedido']);
            }else{
                $tecnicos = $this->pedidoModel->traerLosTecnicosConAsginacionIdPedido($pedido['idPedido']);
            }
            
            $numeroT=0;
            foreach($tecnicos as $tecnico)
            {
            //    echo '<br>buenas '.$numeroT;   
               $numeroT++;
            } 
            

            if($numeroT==0){
                $altoFila= 40;
            }
            if($numeroT==1){
                $altoFila= 70*$numeroT;
            }
            if($numeroT==2){
                $altoFila= 55*$numeroT;
            }
            if($numeroT==3){
                $altoFila= 46*$numeroT;
            }
            if($numeroT==4){
                $altoFila= 46*$numeroT;
            }
            if($numeroT>4){
                $altoFila= 40*$numeroT;
            }
            // die($numeroT);
            //  $this->printR($tecnicos); 
            ?>
                <!-- <div style="width:150px; height:<?php echo $altoFila ?>px; border:1px solid; display:inline;margin:5px;padding:10px;"> -->
                <div style="width:150px; height:<?php echo $altoFila ?>px;  display:inline;margin:5px;padding:10px;">
                    <div class="row">
                        OC <?php echo $pedido['idPedido'] ?>
                    </div>
                    <div class="row" style="padding:2px;">
                    <?php 
                    foreach($tecnicos as $tecnico)
                    {
                            //aqui se podria colocar el filtro para los tecnicos 
                        // if($_SESSION['nivel'==4])    
                            $infoTecnico = $this->usuarioModel->traerInfoId($tecnico['idTecnico']);
                            $estadoProcesoItem = $this->itemInicioPedidoModel->traerEstadoItemInicioPedidoIdTecnico($pedido['idPedido'],$tecnico['idTecnico']);
                            // $this->printR($estadoProcesoItem);
                                if($estadoProcesoItem['idEstadoProcesoItem'] == 0){$claseBoton = 'btn-primary'; }
                                if($estadoProcesoItem['idEstadoProcesoItem'] == 1){$claseBoton = 'btn-warning'; }
                                if($estadoProcesoItem['idEstadoProcesoItem'] == 2){$claseBoton = 'btn-success'; }
                                
                                if($estadoProcesoItem['idPrioridad'] == 1)
                                {$prioridad = 'B'; 
                                  $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/>
                                  <path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/>
                                </svg>';  
                            }
                            if($estadoProcesoItem['idPrioridad'] == 2){
                                    $prioridad = 'I'; 
                                    $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet-half" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10c0 0 2.5 1.5 5 .5s5-.5 5-.5c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/>
                                    <path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/>
                                  </svg>';  

                                 }
                                if($estadoProcesoItem['idPrioridad'] == 3){
                                    $prioridad = 'A'; 
                                    $icono = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet-fill" viewBox="0 0 16 16">
                                    <path d="M8 16a6 6 0 0 0 6-6c0-1.655-1.122-2.904-2.432-4.362C10.254 4.176 8.75 2.503 8 0c0 0-6 5.686-6 10a6 6 0 0 0 6 6M6.646 4.646l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448c.82-1.641 1.717-2.753 2.093-3.13"/>
                                  </svg>';  
                                }

                            //    die($claseBoton); 
                                // if($pedido)

                                if($estadoProcesoItem['idEstadoProcesoItem'] < 2)
                                {
                                    //aqui se puede evaluar la prioridad 
                                    //con el IdPedido y el tecnico se pueden traer los itemsinicio y hay se toma la prioridad 
                                    //traer la prioridad de iteminicio

                                    echo '<br>';
                                    echo '<button 
                                    onclick="mostrarItemsInicioPedidoTecnicoNuevo('.$pedido['idPedido'].','.$tecnico['idTecnico'].')"; 
                                    class="btn '.$claseBoton.' btn-sm" 
                                    style="margin-bottom:3px;"
                                    
                                    >'.$icono.$prioridad1.' '.$infoTecnico['nombre'].' ' .$infoTecnico['apellido'].
                                    '</button>';
                        }
                    }
                    ?>    
                    </div>
                </div>
            <?php       
        }
        echo '</div>'; 
    }


    public function pedidosItemsCompletados($pedidosPorCompletar)
    {
        //ES PEDIDOS compeltados 

        // $this->printR($pedidosPorCompletar);
        echo '<div class="row">'; 
        foreach($pedidosPorCompletar as $pedido)
        {
                    //con este arreglo traigo cuantos tecnicos estan asignados al pedido
                    $tecnicos = $this->pedidoModel->traerLosTecnicosConAsginacionIdPedido($pedido['idPedido']);
                    $numeroT=0;
                    foreach($tecnicos as $tecnico)
                    {
                    //    echo '<br>buenas '.$numeroT;   
                    $numeroT++;
                    } 
                    

                    if($numeroT==0){
                        $altoFila= 40;
                    }
                    if($numeroT==1){
                        $altoFila= 70*$numeroT;
                    }
                    if($numeroT==2){
                        $altoFila= 55*$numeroT;
                    }
                    if($numeroT==3){
                        $altoFila= 46*$numeroT;
                    }
                    if($numeroT==4){
                        $altoFila= 46*$numeroT;
                    }
                    if($numeroT>4){
                        $altoFila= 40*$numeroT;
                    }
                    // die($numeroT);
                    //  $this->printR($tecnicos); 
                    ?>
                        <!-- <div style="width:150px; height:<?php echo $altoFila ?>px; border:1px solid; display:inline;margin:5px;padding:10px;"> -->
                        <div style="width:150px; height:<?php echo $altoFila ?>px;  display:inline;margin:5px;padding:10px;">
                            <div class="row">
                                OC <?php echo $pedido['idPedido'] ?>
                            </div>
                            <div class="row" style="padding:2px;">
                                <?php 
                                    foreach($tecnicos as $tecnico)
                                    {
                                        $infoTecnico = $this->usuarioModel->traerInfoId($tecnico['idTecnico']);
                                        $estadoProcesoItem = $this->itemInicioPedidoModel->traerEstadoItemInicioPedidoIdTecnico($pedido['idPedido'],$tecnico['idTecnico']);
                                        // $this->printR($estadoProcesoItem);
                                        if($estadoProcesoItem['idEstadoProcesoItem'] == 0){$claseBoton = 'btn-primary'; }
                                        if($estadoProcesoItem['idEstadoProcesoItem'] == 1){$claseBoton = 'btn-warning'; }
                                        if($estadoProcesoItem['idEstadoProcesoItem'] == 2){$claseBoton = 'btn-success'; }
                                    //    die($claseBoton); 
                                        // if($pedido)
                                        //aqui evaluar que el item que tiene asignado el tecnico este finalizado

                                        if($estadoProcesoItem['idEstadoProcesoItem'] ==2)
                                        {

                                            echo   '<br>';
                                            echo   '<button 
                                            onclick="mostrarItemsInicioPedidoTecnicoNuevo('.$pedido['idPedido'].','.$tecnico['idTecnico'].')"; 
                                            class="btn '.$claseBoton.' btn-sm" 
                                            style="margin-bottom:3px"
                                            >'.$infoTecnico['nombre'].' ' .$infoTecnico['apellido'].
                                            '</button>';
                                        }
                                    }
                                ?>    
                            </div>
                        </div>
                    <?php       
        }
        echo '</div>'; 
    }

    public function verPagosPedido($idPedido,$pagos)
    {
        $saldo =   $this->pedidoModel->traerSaldoPedido($idPedido);
        echo '<table class ="table table-striped">'; 
        echo '<tr>'; 
        echo '<td>Fecha</td>';
        echo '<td>Observaciones</td>';
        echo '<td>Valor</td>'; 
        echo '<td>Aplicar</td>'; 
        echo '</tr>';
        
        foreach($pagos as $pago)
        {
        
            echo '<tr>'; 
            if($pago['valor']==0)
            {
                echo '<td><input class ="form-control" type="date" id="date_'.$pago['id'].'"></td>'; 
                echo '<td><textarea  class ="form-control" id="obse_'.$pago['id'].'"></textarea></td>'; 
                echo '<td><input size="6px" type="text"  class ="form-control"id="valor_'.$pago['id'].'"></td>'; 
                echo '<td><button class="btn btn-primary" onclick="aplicarPagosPedido('.$pago['id'].')">Aplicar</button></td>'; 
                
            }
            else {
                echo '<td>'.$pago['fecha'].'</td>'; 
                echo '<td>'.$pago['observaciones'].'</td>'; 
                echo '<td align="right">'.number_format($pago['valor'],0,",",".").'</td>'; 
            }
            
            echo '</tr>';
        
        }
        echo '<tr>'; 
        echo '<td></td>';
        echo '<td>Saldo: </td>';
        echo '<td align="right">'.number_format($saldo,0,",",".").'</td>';
        echo '</tr>';
        echo '</table>';
    }


  
}