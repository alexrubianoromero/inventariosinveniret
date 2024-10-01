<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/partes/views/partesView.php'); 
require_once($raiz.'/partes/models/PartesModel.php'); 
require_once($raiz.'/movimientos/models/MovimientoParteModel.php'); 
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 
require_once($raiz.'/pedidos/models/AsociadoItemInicioPedidoHardwareOparteModel.php'); 

class partesController
{
    protected $view;
    protected $model;
    protected $MovParteModel;
    protected $itemInicioModel;
    protected $asociadoItemInicio; 

    public function __construct()
    {
        session_start();
        $this->view = new partesView();
        $this->model = new PartesModel();
        $this->MovParteModel = new MovimientoParteModel();
        $this->itemInicioModel = new ItemInicioPedidoModel();
        $this->asociadoItemInicio = new AsociadoItemInicioPedidoHardwareOparteModel();

        if($_REQUEST['opcion']=='partesMenu')
        {
            $this->partesMenu();
        }
        if($_REQUEST['opcion']=='formuCreacionParte')
        {
            $this->formuCreacionParte();
        }
        if($_REQUEST['opcion']=='grabarNuevaParte')
        {
            $this->grabarNuevaParte($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuAdicionarRestarCantidadParte')
        {
            $this->formuAdicionarRestarCantidadParte($_REQUEST);
        }
        if($_REQUEST['opcion']=='AdicionarRstarExisatenciasParte')
        {
            $this->AdicionarRstarExisatenciasParte($_REQUEST);
        }
        if($_REQUEST['opcion']=='buscarParteOSerial')
        {
            $this->view->buscarParteOSerial($_REQUEST);
        }
        
        if($_REQUEST['opcion']=='buscarParteAgregarItemPedido')
        {
            // die('llego aca'); 
            $this->view->buscarParteAgregarItemPedido($_REQUEST);
        }
        if($_REQUEST['opcion']=='relacionarparteAItemPedido')
        {
            $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($_REQUEST['idItemAgregar']);
            // echo '<pre>';
            // print_r($_REQUEST); 
            // echo '</pre>';
            // die('antes de movimiento ');
            // die('llego acapartes conteoller'); 
            // $this->itemInicioModel->relacionarparteAItemPedido($_REQUEST);
            $this->asociadoItemInicio->insertarAsociacionParteConItemRegistro($_REQUEST);
            $tipoMov = 2;    //osea salida de inventario 
            $cantidadParaActualizar  = 1; //voy a dejarla en 1 por defecto 
            $data = $this->model->sumarDescontarPartes($tipoMov,$_REQUEST['idParte'],$cantidadParaActualizar);
            //en partes pues se maneja con doigo de la ´parte un codigo bajo varias cantidades 
            //entonces no hay forma de relacionar el item en una parte 
            ///////////////
            //aqui hay que crear el movimiento respectivo de parte
            $infoMov = new stdClass();
            $infoMov->observaciones = 'Se reduce existencias se agrega a Id Pedido '.$infoItem['idPedido'].' id Item '.$_REQUEST['idItemAgregar'].' ';
            $infoMov->idParte = $_REQUEST['idParte'];
            $infoMov->idHardware = $_REQUEST['idItemAgregar'];
            $infoMov->tipoMov = $tipoMov;
            $infoMov->loquehabia = $data['loquehabia']; 
            $infoMov->loquequedo = $data['loquequedo']; 
            $infoMov->query = $data['query'];
            $infoMov->cantidadQueseAfecto = $cantidadParaActualizar;
            $this->MovParteModel->registrarAgregarParteAItemInicio($infoMov);
            //////////////////
            echo 'Relacionado de forma correcta. '; 
        }
        
        if($_REQUEST['opcion']=='filtrarBusquedaParteTipoParte')
        {
            $partesDisponibles = $this->model->filtrarBusquedaParteTipoParte($_REQUEST['idTipoParteFiltro']);
            $this->view->traerPartesDisponibles($partesDisponibles);

        }
        if($_REQUEST['opcion']=='formuFiltroParte')
        {
            $this->view->formuFiltroParte();
        }
        if($_REQUEST['opcion']=='fitrarParteTipoParte')
        {
            $this->fitrarParteTipoParte($_REQUEST);
        }
        if($_REQUEST['opcion']=='fitrarParteSubtipoTipoParte')
        {
            $this->fitrarParteSubtipoTipoParte($_REQUEST);
        }
        if($_REQUEST['opcion']=='filtrarCaracteristicas')
        {
            $this->fitrarCaracteristicasParte($_REQUEST);
        }

    }

    public function fitrarParteTipoParte($request)
    {
        $partes =  $this->model->traerPartesFiltroTipoParte($request['inputBuscarTipoParte']);
        $this->view->traerPartes($partes);
    }
    public function fitrarParteSubtipoTipoParte($request)
    {
        $partes =  $this->model->traerPartesFiltroSubTipoParte($request['inputBuscarSubTipoParte']);
        $this->view->traerPartes($partes);
    }
    public function fitrarCaracteristicasParte($request)
    {
        $partes =  $this->model->traerPartesCaracteristicasParte($request['tipoParte'],$request['subTipoParte'],$request['caracteris']);
        $this->view->traerPartes($partes);
    }

    public function partesMenu()
    {
        $partes =  $this->model->traerTodasLasPartes();
        $this->view->partesMenu($partes);
    }
    
    public function formuCreacionParte()
    {
        $this->view->formuCreacionParte();
    }
    
    public function grabarNuevaParte($request)
    {
        // echo '<pre>';
        // print_r($_SESSION); 
        // echo '</pre>';
        // die();
        $partes =  $this->model->grabarParteIndividual($request);
        echo 'Parte creada exitosamente';
        // $this->view->partesMenu($partes);
    }
    
    public function formuAdicionarRestarCantidadParte($request)
    {
        $this->view->formuAdicionarRestarCantidadParte($request);
    }

    public function AdicionarRstarExisatenciasParte($request)
    {
        $data = $this->model->sumarDescontarPartes($request['tipoMov'],$request['idParte'],$request['cantidad']);
        $infoMov = new stdClass();

        if($request['tipoMov']=="1"){
            $infoMov->observaciones = 'Se agrega existencias a partes  '.'Cantidad '.$request['cantidad'].' '.$request['observaciones'];
        }
        if($request['tipoMov']=="2"){
            $infoMov->observaciones = 'Se reduce existencias a partes '.'Cantidad  '.$request['cantidad'].' '.$request['observaciones'];
        }

        $infoMov->idParte = $request['idParte'];
        $infoMov->idHardware = 0;
        $infoMov->tipoMov = $request['tipoMov'];
        $infoMov->loquehabia = $data['loquehabia']; 
        $infoMov->loquequedo = $data['loquequedo']; 
        $infoMov->query = $data['query'];
        $infoMov->cantidadQueseAfecto = $request['cantidad'];
        //         echo '<pre>';
        // print_r($infoMov); 
        // echo '</pre>';
        // die('antes de movimiento ');
        $this->MovParteModel->registrarAgregarParteAHardware($infoMov);

        echo 'Exitoso!!';
    }
    
}