<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/clientes/models/ClienteModel.php'); 
require_once($raiz.'/hardware/models/HardwareModel.php'); 
require_once($raiz.'/pagos/models/PagoModel.php');  
require_once($raiz.'/pedidos/models/EstadoInicioPedidoModel.php');  
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php');  
require_once($raiz.'/pedidos/models/EstadoProcesoItemModel.php');  
require_once($raiz.'/pedidos/models/PedidoModel.php');  
require_once($raiz.'/pedidos/models/AsociadoItemInicioPedidoHardwareOparteModel.php');  
require_once($raiz.'/subtipos/models/SubtipoParteModel.php');  
require_once($raiz.'/marcas/models/MarcaModel.php');  
require_once($raiz.'/login/models/UsuarioModel.php');  
require_once($raiz.'/vista/vista.php'); 

// require_once($raiz.'/subtipos/models/SubtipoParteModel.php'); 

class reportesView extends vista
{
    // protected $reporteModel;
    protected $clienteModel;
    protected $HardwareModel;
    protected $estadoInicioPedidoModel ; 
    protected $EstadoProcesoItemModel ; 
    protected $itemInicioPedidoModel ; 
    protected $subtipoParteModel ; 
    protected $marcaModel ; 
    protected $pedidoModel ; 
    protected $usuarioModel ; 
    protected $asociadoItemModel ; 
    protected $pagoModel ; 
 

    public function __construct()
    {
        $this->clienteModel = new clienteModel();
        $this->HardwareModel = new HardwareModel();
        $this->estadoInicioPedidoModel = new EstadoInicioPedidoModel();
        $this->itemInicioPedidoModel = new ItemInicioPedidoModel();
        $this->subtipoParteModel = new SubtipoParteModel();
        $this->marcaModel = new MarcaModel();
        $this->pedidoModel = new pedidoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->EstadoProcesoItemModel = new EstadoProcesoItemModel();
        $this->asociadoItemModel = new AsociadoItemInicioPedidoHardwareOparteModel();
        $this->pagoModel = new PagoModel();
    }

