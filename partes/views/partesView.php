<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/hardware/models/HardwareModel.php'); 
require_once($raiz.'/partes/models/PartesModel.php'); 
require_once($raiz.'/subtipos/models/SubtipoParteModel.php'); 
require_once($raiz.'/tipoParte/models/TipoParteModel.php'); 
// require_once($raiz.'/marcas/models/MarcaModel.php'); 
require_once($raiz.'/vista/vista.php'); 

class partesView extends vista
{
    protected $hardwareModel;
    protected $partesModel;
    protected $SubtipoParteModel;
    protected $TipoParteModel;

    public function __construct()
    {
        session_start();
        $this->hardwareModel = new HardwareModel();
        $this->partesModel = new PartesModel();
        $this->SubtipoParteModel = new SubtipoParteModel();
        $this->TipoParteModel = new TipoParteModel();
    }


    public function partesMenu($partes)
    {
        ?>
        <div style="padding:5px;" >

            <div id="botones" class="row">
                <div class="col-lg-2">
                    <button type="button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalCreacionParte"
                        class="btn btn-primary " 
                        onclick="formuCreacionParte();"
                        >
                        Crear Parte
                    </button>
                </div>
                <div class="col-lg-1">
                    <button type="button" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalParteFiltro"
                        class="btn btn-primary  " 
                        onclick="formuFiltroParte();"
                        >
                        Filtros
                    </button>
                </div>
            </div>
            <div id="resultadosPartes" class="mt-3">
               
                <?php  $this->traerPartes($partes);  ?>
                
            </div>
                
                <?php  
            $this->modalVerMovimientos();  
            $this->modalCreacionParte();  
            $this->modalCargarDescargarInventario();  
            $this->modalParteFiltro();  
        
            ?>
            
            
        </div>
        <?php
    }

    public function traerPartes($partes)
    {
    ?>
         <table class="table table-striped hover-hover">
                    <thead>
                        <!-- <th>Id.</th> -->
                        <th>Parte</th>
                        <th>Tipo</th>
                        <th>Caracteristicas</th>
                        <th>Especificaciones</th>
                        <th>Cantidad</th>
                        <?php
                            if($_SESSION['nivel']==3)
                            {
                               echo  '<th>Costo</th>';
                            }   
                        ?>
                        <th>Movimientos</th>
                        <th>Acciones</th>
                    </thead>
                <tbody>
                    <?php
                      foreach($partes as $parte)
                      {
                        $subTipoParte = $this->SubtipoParteModel->traerSubTipoParte($parte['idSubtipoParte']);
                        $tipoParte =  $this->TipoParteModel->traerTipoParteConId($subTipoParte[0]['idParte']); 
                          // $infoSucursal = $this->sucursalModel->traerSucursalId($user['idSucursal']); 
                          // $infoPerfil = $this->perfilModel->traerPerfilId($user['id_perfil']); 
                        //   $tipoParte = $this->tipoParteModel->traerTipoParteId($inventario['idTipoParte']); 
                          echo '<tr>'; 
                        //   echo '<td>'.$parte['id'].'</td>';
                          echo '<td>'.$tipoParte[0]['descripcion'].'</td>';
                          echo '<td>'.$subTipoParte[0]['descripcion'].'</td>';
                          echo '<td>'.$parte['capacidad'].'</td>';
                          echo '<td>'.$parte['costo'].'</td>';

                          echo '<td>'.$parte['cantidad'].'</td>';
                          if($_SESSION['nivel']==3)
                          {
                              echo '<td>'.$parte['costo'].'</td>';
                          }
                          echo '<td><button 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalVerMovimientos"
                                    class="btn btn-primary btn-sm " 
                                    onclick="verMovimientosParte('.$parte['id'].');"
                                    >Mov</button></td>';
                          echo '<td>';
                          echo '<button 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalCargarDescargarInventario"
                                class="btn btn-success btn-sm " 
                                onclick="formuAdicionarRestarCantidadParte('.$parte['id'].',1);"
                                >+
                                </button> ';
                          echo '<button 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalCargarDescargarInventario"
                                class="btn btn-primary btn-sm " 
                                onclick="formuAdicionarRestarCantidadParte('.$parte['id'].',2);"
                                >-
                                </button>';
                          echo '</td>';          
                          echo '</tr>';  
                        }
                        ?>
                    </tbody>
                </table> 

    <?php
    }

