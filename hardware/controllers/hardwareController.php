<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/hardware/views/hardwareView.php'); 
// die('controol'.$raiz);
require_once($raiz.'/hardware/models/HardwareModel.php'); 
require_once($raiz.'/partes/models/PartesModel.php'); 
require_once($raiz.'/movimientos/models/MovimientoParteModel.php'); 
require_once($raiz.'/movimientos/models/MovimientoHardwareModel.php'); 
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 
require_once($raiz.'/pedidos/models/EstadoInicioPedidoModel.php'); 
require_once($raiz.'/hojasdevida/views/hojasdeVidaView.php'); 
require_once($raiz.'/controller/controllerClass.php'); 
require_once($raiz.'/pedidos/models/AsociadoItemInicioPedidoHardwareOparteModel.php'); 

class hardwareController extends controllerClass
{
    protected $view;
    protected $model;
    protected $partesModel;
    protected $MovParteModel;
    protected $itemInicioModel;
    protected $MovHardwareModel;
    protected $hojasdeVidaView;
    protected $estadoInicioPedidoModel;
    protected $asociadoItemInicio; 

    public function __construct()
    {
        session_start();
        if(!isset($_SESSION['id_usuario']))
        {
            echo 'la sesion ha caducado';
            echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
            die();
        }

        $this->view = new hardwareView();
        $this->model = new HardwareModel();
        $this->partesModel = new PartesModel();
        $this->MovParteModel = new MovimientoParteModel();
        $this->itemInicioModel = new ItemInicioPedidoModel();
        $this->MovHardwareModel = new MovimientoHardwareModel();
        $this->hojasdeVidaView = new hojasdeVidaView();
        $this->estadoInicioPedidoModel = new EstadoInicioPedidoModel();
        $this->asociadoItemInicio = new AsociadoItemInicioPedidoHardwareOparteModel();

        if($_REQUEST['opcion']=='hardwareMenu')
        {
            $this->hardwareMenu();
        }
        if($_REQUEST['opcion']=='formularioSubirArchivo')
        {
            $this->formularioSubirArchivo();
        }
        if($_REQUEST['opcion']=='verHardware')
        {
            $this->verHardware($_REQUEST);
        }
        if($_REQUEST['opcion']=='verHardwareHojasDeVida')
        {
            $this->verHardwareHojasDeVida($_REQUEST);
        }
        if($_REQUEST['opcion']=='quitarRam')
        {
            $this->quitarRam($_REQUEST);
        }
        if($_REQUEST['opcion']=='agregarRam')
        {
            $this->agregarRam($_REQUEST);
        }
        if($_REQUEST['opcion']=='quitarDisco')
        {
            $this->quitarDisco($_REQUEST);
        }
        if($_REQUEST['opcion']=='quitarCargador')
        {
            $this->quitarCargador($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuAgregarRam')
        {
            $this->formuAgregarRam($_REQUEST);
        }
        if($_REQUEST['opcion']=='agregarMemoriaRam')
        {
            $this->agregarMemoriaRam($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuAgregarDisco')
        {
            $this->formuAgregarDisco($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuAgregarCargador')
        {
            $this->formuAgregarCargador($_REQUEST);
        }
        if($_REQUEST['opcion']=='agregarDisco')
        {
            $this->agregarDisco($_REQUEST);
        }
        if($_REQUEST['opcion']=='agregarCargador')
        {
            $this->agregarCargador($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuNuevoHardware')
        {
            $this->formuNuevoHardware();
        }
        if($_REQUEST['opcion']=='grabarNuevoHardware')
        {
            $this->grabarNuevoHardware($_REQUEST);
        }
        
        if($_REQUEST['opcion']=='formuDividirRam')
        {
            $this->formuDividirRam($_REQUEST);
        }
        if($_REQUEST['opcion']=='crearRamAgregarHardware')
        {
            $this->crearRamAgregarHardware($_REQUEST);
        }
        
        if($_REQUEST['opcion']=='agregarTemporalDividirMemoria')
        {
            $this->agregarTemporalDividirMemoria($_REQUEST);
        }
        if($_REQUEST['opcion']=='registrarRamDividaHardware')
        {
            $this->registrarRamDividaHardware($_REQUEST);
        }
        if($_REQUEST['opcion']=='buscarInventarioHardware')
        {
            $this->view->buscarInventarioHardware($_REQUEST);
        }
        if($_REQUEST['opcion']=='actualizarCondicionHardware')
        {
            $this->model->actualizarCondicionHardware($_REQUEST);
        }
        if($_REQUEST['opcion']=='actualizarCondicion2Hardware')
        {
            $this->model->actualizarCondicion2Hardware($_REQUEST);
        }

        if($_REQUEST['opcion']=='buscarHardwareAgregarItemPedido')
        {
            $this->view->buscarHardwareAgregarItemPedido($_REQUEST);
        }
        if($_REQUEST['opcion']=='verMovimientosHardware')
        {
            $this->view->verMovimientosHardware($_REQUEST['idHardware']);
        }
        if($_REQUEST['opcion']=='fitrarHardware')
        {
            // $this->view->fitrarHardware($_REQUEST['inputBuscarHardware']);
            $this->hojasdeVidaView->traerHardwareFiltrado($_REQUEST['inputBuscarHardware']);
        }
        if($_REQUEST['opcion']=='fitrarHardwareHojasDeVida')
        {
            // $this->view->fitrarHardware($_REQUEST['inputBuscarHardware']);
            $hardware = $this->model->traerHardwareFiltroSerialHojasDeVida($_REQUEST['inputBuscarHardware']);
            $this->hojasdeVidaView->traerHardwareHojasDeVida($hardware);
        }

        if($_REQUEST['opcion']=='filtrarHardwarePorSerial')
        {
            $hardwareSerial  = $this->model->traerHardwareDisponiblesFiltradosSerial($_REQUEST);
            $this->view->traerHardwareDisponibles($hardwareSerial);

        }
        if($_REQUEST['opcion']=='relacionarHardwareAItemPedido')
        {
            //falta relacionar el item en el hardware cambiar el estado a lo que se deba en la tabla de hardware  
            //falta crear el movimiento historico 
            $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($_REQUEST['idItemAgregar']);
            // $this->printR($_SESSION);
            $tipoMov = 2 ; //sale del inventario;
            $infoMov = new stdClass();
            $infoMov->idTipoMov = $tipoMov ;  
            $infoMov->idItemInicio = $_REQUEST['idItemAgregar'] ;  
            $infoMov->observaciones = 'Se agrega Hardware  a Pedido '.$infoItem['idPedido'].' id Item '.$_REQUEST['idItemAgregar'].' ';
            $infoMov->idHardware = $_REQUEST['idHardware'];  
            $idMov = $this->MovHardwareModel->registrarMovimientohardware($infoMov); 
            
            //aqui hay que vambiar el modelo para que realice la asociacion a la tabla asociacion respectiva
            //se comenta el proceso anterior
            // $this->itemInicioModel->relacionarHardwareAItemPedido($_REQUEST);
            //la info que debe venir es el idItem y el idHardware  
            $idAsociadoItem = $this->asociadoItemInicio->insertarAsociacionHardwareConItemRegistro($_REQUEST);

            //actualizar la tabla de hardware con estado si es alquilado o vendido
            //traer el campo estado de la tabla itemInicioPedido osea vendido o rentado 
            //tener en cuenta que si es cambio de bodega pues solo se cambia el idSucursal y no se actualiza estado de hardware
            //bueno deberia quedar en disponible 
            //tambien es importante que quede registrado en el movimiento  de hardware la sucursal que tenia y la final
            $cambioBodega = 3; //este estado 3 significa que es cambio de bodega 
            if($infoItem['estado']==$cambioBodega)
            {
                //queda disponible y adicional se actualiza el idSucursal 
                //realizar el cambio de bodega 
                $infoCambio = $this->model->realizarCambioDeBodega($_REQUEST['idHardware'],$infoItem['idNuevaSucursal']);
                $this->MovHardwareModel->actualizarMovimientoHardware($idMov,$infoCambio); 
                // $this->printR($infoCambio); 

            }else{
                //cambiar el estado 
                $this->model->actualizarEstadoHardware($_REQUEST['idHardware'],$infoItem['estado']); 
                $this->model->actualizarIdAsociacionItemEnHardware($_REQUEST['idHardware'],$idAsociadoItem); 
            }
            
            echo 'Relacionado de forma correcta '; 
            // $this->view->traerHardwareDisponibles($hardwareSerial);
        }

        if($_REQUEST['opcion']=='formuDevolucionHardware')
        {
            $this->view->formuDevolucionHardware($_REQUEST);
        }
        if($_REQUEST['opcion']=='realizarDevolucion')
        {
            $this->realizarDevolucion($_REQUEST);
        }
        if($_REQUEST['opcion']=='verificarDarDeBaja')
        {
            $this->verificarDarDeBaja($_REQUEST);
            
        }
        if($_REQUEST['opcion']=='habilitarHardware')
        {
            $this->habilitarHardware($_REQUEST);
            
        }
        if($_REQUEST['opcion']=='formuFiltrosHardware')
        {
            $this->view->formuFiltrosHardware($_REQUEST);
            
        }
        if($_REQUEST['opcion']=='fitrarHardwareSerialInventario')
        {
            $this->fitrarHardwareSerialInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwarePulgadasInventario')
        {
            $this->fitrarHardwarePulgadasInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareProcesadorInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareProcesadorInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareGeneracionInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareGeneracionInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareImportacionInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareImportacionInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareProveedorInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareProveedorInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareLoteInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareLoteInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareFacturaInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareFacturaInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareTipoInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareTipoInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarHardwareSubTipoInventario')
        {
            // $this->printR($_REQUEST);
            $this->fitrarHardwareSubTipoInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='actualizarCostos')
        {
            // $this->printR($_REQUEST);
            $this->model->actualizarCostos($_REQUEST);
        }
        if($_REQUEST['opcion']=='actualizarOnchengeUbicacion')
        {
            // $this->printR($_REQUEST);
            $this->model->actualizarOnchengeUbicacion($_REQUEST);
        }
 
        if($_REQUEST['opcion']=='actualizarOnchangeProcesador')
        {
            // $this->printR($_REQUEST);
            $this->model->actualizarOnchangeProcesador($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuRealizarDevolucionABodega')
        {
            // $this->printR($_REQUEST);
            $this->view->formuRealizarDevolucionABodega($_REQUEST['idHardware']);
        }

        if($_REQUEST['opcion']=='realizarDevolucionABodega')
        {
            $this->realizarDevolucionABodega($_REQUEST);
        }
        if($_REQUEST['opcion']=='crearMovimientoManual')
        {
            $this->crearMovimientoManual($_REQUEST);
        }
 
        if($_REQUEST['opcion']=='filtrarUbicacionInventario')
        {
            // $this->printR($_REQUEST);
            $this->filtrarUbicacionInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='filtrarSkuInventario')
        {
            // $this->printR($_REQUEST);
            $this->filtrarSkuInventario($_REQUEST);
        }
        if($_REQUEST['opcion']=='filtrarChasisInventario')
        {
            $this->filtrarChasisInventario($_REQUEST);
        }
 
        if($_REQUEST['opcion']=='filtrarPulgadasInventario')
        {
            $this->filtrarPulgadasInventario($_REQUEST);
        }
        
        if($_REQUEST['opcion']=='filtrarBuscarProducto')
        {
            $this->filtrarBuscarProducto($_REQUEST);
        }

        if($_REQUEST['opcion']=='descargarPdfMovimiento')
        {
            $this->descargarPdfMovimiento($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuCrearMovimientoManual')
        {
            $this->view->formuCrearMovimientoManual($_REQUEST['idHardware']);
        }
 


    }

    public function descargarPdfMovimiento($request)
    {
        // die('llego a descaraga'); 
        $infoMovimiento = $this->MovHardwareModel->traerMovimientoId($request['idMovimiento']);
        header("Content-type: application/pdf");
        readfile('../archivos/hoja.pdf');
    }

    public function subirArchivoDevolucion()
    {
        //  $this->printR($_FILES);
         $nombre_archivo = $_FILES['archivo']['name'];
            if (move_uploaded_file($_FILES['archivo']['tmp_name'],  'archivos/'.$nombre_archivo)){
                echo "El archivo ha sido cargado correctamente.";
            }else{
                echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
            }
            // die('Archivo subido');

    }

    
    public function realizarDevolucionABodega($request)
    {
        $infoHardware =  $this->model->traerHardwareId($request['idHardware']); 
        ////codigo anterior
        //revisar este codigo 
        //si es renta aumentar el sku
        $valorSkuActual = $infoHardware['sku'];
        $nuevoSku = $valorSkuActual + 1 ; 
        
        if($infoHardware['idEstadoInventario']==2)
        {
            $this->model->aumentarSkuIdHardware($request['idHardware'],$nuevoSku);
        }
        $regresaAInventario = 0;
        $this->model->actualizarEstadoHardware($request['idHardware'],$regresaAInventario);
        $idItem = 0; // esto porque lo que se busca es desligar el serial del item al que estaba asociado y esto se consigue dejando el valor de 0 eb ese campo
        $this->model->actualizarIdAsociacionItemEnHardware($request['idHardware'],$idItem);
        //generar movimiento de devolucion 
        //falta relacionar el item en el hardware cambiar el estado a lo que se deba en la tabla de hardware  
        //falta crear el movimiento historico 
        // $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($_REQUEST['idItemAgregar']);
        
        //  $infoMovimiento =  $this->MovHardwareModel->traerMovimientoId($request['idMovimiento']);
        //  $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($infoMovimiento['idItemInicio'] );
        
        $tipoMov = 5 ; //devuelto;
        $infoMov = new stdClass();
        
        $infoMov->idTipoMov = $tipoMov ;  
        $infoMov->idItemInicio = $request['idItemDev'] ;  
        $infoMov->observaciones = 'Se realiza reingreso Hardware  de Pedido '.$request['idPedidoDev'].' id Item '.$request['idItemDev'].' ';
        $infoMov->observaciones .= $request['obseDevolucion'];
        $infoMov->idHardware = $request['idHardware'];  
        $idMov = $this->MovHardwareModel->registrarMovimientohardware($infoMov); 
        //crear otro movimiento para que le salga bodega de acuedo a lo solicitado por Sebastian
        // //el quiere ver un movimiento que diga bodega 
        // $infoMov->idItemInicio = 0;
        // $this->MovHardwareModel->registrarMovimientohardware($infoMov); 
        // $infoMov->observaciones= 'Movimiento para indicar estado Bodega';
        //subir el pdf
        $this->subirArchivoDevolucion();
        //actualizar la ruta del archivo pdf
        $nombre_archivo = $_FILES['archivo']['name'];
        $this->MovHardwareModel->actualizarRutaArchivoPdfIdMov($idMov,$nombre_archivo);
        
        
        echo 'Reingreso Realizado';
    } 

    public function crearMovimientoManual($request)
    {
        // die('llego a creacion manual'); 
        $infoHardware =  $this->model->traerHardwareId($request['idHardware']); 
        $tipoMov = 6 ; // 6 es la forma de indicar que es creado manualmente;
        $infoMov = new stdClass();
        $infoMov->idTipoMov = $tipoMov ;  
        //como es registro manual osea de idTipoMov = 6  se debe verificar si el serial esta asociado a algun item 
        //si el serial no esta asociado a ningun item
        //si el serial no esta asociado a un item pues debe traer el estado que tiene el serial no el estado del item
        //claro que esto deberia ser mas en la parte visual 
       if($infoHardware['idEstadoInventario']==0) //osea si esta en bodega no esta asociado a ningun item 
       {
           $infoMov->idItemInicio = 0 ;  
       }else 
       {
           $infoMov->idItemInicio = $request['idItemDev'] ;  
       }

        // $infoMov->idItemInicio = '' ;  
        // $infoMov->observaciones = 'Creacion Manual de Historial '.$request['idPedidoDev'].' id Item '.$request['idItemDev'].' ';
        $infoMov->observaciones = 'Creacion Manual de Historial';
        $infoMov->observaciones .= $request['obseDevolucion'];
        $infoMov->idHardware = $request['idHardware'];  

        $idMov = $this->MovHardwareModel->registrarMovimientohardware($infoMov); 
        //subir el pdf
        $this->subirArchivoDevolucion();
        //actualizar la ruta del archivo pdf
        $nombre_archivo = $_FILES['archivo']['name'];
        $this->MovHardwareModel->actualizarRutaArchivoPdfIdMov($idMov,$nombre_archivo);
        echo 'Creacion  Realizada';
    } 




    public function habilitarHardware ($request) 
    {
        // $this->printR($_SESSION); 
        // echo 'proceso dar habilitar';
            //se deba cambiar el estado 
            $disponible = 0; 
            $this->model->actualizarEstadoHardware($_REQUEST['idHardware'],$disponible); 
            //dejar registro del movimiento de dar de baja y ya 

            // $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($_REQUEST['idItemAgregar']);
            // $this->printR($infoItem);
            $tipoMov = 0 ; //habilitar;
            $infoMov = new stdClass();
            $infoMov->idTipoMov = $tipoMov ;  
            $infoMov->idItemInicio = 0;  
            $infoMov->observaciones = 'Se habilita Este hardware ';
            $infoMov->idHardware = $_REQUEST['idHardware'];  
            $this->MovHardwareModel->registrarMovimientohardware($infoMov); 
            echo 'Se ha realizado el proceso de habilitar el hardware'; 

    }
    public function verificarDarDeBaja ($request) 
    {
        // $this->printR($_SESSION); 
        // echo 'proceso dar de baja ';
            //se deba cambiar el estado 
            $darDeBaja = 4; 
            $this->model->actualizarEstadoHardware($_REQUEST['idHardware'],$darDeBaja); 
            //dejar registro del movimiento de dar de baja y ya 

            // $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($_REQUEST['idItemAgregar']);
            // $this->printR($infoItem);
            $tipoMov = 4 ; //dado de baja;
            $infoMov = new stdClass();
            $infoMov->idTipoMov = $tipoMov ;  
            $infoMov->idItemInicio = 0;  
            $infoMov->observaciones = 'Se da de baja Este hardware ';
            $infoMov->idHardware = $_REQUEST['idHardware'];  
            $this->MovHardwareModel->registrarMovimientohardware($infoMov); 
            echo 'Se ha realizado el proceso de dar de baja '; 

    }

    public function realizarDevolucion($request)
    {

          $regresaAInventario = 0;
          $this->model->actualizarEstadoHardware($request['idHardware'],$regresaAInventario);
          //generar movimiento de devolucion 
           //falta relacionar el item en el hardware cambiar el estado a lo que se deba en la tabla de hardware  
            //falta crear el movimiento historico 
            // $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($_REQUEST['idItemAgregar']);

           $infoMovimiento =  $this->MovHardwareModel->traerMovimientoId($request['idMovimiento']);
           $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($infoMovimiento['idItemInicio'] );

            $tipoMov = 1 ; //entra al inventario;
            $infoMov = new stdClass();
            $infoMov->idTipoMov = $tipoMov ;  
            $infoMov->idItemInicio = $infoMovimiento['idItemInicio'] ;  
            $infoMov->observaciones = 'Se realiza devolucion Hardware  de Pedido '.$infoItem['idPedido'].' id Item '.$infoMovimiento['idItemInicio'] .' ';
            $infoMov->idHardware = $request['idHardware'];  
            $this->MovHardwareModel->registrarMovimientohardware($infoMov); 

    }

    public function hardwareMenu()
    {
        $hardware =  $this->model->traerHardware();
        $this->view->hardwareMenu($hardware);
    }

    public function fitrarHardwareSerialInventario($request)
    {
        $hardware =  $this->model->traerHardwareFiltro($request['inputBuscarHardware']);
        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function fitrarHardwarePulgadasInventario($request)
    {
        $hardware =  $this->model->traerHardwarePulgadasFiltro($request['inputBuscarPulgadas']);
        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function fitrarHardwareProcesadorInventario($request)
    {
        $hardware =  $this->model->traerHardwareProcesadorFiltro($request['inputBuscarProcesador']);
        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function filtrarUbicacionInventario($request)
    {
        $hardware =  $this->model->filtrarUbicacionInventario($request['inputBuscarUbicacion']);

        $this->view->traerHardwareMostrarmenu($hardware) ;
    }

    public function filtrarSkuInventario($request)
    {
        $hardware =  $this->model->filtrarSkuInventario($request['inputBuscarSku']);
        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function filtrarChasisInventario($request)
    {
        $hardware =  $this->model->filtrarChasisInventario($request['inputBuscarChasis']);
        $this->view->traerHardwareMostrarmenu($hardware) ;
    }

    public function filtrarPulgadasInventario($request)
    {
        // die('paso 2 '); 
        $hardware =  $this->model->filtrarPulgadasInventario($request['inputBuscarPulgadas']);
        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function filtrarBuscarProducto($request)
    {
        // die('paso 2 '); 
        $hardware =  $this->model->filtrarBuscarProducto($request['inputBuscarProducto']);
        $this->view->traerHardwareMostrarmenu($hardware) ;
    }

    public function fitrarHardwareImportacionInventario($request)
    {
        $hardware =  $this->model->traerHardwareImportacionFiltro($request['inputBuscarImportacion']);

        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function fitrarHardwareProveedorInventario($request)
    {
        $hardware =  $this->model->traerHardwareProveedorFiltro($request['inputBuscarProveedor']);

        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function fitrarHardwareLoteInventario($request)
    {
        $hardware =  $this->model->traerHardwareLoteFiltro($request['inputBuscarLote']);

        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function fitrarHardwareFacturaInventario($request)
    {
        $hardware =  $this->model->traerHardwareFacturaFiltro($request['inputBuscarFactura']);

        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function fitrarHardwareTipoInventario($request)
    {
        $hardware =  $this->model->traerHardwareTipoFiltro($request['inputBuscarTipo']);

        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
    public function fitrarHardwareSubTipoInventario($request)
    {
        $hardware =  $this->model->traerHardwareSubTipoFiltro($request['inputBuscarSubTipo']);

        $this->view->traerHardwareMostrarmenu($hardware) ;
    }
   

    public function formularioSubirArchivo()
    {
        $this->view->formularioSubirArchivo(); 
    }
    public function verHardware($request)
    {
        $hardware = $this->model->verHardware($request['id']);
        // echo '<pre>';
        // print_r($hardware); 
        // echo '</pre>';
        // die();
        $this->view->verHardware($hardware);

    }
    public function verHardwareHojasDeVida($request)
    {
        $hardware = $this->model->verHardware($request['id']);
        // echo '<pre>';
        // print_r($hardware); 
        // echo '</pre>';
        // die();
        $this->view->verHardwareHojasDeVida($hardware);

    }
    public function llamarRegistroMovimientoQuitarHardware ($idHardware,$idParte,$tipoMov)
    {
     
        $infoMov = new stdClass();
        $infoMov->idParte = $idParte;
        $infoMov->idHardware = $idHardware;
        $infoMov->tipoMov = $tipoMov;
        $this->MovParteModel->grabarMovDesligardeHardware($infoMov);
    }
    
    public function llamarRegistroMovimientoPonerHardware ($idHardware,$idParte,$tipoMov,$observaciones)
    {
     
        $infoMov = new stdClass();
        $infoMov->idParte = $idParte;
        $infoMov->idHardware = $idHardware;
        $infoMov->tipoMov = $tipoMov;
        $infoMov->observaciones = $observaciones;

        $this->MovParteModel->registrarAgregarParteAHardware($infoMov);
    }
    

    public function quitarRam($request)
    {
        //        echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('quitar ram');
        // echo 'llego a controller y quitar ram '; 
        //desligar la parte del hardware
        // verifique si el id de la subparte existe en partes 
        //consulte si ese id existe en partes 
        $existeIdSubtipoEnPartes = $this->partesModel->verificarIdSubparteEnParte($request['idRam']); 

        //  die ('existe id en parte '.$existeIdSubtipoEnPartes);

        if($existeIdSubtipoEnPartes==0)
        {
            //crear el registro en partes 
            $infoGrabar['isubtipo'] = $request['idRam'];
            $infoGrabar['capacidad'] = 0;
            $infoGrabar['cantidad'] = 1;
            $infoGrabar['costo'] = 0;

            $this->partesModel->grabarParteIndividual($infoGrabar);
        }
        else
        {
            // die('entro aca porque ya existe');
            $tipoMov = 1; //es una entrada al inventario porque vuelve una parte  
            $cantidadParaActualizar = 1; 
            $data = $this->partesModel->sumarDescontarPartes($tipoMov,$request['idRam'],$cantidadParaActualizar);
            $infoMov = new stdClass();
            $infoMov->idParte = $request['idRam'];
            $infoMov->idHardware = $request['idHardware'];
            $infoMov->tipoMov = $tipoMov;
            $infoMov->observaciones = 'Se quita memoria ram de Hardware id No '.$request['idHardware'];
            $infoMov->loquehabia = $data['loquehabia']; 
            $infoMov->loquequedo = $data['loquequedo']; 
            $infoMov->query = $data['query'];
            $infoMov->cantidadQueseAfecto = $data['cantidadQueseAfecto'];
        }
        
        
        $this->model->desligarRamDeEquipo($request);
        $this->MovParteModel->grabarMovDesligardeHardware($infoMov);

        echo 'La Ram fue desasociada del hardware';
    }

    public function quitarDisco($request)
    {
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('');

        $existeIdSubtipoEnPartes = $this->partesModel->verificarIdSubparteEnParte($request['idDisco']); 
        //  die ('existe id en parte '.$existeIdSubtipoEnPartes);
         if($existeIdSubtipoEnPartes==0)
         {
             //crear el registro en partes 
                    $infoGrabar['isubtipo'] = $request['idDisco'];
                    $infoGrabar['capacidad'] = 0;
                    $infoGrabar['cantidad'] = 1;
                    $infoGrabar['costo'] = 0;
                    $this->partesModel->grabarParteIndividual($infoGrabar);
         }
         else{
             
                     $tipoMov = 1; //es una entrada al inventario porque vuelve una parte  
                     $cantidadParaActualizar = 1; 
                     $data = $this->partesModel->sumarDescontarPartes($tipoMov,$request['idDisco'],$cantidadParaActualizar);
                     $infoMov = new stdClass();
                     $infoMov->idParte = $request['idDisco'];
                     $infoMov->idHardware = $request['idHardware'];
                     $infoMov->tipoMov = $tipoMov;
                     $infoMov->observaciones = 'Se quita disco de Hardware id No '.$request['idHardware'];
                     $infoMov->loquehabia = $data['loquehabia']; 
                     $infoMov->loquequedo = $data['loquequedo']; 
                     $infoMov->query = $data['query'];
                     $infoMov->cantidadQueseAfecto = $data['cantidadQueseAfecto'];
                     
            }
                    
                    
        $this->model->desligarDiscoDeEquipo($request);
        $this->MovParteModel->grabarMovDesligardeHardware($infoMov);

        echo 'Se ha desligado este disco '; 


        // echo 'llego a controller y quitar Disco '; 
        //desligar la parte del hardware
        // $this->model->desligarDiscoDeEquipo($request);
        // $this->partesModel->desligarParteDeHardware($request['idDisco']);
        // $this->llamarRegistroMovimientoQuitarHardware($request['idHardware'],$request['idDisco'],'1');
       

        
        //ahora deberia crear el movimiento 
    }
    
    public function quitarCargador($request)
    {
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('');
        $tipoMov = 1; //es una entrada al inventario porque vuelve una parte  
        $cantidadParaActualizar = 1; 
        $data = $this->partesModel->sumarDescontarPartes($tipoMov,$request['idCargador'],$cantidadParaActualizar);
        $this->model->desligarCargadorDeEquipo($request);
        $infoMov = new stdClass();
        $infoMov->idParte = $request['idCargador'];
        $infoMov->idHardware = $request['idHardware'];
        $infoMov->tipoMov = $tipoMov;
        $infoMov->observaciones = 'Se quita disco de Hardware id No '.$request['idHardware'];
        $infoMov->loquehabia = $data['loquehabia']; 
        $infoMov->loquequedo = $data['loquequedo']; 
        $infoMov->query = $data['query'];
        $infoMov->cantidadQueseAfecto = $data['cantidadQueseAfecto'];

        $this->MovParteModel->grabarMovDesligardeHardware($infoMov);

        echo 'Se ha desligado esta parte '; 


        // echo 'llego a controller y quitar Disco '; 
        //desligar la parte del hardware
        // $this->model->desligarDiscoDeEquipo($request);
        // $this->partesModel->desligarParteDeHardware($request['idDisco']);
        // $this->llamarRegistroMovimientoQuitarHardware($request['idHardware'],$request['idDisco'],'1');
       

        
        //ahora deberia crear el movimiento 
    }
    
    public function formuAgregarRam($request)
    {
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('valoresRam');
        // $this->view->formuAgregarRam($request['idHardware'],$request['ram']);
        $this->view->formuAgregarRam($request);

        // $this->llamarRegistroMovimientoQuitarHardware($request['idHardware'],$request['idRam'],'1');
    }

    
    //recibe el requesr con 3 parametros
    //idHArdware
    //idRam
    //numeroRam
    public function agregarMemoriaRam($request)
    {
        //ya no hay que hacer asociaciones solamente se suma o se resta  a la cantidad que tenga la parte 
        // $this->model->asociarParteRamEnTablaHardware($request);
        // $this->partesModel->asociarRamHardwareEnTablaPartes($request);
        //hay que hacer la suma o la resta del inventario 
        //deberia ser una funcion de Partes
        //tipoMov 1 Entrada 2 salida 
        //registrar el movimiento 

        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('funcion agregar memoria ram ');

        $tipoMov = 2; //es salida porque se saca un parte para agregarla a un hardware
        $cantidadParaActualizar = 1; 
        $data = $this->partesModel->sumarDescontarPartes($tipoMov,$request['idRam'],$cantidadParaActualizar);

        $infoMov = new stdClass();
        $infoMov->idParte = $request['idRam'];
        $infoMov->idHardware = $request['idHardware'];
        $infoMov->tipoMov = $tipoMov;
        $infoMov->observaciones = 'Se agrega parte a Hardware id No '.$request['idHardware'];
        $infoMov->loquehabia = $data['loquehabia']; 
        $infoMov->loquequedo = $data['loquequedo']; 
        $infoMov->query = $data['query'];
        $infoMov->cantidadQueseAfecto = $data['cantidadQueseAfecto'];
        $this->MovParteModel->registrarAgregarParteAHardware($infoMov);
        $ramODisco = 'r'; //porque es una ram 
        // $this->partesModel->asociarParteAHardware($request['idHardware'],$request['idRam'],$request['numeroRam'],$ramODisco);
        $this->partesModel->asociarParteAHardware($request['idHardware'],$request['idRam'],$request['numeroRam'],$ramODisco,$request['idSubtipoParte']);

        echo 'Memoria Agregado!!';
    }

    public function formuAgregarDisco($request)
    {
        $this->view->formuAgregarDisco($request);
    }
    public function formuAgregarCargador($request)
    {
        $this->view->formuAgregarCargador($request);
    }

    public function agregarDisco($request)
    {
        
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('valores que llegan al controlador');
        $tipoMov = 2; //es salida porque se saca un parte para agregarla a un hardware
        $cantidadParaActualizar = 1; 
        $data = $this->partesModel->sumarDescontarPartes($tipoMov,$request['idDisco'],$cantidadParaActualizar);

        $infoMov = new stdClass();
        $infoMov->idParte = $request['idDisco'];
        $infoMov->idHardware = $request['idHardware'];
        $infoMov->tipoMov = $tipoMov;
        $infoMov->observaciones = 'Se agrega parte a Hardware id No '.$request['idHardware'];
        $infoMov->loquehabia = $data['loquehabia']; 
        $infoMov->loquequedo = $data['loquequedo']; 
        $infoMov->query = $data['query'];
        $infoMov->cantidadQueseAfecto = $data['cantidadQueseAfecto'];
        //         echo '<pre>';
        // print_r($infoMov); 
        // echo '</pre>';
        // die('antes de movimiento ');
        $this->MovParteModel->registrarAgregarParteAHardware($infoMov);
        $ramODisco = 'd'; //porque es una ram 
        $this->partesModel->asociarParteAHardware($request['idHardware'],$request['idDisco'],$request['numeroDisco'],$ramODisco,$request['idDisco']);

        echo 'Disco Agregado!!';
        // $this->model->asociarParteEnTablaHardware($request);
        // $this->partesModel->asociarHardwareEnTablaPartes($request);
        // $this->llamarRegistroMovimientoPonerHardware($request['idHardware'],$request['idDisco'],'2',$request['opcion']);
        // echo 'Disco Agregado!!';
    }

    public function agregarCargador($request)
    {
        
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('valores que llegan al controlador');
        $tipoMov = 2; //es salida porque se saca un parte para agregarla a un hardware
        $cantidadParaActualizar = 1; 
        $data = $this->partesModel->sumarDescontarPartes($tipoMov,$request['idCargador'],$cantidadParaActualizar);

        $infoMov = new stdClass();
        $infoMov->idParte = $request['idCargador'];
        $infoMov->idHardware = $request['idHardware'];
        $infoMov->tipoMov = $tipoMov;
        $infoMov->observaciones = 'Se agrega parte a Hardware id No '.$request['idHardware'];
        $infoMov->loquehabia = $data['loquehabia']; 
        $infoMov->loquequedo = $data['loquequedo']; 
        $infoMov->query = $data['query'];
        $infoMov->cantidadQueseAfecto = $data['cantidadQueseAfecto'];
        //         echo '<pre>';
        // print_r($infoMov); 
        // echo '</pre>';
        // die('antes de movimiento ');
        $this->MovParteModel->registrarAgregarParteAHardware($infoMov);
        $ramODisco = 'c'; //porque es un cargador
        $this->partesModel->asociarParteAHardware($request['idHardware'],$request['idCargador'],'idCargador',$ramODisco);

        echo ' Agregado!!';
        // $this->model->asociarParteEnTablaHardware($request);
        // $this->partesModel->asociarHardwareEnTablaPartes($request);
        // $this->llamarRegistroMovimientoPonerHardware($request['idHardware'],$request['idDisco'],'2',$request['opcion']);
        // echo 'Disco Agregado!!';
    }
    
    public function formuNuevoHardware()
    {
        $this->view->formuNuevoHardware();
    }
    public function grabarNuevoHardware($request)
    {
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die();
        $this->model->grabarNuevoHardware($request);
        echo 'Grabado Satisfactoriamente'; 
    }

    public function formuDividirRam($request)
    {
        $this->view->formuDividirRam($request['idHardware']);
    }
    
    
    public function agregarTemporalDividirMemoria($request)
    {
        $this->model->agregarTemporalDividirMemoria($request);
        $temporales = $this->model->traerRegistrosTemporales($request['idHardware']);
        //  echo '<pre>';
        // print_r($temporales); 
        // echo '</pre>';
        // die();
        $this->view->mostrarTemporales($temporales);  
    }
    public function registrarRamDividaHardware($request)
    {
        $this->model->asignarDivisionHadware($request['idHardware']);
        //limpiar los temporales 
        $this->model->limpiarTablaDivisionRam($request['idHardware']);
        //inactgivar el boton de dividir
        $this->model->inactivarBotonDividir($request['idHardware']);
        echo 'Division realizada';
    }
    
}