    public function reportesMenu()
    {
        ?>
        <div style="padding:10px;"  id="div_general_reportes" class="row">
            <div>
                    <!-- REPORTES -->
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <button class="btn btn-primary" onclick="formuReporteVentas();">Reporte de Ventas</button>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary" onclick="reporteEstadoEquipo();">Reporte Estado Equipo</button>
                </div>
                <!-- <div class="col-lg-2">
                <button class="btn btn-primary" onclick="reporteItemsAlistados();">Items Alistados Tecnico</button>
                </div> -->
                <?php  if($_SESSION['nivel']>6){ ?>
                <div class="col-lg-2">
                    <button class="btn btn-primary" onclick="verReporteFinanciero();">Reporte Financiero</button>
                </div>
                <?php } ?>

                <div class="col-lg-2">
                    <select id="idEnviarExcel" class="form-control">
                        <option value ="-1">Excel...</option>
                        <option value ="1">SI</option>
                        <option value ="2">NO</option>
                    
                    </select>

                </div>
                
              

            </div>
            <div id="div_resultados_reportes">

            </div>
        </div>
        <?php
    }
    public function formuReporteVentas()
    {
        ?>
        <div style="padding:10px;"  id="div_general_reportes" class="row">
            <div class="col-lg-4">
                <!-- <label class="col-lg-3"for="">F.Inicial: </label> -->
                <div class="col-lg-4">Fecha Inicial :
                    <input type="date" id="fechaIn" class="form-control">
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- <label class="col-lg-1"for="">F.Final: </label> -->
                <div class="col-lg-4">Fecha Final :
                    <input type="date" id="fechaFin" class="form-control">
                </div>
            </div>
            
            <div class="col-lg-2">
                <button class="btn btn-primary" onclick="generarReporteVentas();">GENERAR REPORTE</button>
            </div>
        </div>

        <?php
    }
    public function mostrarReporteVentas($itemsVentasPedidosFechas)
    {
        ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <!-- <th>Tipo</th>  hardware o parte -->
                        <th>Total</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $granTotal = 0; 
                       foreach($itemsVentasPedidosFechas as $item)
                       {
                          $infoCliente =  $this->clienteModel->traerClienteId($item['idCliente']); 
                          if($item['tipoItem']==1){$tipo = 'Hardware';} else { $tipo = 'Parte';}
                          $sumaItems = $this->itemInicioPedidoModel->traerSumaItemInicioPedido($item['idPedido']);
                          $pagospedido = $this->pagoModel->traerPagosPedido($item['idPedido']); 
                          $sumaPagos = 0;
                          foreach($pagospedido as $pago)
                          {
                            $sumaPagos = $sumaPagos + $pago['valor']; 
                          }
                          $saldoPedido = $sumaItems - $sumaPagos;
                        
                        //   $this->printR($infoCliente); 
                          echo '<tr>';  
                          echo '<td>'.$item['idPedido'].'</td>'; 
                          echo '<td>'.$item['fecha'].'</td>'; 
                          echo '<td>'.$infoCliente[0]['nombre'].'</td>'; 
                          echo '<td align ="right">'.number_format($sumaItems,0,",",".").'</td>'; 
                          echo '<td align ="right">'.number_format($saldoPedido,0,",",".").'</td>'; 
                          

                        //   echo '<td>'.$tipo.'</td>'; 
                        //   echo '<td align="right">'.number_format($item['total'],0,",",".").'</td>'; 
                        //   echo '</tr>';  
                        //   $granTotal = $granTotal + $item['total']; 
                        }  
                        // echo '<tr>';  
                        // echo '<td></td>';
                        // echo '<td></td>';
                        // echo '<td></td>';
                        // echo '<td></td>';
                        // echo '<td align="right">'.number_format($granTotal,0,",",".").'</td>';
                        // echo '</tr>';  

                    ?>
                </tbody>
            </table>

        <?php
    }

    
    public function reporteEstadoEquipo($hardwards)
    {
        // $this->printR($hardwards);
        $estados = $this->estadoInicioPedidoModel->traerEstadosInicioPedido();

        ?>
        <div class="row mt-4" >
            <div class="col-md-4">
            
               
                        <select id="idEstadoFiltrar" class="form-control" onchange="traerEquiposFiltradoEstado()">
                            <option value ="-1">Seleccione Estado...</option>
                            <?php
                            foreach($estados as $estado)
                            {
                                echo '<option value ="'.$estado['id'].'">'.$estado['descripcion'].'</option>';     
                            }
                            ?>
                        </select>
             </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div id="div_mostrar_equipos_filtrados_estado">
                 <?php  $this->verEquipos($hardwards);   ?>       
           
        </div>
    <?php
    }


    public function verEquipos($hardwards)
    {
        ?>
         <table class="table table-striped hover-hover mt-3">
                <thead>
                    <th>Serial</th>
                    <th>No Importacion</th>
                    <th>Estado</th>
                    <th>Tecnico</th>
                    <th>Cliente</th>
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
                        if($estado == 1 || $estado == 1){
                            $infoAsociado = $this->asociadoItemModel->traerAsociadoItemIdAsociado($hardward['idAsociacionItem']); 
                            $infoItemInicio = $this->itemInicioPedidoModel->traerItemInicioPedidoId($infoAsociado['idItemInicioPedido']);
                            $infoTecnico =  $this->usuarioModel->traerInfoId($infoItemInicio['idTecnico']);
                            $infoPedido = $this->pedidoModel->traerPedidoId($infoItemInicio['idPedido']);
                            $infoCliente = $this->clienteModel->traerClienteId($infoPedido['idCliente']); 
                            // $this->printR($infoCliente);
                            echo '<td>'.$infoTecnico['nombre'].'</td>';  
                            echo '<td>'.$infoCliente[0]['nombre'].'</td>';  
                            
                        }else{  
                            echo '<td></td>';
                            echo '<td></td>';
                        }
                        
                       
                    }
                            ?>
                  </tbody>
              </table> 