    public function modalVerMovimientos()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalVerMovimientos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Movimientos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyVerMovimientos">
                    
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="" >Cerrar</button>
                    <!-- <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="" >SubirArchivo++</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }
    public function modalParteFiltro()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalParteFiltro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyParteFiltro">
                    
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="" >Cerrar</button>
                    <!-- <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="" >SubirArchivo++</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }
    public function modalCargarDescargarInventario()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalCargarDescargarInventario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Inventario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyCargarDescargarInventario">
                    
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="partesMenu();" >Cerrar</button>
                    <!-- <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="" >SubirArchivo++</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }

    public function modalCreacionParte()
    {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="modalCreacionParte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Movimientos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyCreacionParte">
                    
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="partesMenu();" >Cerrar</button>
                    <!-- <button  type="button" class="btn btn-primary"  id="btnEnviar"  onclick="" >SubirArchivo++</button> -->
                </div>
                </div>
            </div>
            </div>

        <?php
    }

    public function formuCreacionParte()
    {
        $tipopartes = $this->TipoParteModel->traerTipoParteHardware('2');
        ?>
         <div class="row">
                <div class="col-md-3 mt-3">
                    <!-- computador monitor impresora -->
                    <label for="">Tipo:</label>
                    <select class ="form-control"  id="itipo" onchange="buscarSuptiposParaSelectDesdeCrearParte();">
                            <?php  $this->colocarSelect($tipopartes);  ?>
                    </select>
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Subtipo:</label>
                    <select class ="form-control"  id="isubtipo">
                    </select>
                </div>
                <div class="col-md-3 mt-3">
                    <label id="campovariable">Caracteristicas</label>
                      <input class ="form-control" type="text" id="capacidad" value ="<?php  echo $producto['capacidad'] ?>">          
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Cantidad </label>
                      <input class ="form-control" type="text" id="cantidad" value ="<?php  echo $producto['cantidad'] ?>">          
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Especificaciones </label>
                      <input class ="form-control" type="text" id="costo" value ="<?php  echo $producto['costo'] ?>">          
                </div>
            
        </div>
        <div class="row mt-3">
                <button type="button" 
                class="btn btn-primary  float-right mt-3" 
                onclick="grabarNuevaParte()"
                >
                Grabar Parte
            </button>
       </div>
        <?php
    }

    public function formuAdicionarRestarCantidadParte($request)
    {
        $infoParte = $this->partesModel->traerParte($request['idParte']);  
        $infoSubTipo = $this->SubtipoParteModel->traerSubTipoParte($infoParte[0]['idSubtipoParte']);
    //     echo '<pre>';
    // print_r($infoSubTipo); 
    // echo '</pre>';
    // die('');

        
        if($request['tipoMov']==1){$aviso = 'Entrada Inventario'; }
        if($request['tipoMov']==2){$aviso = 'Salida Inventario'; }
        ?>

        <div class="row">
            <h2><?php  echo $aviso;   ?></h2>
             
           
               <div class="col-md-3">
                   <label for="">Subtipo</label>
                   <br>
                <label><?php echo $infoSubTipo[0]['descripcion']; ?></label>        
               </div>
               <div class="col-md-2">
                   <label for="">Cantidad </label>
                     <input class ="form-control" type="text" id="cantidad" value ="<?php  echo $producto['cantidad'] ?>">          
               </div>
               <div class="col-md-5">
                   <label for="">Observaciones </label>
                   <textarea class="form-control" id="observacionesMovimiento"></textarea>
                     <!-- <input class ="form-control" type="text" id="cantidad" value ="<?php  //echo $producto['cantidad'] ?>">           -->
               </div>
           
       </div>
       <div class="row">
               <button type="button" 
               class="btn btn-primary  float-right mt-3" 
               onclick="AdicionarRstarExisatenciasParte(<?php  echo $request['idParte'] ?>,<?php echo $request['tipoMov']   ?>)"
               >
               Grabar
           </button>
      </div>
       <?php
    }


    public function  buscarParteOSerial($request)
    {
        ?>
        <div class="row">
            Buscar Serial
            <input class="form-control">
        </div>
        <div class="row">
            
        </div>

        <?php
    }


    
    public function buscarParteAgregarItemPedido($request)
    {
        $partesDisponibles = $this->partesModel->traerTodasLasPartesDisponibles();
        $tiposPartes = $this->TipoParteModel->traerTipoParteHardware(2);
        // $this->printR($partesDisponibles);
        ?>
        <div id="div_buscar_hardwareOparte">
            <div class="row">
                <input type="hidden" id="idItemAgregar"  value = "<?php  echo $request['idItem']?>"  >
                <label class="col-lg-3">Buscar Parte</label>
                <div class="col-lg-9">
                    <!-- <input id="serialABuscar" class="form-control" onkeyup="filtrarHardwarePorSerial();"> -->
                    <select class ="form-control"  id="idTipoParteFiltro"  onchange="filtrarBusquedaParteTipoParte(); ">
                        <?php $this->colocarSelectArreglo($tiposPartes)?>    
                    </select>
                </div>
            </div>
            <div class="row mt-3" id="resultadosBuscarSeriales">
                <?php  $this->traerPartesDisponibles($partesDisponibles);     ?>
            </div>
        </div>
        
        <?php
    }
    
    public function traerPartesDisponibles($partesDisponibles)
    {
        echo '<table class="table">'; 
        echo '<tr>';
        echo '<td>Subtipo</td>';  
        echo '<td>Caract.</td>';  
        echo '<td>Cantidad</td>';  
        echo '<td>Accion</td></td>';  
        echo '</tr>';    
        foreach($partesDisponibles as $parte)
        {
            $infoSubtipo =  $this->SubtipoParteModel->traerSubTipoParte($parte['idSubtipoParte']);
            // $this->printR($infoSubtipo);
            echo '<tr>';
            echo '<td>'.$infoSubtipo[0]['descripcion'].'</td>';  
            echo '<td>'.$parte['capacidad'].'</td>';  
          
            echo '<td>'.$parte['cantidad'].'</td>';  
            echo '<td>'; 
            echo ' <button 
            class="btn btn-primary  btn-sm " 
            onclick="relacionarparteAItemPedido('.$parte['id'].')"
            >
            +
            </button>';
            echo '</td>';  
            echo '</tr>';    
        }
        echo '</table>';
    } 


    public function formuFiltroParte()
    {
        $tiposPartes = $this->TipoParteModel->traerTipoParteHardware(2);
        ?>
          <div class="row"  >
            <span class="col-lg-4">Tipo_1:</span>
            <div class="col-lg-8" align="right">
            <!-- <select class ="form-control"  id="inputBuscarTipoParte" onchange="fitrarParteTipoParte();"> -->
            <select class ="form-control"  id="itipo" name ="itipo" onchange="buscarSuptiposParaSelectDesdeFiltroParte();">
                            <?php  $this->colocarSelect($tiposPartes);  ?>
                    </select>
            </div>
         </div>
          <div class="row"  >
            <span class="col-lg-4">Sub Tipo:</span>
            <div class="col-lg-8" align="right">
            <select class ="form-control"  id="isubtipo" name ="isubtipo" onchange="fitrarParteSubtipoTipoParte();">
                            <?php  $this->colocarSelect($tiposPartes);  ?>
                    </select>
            </div>
         </div>
          <div class="row"  >
            <span class="col-lg-4">Caracteristicas:</span>
            <div class="col-lg-5" align="right">
                <input  class="form-control"  id="caracteristicas"  name = "caracteristicas" >
            </div>
            <div class="col-lg-3" align="right">
                <button class="btn btn-success form-control" onclick="filtrarCaracteristicas();">BUSCAR</button>
            </div>
         </div>

        <?php
    }


}


?>