        <?php
    }
    
    public function verReporteFinanciero($hardwards,$idEnviarExcel)
    {
        // $estados = $this->estadoInicioPedidoModel->traerEstadosInicioPedido();
        ?>
       
        <div id="div_mostrar_reporte_financiero">
                 <?php  $this->verEquiposFinanciero($hardwards,$idEnviarExcel);   ?>       
           
        </div>
    <?php
    }
    
    public function verEquiposFinancieroEstadoEquipo($hardwards,$idEnviarExcel)
    {
        if($idEnviarExcel==1)
        {
            echo '<br>se debe enviar a excdl ';
            // header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            // header("Content-Disposition: attachment; filename=archivo.xls");

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=archivo.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
        }
        ?>
         <table class="table table-striped hover-hover mt-3">
                <thead>
                    <th>No Importacion</th>
                    <th>Lote</th>
                    <th>Serial</th>
                    <th>TipoProducto</th>
                    <th>Chasis</th>
                    <th>Modelo</th>
                    <th>Pulgadas</th>
                    <th>Procesador</th>
                    <th>Generacion</th>
                    <th>Ram</th>
                    <th>Disco</th>
                    <th>Marca</th>
                    <th>OC</th>
                    <th>Fecha OC</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Tecnicos</th>
                  
                </thead>
                <tbody>
                    <?php
                    foreach($hardwards as $hardward)
                    {
                        $infoEstado = $this->estadoInicioPedidoModel->traerEstadosInicioPedidoId($hardward['idEstadoInventario']);
                        $infoSubtipo =  $this->subtipoParteModel->traerSubTipoParte($hardward['idSubInv']);  
                        $infoMarca = $this->marcaModel->traerMarcaId($hardward['idMarca']); 
                        //$numeroPedido  tambien trae precioVenta de asociado
                        $numeroPedido =   $this->itemInicioPedidoModel->traerPedidoConIdAsociadoItem($hardward['idAsociacionItem']);
                        // $this->printR($numeroPedido);
                        $infoPedido =  $this->pedidoModel->traerPedidoId($numeroPedido['pedido']); 

                        $infoAsociadoItemInicio = $this->asociadoItemModel->traerAsociadoItemIdAsociado($hardward['idAsociacionItem']); 
                        $nombreCliente =    $this->itemInicioPedidoModel->traerClientePedido($numeroPedido['pedido']);
                        $gananBase = $hardward['precioMinimoVenta'] - $hardward['costoProducto'];
                        $ganancia = $numeroPedido['precioVenta'] -  $hardward['costoProducto'] ;

                        $estado =  $hardward['idEstadoInventario'];
                   
                      
                        //traer Ram hardware
                        // $this->printR($infoRam1);
                        $infoRam1 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam1']);   
                        $infoRam2 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam2']);   
                        $infoRam3 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam3']);   
                        $infoRam4 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam4']);   
                        $valoresRam = $infoRam1[0]['descripcion'].'-'.$infoRam2[0]['descripcion'].'-'.$infoRam3[0]['descripcion'].'-'.$infoRam4[0]['descripcion'];
                        
                        //traer los discos 
                        $infoDisco1 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idDisco1']);   
                        $infoDisco2 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idDisco2']);   
                        $valoresDiscos = $infoDisco1[0]['descripcion'].'-'.$infoDisco2[0]['descripcion'];

                        //tecnicos
                        $tecnicos = $this->itemInicioPedidoModel->traertecnicosAsociadosAidPedido($numeroPedido['pedido']); 
                        $nombresTecnicos = '';
                        foreach ($tecnicos as $tecnico)
                        {
                            $nombresTecnicos .= $tecnico['nombre'];
                        }

                        echo '<tr>'; 
                        echo '<td>'.$hardward['idImportacion'].'</td>';
                        echo '<td>'.$hardward['lote'].'</td>';
                        echo '<td>'.$hardward['serial'].'</td>';
                        echo '<td>'.$infoSubtipo[0]['descripcion'].'</td>';
                        echo '<td>'.$hardward['chasis'].'</td>';
                        echo '<td>'.$hardward['modelo'].'</td>';
                        echo '<td>'.$hardward['pulgadas'].'</td>';
                        echo '<td>'.$hardward['procesador'].'</td>';
                        echo '<td>'.$hardward['generacion'].'</td>';
                        echo '<td>'.$valoresRam.'</td>';
                        echo '<td>'.$valoresDiscos.'</td>';
                        echo '<td>'.$infoMarca[0]['marca'].'</td>';
                        echo '<td>'.$numeroPedido['pedido'] .'</td>';
                        echo '<td>'.$infoPedido['fecha'].'</td>';
                        echo '<td>'.$nombreCliente .'</td>';
                        echo '<td>'.$infoEstado['descripcion'].'</td>';
                        echo '<td>'.$nombresTecnicos.'</td>';

                      
                        //    $dadodebaja = 4;
                        //    if($estado == $dadodebaja)
                        //    {
                            
                            //        echo '<td><button 
                            //                    class="btn btn-secondary btn-sm " 
                            //                    onclick="habilitarHardware('.$hardward['id'].');"
                            //                    >Habilitar</button></td>';
                            //    }else{
                                
                                //        echo '<td><button 
                                //                    class="btn btn-primary btn-sm " 
                                //                    onclick="verificarDarDeBaja('.$hardward['id'].');"
                                //                    >Dar Baja</button></td>';
                                //    }
                                
                                //    echo '<td><button 
                                //                class="btn btn-primary btn-sm " 
                                //                onclick="verMovimientosHardware('.$hardward['id'].');"
                                //                >Historial</button></td>';
                                //    echo '</tr>';  
                            }
                            ?>
                  </tbody>
              </table> 

        <?php
    }
    public function verEquiposFinanciero($hardwards,$idEnviarExcel)
    {
        if($idEnviarExcel==1)
        {
            echo '<br>se debe enviar a excdl ';
            // header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            // header("Content-Disposition: attachment; filename=archivo.xls");

            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=archivo.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
        }
        ?>
         <table class="table table-striped hover-hover mt-3">
                <thead>
                    <th>No Importacion</th>
                    <th>Lote</th>
                    <th>Serial</th>
                    <th>TipoProducto</th>
                    <th>Chasis</th>
                    <th>Modelo</th>
                    <th>Pulgadas</th>
                    <th>Procesador</th>
                    <th>Generacion</th>
                    <th>Ram</th>
                    <th>Disco</th>
                    <th>Marca</th>
                    <th>OC</th>
                    <th>Fecha OC</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Costo Item</th>
                    <th>Costo Importacion</th>
                    <th>Costo Producto</th>
                    <th>Precio Minimo Venta</th>
                    <th>Precio Real Venta</th>
                    <th>Ganancia Base</th>
                    <th>Ganancia</th>
                    <th>Wo</th>
                    <th>Retefuente</th>
                    <th>ReteIca</th>
                </thead>
                <tbody>
                    <?php
                    foreach($hardwards as $hardward)
                    {
                        $infoEstado = $this->estadoInicioPedidoModel->traerEstadosInicioPedidoId($hardward['idEstadoInventario']);
                        $infoSubtipo =  $this->subtipoParteModel->traerSubTipoParte($hardward['idSubInv']);  
                        $infoMarca = $this->marcaModel->traerMarcaId($hardward['idMarca']); 
                        //$numeroPedido  tambien trae precioVenta de asociado
                        $numeroPedido =   $this->itemInicioPedidoModel->traerPedidoConIdAsociadoItem($hardward['idAsociacionItem']);
                        // $this->printR($numeroPedido);
                        $infoPedido =  $this->pedidoModel->traerPedidoId($numeroPedido['pedido']); 

                        $infoAsociadoItemInicio = $this->asociadoItemModel->traerAsociadoItemIdAsociado($hardward['idAsociacionItem']); 
                        $nombreCliente =    $this->itemInicioPedidoModel->traerClientePedido($numeroPedido['pedido']);
                        $gananBase = $hardward['precioMinimoVenta'] - $hardward['costoProducto'];
                        $ganancia = $numeroPedido['precioVenta'] -  $hardward['costoProducto'] ;

                        $estado =  $hardward['idEstadoInventario'];
                        $retefuente=0;
                        $reteica = 0;
                        if($infoPedido['wo']==1)
                        {  
                            $wo='SI';
                            $retefuente = ($infoPedido ['porcenretefuente'] * $numeroPedido['precioVenta'])/100;
                            $reteica = ($infoPedido ['porcenreteica'] * $numeroPedido['precioVenta'])/100;
                        } 
                        else{
                            $wo='NO';
                        }
                        //traer Ram hardware
                        // $this->printR($infoRam1);
                        $infoRam1 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam1']);   
                        $infoRam2 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam2']);   
                        $infoRam3 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam3']);   
                        $infoRam4 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idRam4']);   
                        $valoresRam = $infoRam1[0]['descripcion'].'-'.$infoRam2[0]['descripcion'].'-'.$infoRam3[0]['descripcion'].'-'.$infoRam4[0]['descripcion'];
                        
                        //traer los discos 
                        $infoDisco1 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idDisco1']);   
                        $infoDisco2 =   $this->subtipoParteModel->traerSubTipoParte($hardward['idDisco2']);   
                        $valoresDiscos = $infoDisco1[0]['descripcion'].'-'.$infoDisco2[0]['descripcion'];


                        echo '<tr>'; 
                        echo '<td>'.$hardward['idImportacion'].'</td>';
                        echo '<td>'.$hardward['lote'].'</td>';
                        echo '<td>'.$hardward['serial'].'</td>';
                        echo '<td>'.$infoSubtipo[0]['descripcion'].'</td>';
                        echo '<td>'.$hardward['chasis'].'</td>';
                        echo '<td>'.$hardward['modelo'].'</td>';
                        echo '<td>'.$hardward['pulgadas'].'</td>';
                        echo '<td>'.$hardward['procesador'].'</td>';
                        echo '<td>'.$hardward['generacion'].'</td>';
                        echo '<td>'.$valoresRam.'</td>';
                        echo '<td>'.$valoresDiscos.'</td>';
                        echo '<td>'.$infoMarca[0]['marca'].'</td>';
                        echo '<td>'.$numeroPedido['pedido'] .'</td>';
                        echo '<td>'.$infoPedido['fecha'].'</td>';
                        echo '<td>'.$nombreCliente .'</td>';
                        echo '<td>'.$infoEstado['descripcion'].'</td>';

                        echo '<td align="right">'.number_format($hardward['costoItem'],0,",",".").'</td>';
                        echo '<td align="right">'.number_format($hardward['costoImportacion'],0,",",".").'</td>';
                        echo '<td align="right">'.number_format($hardward['costoProducto'],0,",",".").'</td>';
                        echo '<td align="right">'.number_format($hardward['precioMinimoVenta'],0,",",".").'</td>';
                        echo '<td align="right">'.number_format($infoAsociadoItemInicio['precioVenta'],0,",",".").'</td>';

                        echo '<td align="right">'.number_format($gananBase,0,",",".").'</td>';
                        echo '<td align="right">'.number_format($ganancia,0,",",".").'</td>';
                        echo '<td>'.$wo.'</td>';
                        echo '<td align="right">'.number_format($retefuente,0,",",".").'</td>';
                        echo '<td align="right">'.number_format($reteica,0,",",".").'</td>';
                        //    $dadodebaja = 4;
                        //    if($estado == $dadodebaja)
                        //    {
                            
                            //        echo '<td><button 
                            //                    class="btn btn-secondary btn-sm " 
                            //                    onclick="habilitarHardware('.$hardward['id'].');"
                            //                    >Habilitar</button></td>';
                            //    }else{
                                
                                //        echo '<td><button 
                                //                    class="btn btn-primary btn-sm " 
                                //                    onclick="verificarDarDeBaja('.$hardward['id'].');"
                                //                    >Dar Baja</button></td>';
                                //    }
                                
                                //    echo '<td><button 
                                //                class="btn btn-primary btn-sm " 
                                //                onclick="verMovimientosHardware('.$hardward['id'].');"
                                //                >Historial</button></td>';
                                //    echo '</tr>';  
                            }
                            ?>
                  </tbody>
              </table> 

        <?php
    }

    public function reporteItemsAlistados($pedidos)
    {
        ?>
        <table class="table">
            <thead>
                <th>Pedido</th>
                <th>Fecha</th>
                <th>Tecnico</th>
                <th>Estado</th>
            </thead>
            <tbody>
                <?php
                    foreach($pedidos as $pedido)
                    {
                        $itemsPedido = $this->itemInicioPedidoModel->traerItemInicioPedido($pedido['idPedido']); 
                        foreach($itemsPedido as $item)
                        {
                            $infoTecnico = $this->usuarioModel->traerInfoId($item['idTecnico']);    
                            $infoEstado =  $this->EstadoProcesoItemModel->traerEstadoProcesoItemId($item['idEstadoProcesoItem']); 
                            echo '<tr>';
                            echo '<td>'.$pedido['idPedido'].'</td>';
                            echo '<td>'.$pedido['fecha'].'</td>';
                            echo '<td>'.$infoTecnico['nombre'].'</td>';
                            echo '<td>'.$infoEstado['descripcion'].'</td>';
                            echo '</tr>';
                        }   
                    }
                ?>
            </tbody>
        </table>
        <?php
    }


}    