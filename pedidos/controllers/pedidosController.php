<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/pedidos/views/pedidosView.php'); 
require_once($raiz.'/pedidos/models/PedidoModel.php'); 
require_once($raiz.'/pagos/models/PagoModel.php'); 
require_once($raiz.'/pedidos/models/AsignacionTecnicoPedidoModel.php'); 
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 
// die('controller'.$raiz);
// die('control123'.$raiz);

class pedidosController
{
    protected $view; 
    protected $model ; 
    protected $pagoModel ; 
    protected $itemInicioModel ; 

    public function __construct()
    {
        // die('desde controlador') ;
        session_start();
        if(!isset($_SESSION['id_usuario']))
        {
            echo 'la sesion ha caducado';
            echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
            die();
        }
        //     echo '<pre>'; 
        // print_r($_SESSION); 
        // echo '</pre>';
        // die(); 
        $this->itemInicioModel = new  ItemInicioPedidoModel();
        $this->view = new pedidosView();
        $this->model = new pedidoModel();
        $this->pagoModel = new PagoModel();

        if($_REQUEST['opcion']=='pedidosMenu')
        {
            $this->pedidosMenu();
        }
        if($_REQUEST['opcion']=='pedidosFiltrados')
        {
            $this->pedidosFiltrados($_REQUEST);
        }
        if($_REQUEST['opcion']=='pedirInfoNuevoPedido')
        {
            // echo 'pedidos controlador '; 
            $this->pedirInfoNuevoPedido($_REQUEST);
        }
        if($_REQUEST['opcion']=='continuarAItemsPedido')
        {
            $this->continuarAItemsPedido($_REQUEST);
        }
        if($_REQUEST['opcion']=='siguientePantallaPedido')
        {
            $this->siguientePantallaPedido($_REQUEST);
        }

        if($_REQUEST['opcion']=='actualizarWoPedido')
        {
            $this->actualizarWoPedido($_REQUEST);
        }

        if($_REQUEST['opcion']=='actualizarRPedido')
        {
            $this->actualizarRPedido($_REQUEST);
        }

        if($_REQUEST['opcion']=='actulizarIPedido')
        {
            $this->actulizarIPedido($_REQUEST);
        }
        if($_REQUEST['opcion']=='asignarTecnicoAPedido')
        {
            $this->asignarTecnicoAPedido($_REQUEST);
        }
        if($_REQUEST['opcion']=='formuAsignarItemPedidoATecnico')
        {
            $this->formuAsignarItemPedidoATecnico($_REQUEST);
        }
        if($_REQUEST['opcion']=='realizarAsignacionTecnicoAItem')
        {
            $this->realizarAsignacionTecnicoAItem($_REQUEST);
        }
        if($_REQUEST['opcion']=='mostrarTipoItem')
        {
            $this->mostrarTipoItem($_REQUEST);
        }
        if($_REQUEST['opcion']=='actualizarPedido')
        {
            $this->actualizarPedido($_REQUEST);
        }
        if($_REQUEST['opcion']=='pedidosPorCompletar')
        {
            $pedidosPorCompletar = $this->model->traerPedidosPendientes();

            $this->view->pedidosPorCompletar($pedidosPorCompletar);
        }
        if($_REQUEST['opcion']=='pedidosConItemsIniciopendientes')
        {
            if($_SESSION['nivel']==4){
                // die('es un tecnico ');
                $pedidosConItemsPendientes = $this->itemInicioModel->traerPedidosConItemsInicioPendientesXSucursalYTecnico();
            }else{
                $pedidosConItemsPendientes = $this->itemInicioModel->traerPedidosConItemsInicioPendientesXSucursal();
            }
        
            $pedidosPorCompletar = $this->itemInicioModel->traerInfodePedidosRelacionados($pedidosConItemsPendientes);

            $this->view->pedidosPorCompletar($pedidosPorCompletar);
        }

        if($_REQUEST['opcion']=='itemsCompletadosHistorial')
        {
            $pedidosConItemsCompletados = $this->itemInicioModel->itemsInicioCompletadosHistorialXSucursal();
            //     echo '<pre>'; 
            // print_r($pedidosConItemsCompletados); 
            // echo '</pre>';
            // die(); 
            $pedidosPorCompletar = $this->itemInicioModel->traerInfodePedidosRelacionados($pedidosConItemsCompletados);
            //aqui ya se traer con los items que estan completados
            $this->view->pedidosItemsCompletados($pedidosPorCompletar);
        }
        if($_REQUEST['opcion']=='verPagosPedido')
        {
            $pagosPedido = $this->pagoModel->traerPagosPedido($_REQUEST['idPedido']); 
            $this->view->verPagosPedido($_REQUEST['idPedido'],$pagosPedido );
        }
        if($_REQUEST['opcion']=='aplicarPagosPedido')
        {
            $pagosPedido = $this->pagoModel->aplicarPagosPedido($_REQUEST); 
            $idPedido = $this->pagoModel->traerpedidoIdPago($_REQUEST['idPago']);
            $pagosPedido = $this->pagoModel->traerPagosPedido($idPedido); 
            $this->view->verPagosPedido($idPedido,$pagosPedido );
        }

    }   

    public function pedidosMenu()
    {
        $pedidos =  $this->model->traerPedidos(); 
        $this->view->pedidosMenu($pedidos);
    }
    public function pedidosFiltrados($request)
    {
        $pedidos =  $this->model->pedidosFiltrados($request['idCLiente']); 
        $this->view->mostrarPedidos($pedidos);
    }

    public function pedirInfoNuevoPedido($request)
    {
        $this->view->pedirInfoNuevoPedido($request);
    }

    public function continuarAItemsPedido($request)
    {
        $ultimoIdPedido = $this->model->grabarEncabezadoPedido($request);
        $this->pagoModel->crearRegistrosPagosPedido($ultimoIdPedido);

        // echo '<pre>'; 
        // print_r($ultimoIdPedido); 
        // echo '</pre>';
        // die(); 
        //llamar a la siguiente pantalla de pedidos apra agregar los itemsiniciales
        $this->view->siguientePantallaPedido($ultimoIdPedido);
    }

    public function siguientePantallaPedido($request)
    {
        // $ultimoIdPedido = $this->model->grabarEncabezadoPedido($request);
        $this->view->siguientePantallaPedido($request['idPedido']);
    }

    public function actualizarWoPedido($request)
    {
        $this->model->actualizarWoPedido($request);
    }

    public function actualizarRPedido($request)
    {
        $this->model->actualizarRPedido($request);
    }
    
    public function actulizarIPedido($request)
    {
        $this->model->actulizarIPedido($request);
    }
    public function realizarAsignacionTecnicoAItem($request)
    {
        $this->model->realizarAsignacionTecnicoAItem($request);
       
        $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($request['idItemPedido']);
        echo json_encode($infoItem['idPedido']);
    }
    // public function asignarTecnicoAPedido($request)
    // {
    //     $this->asignacionModel->registrarAsignacionTecnicoAPedido($request);
    //     $this->view->siguientePantallaPedido($request['idPedido']);
    // }
    public function formuAsignarItemPedidoATecnico($request)
    {
        // $this->asignacionModel->registrarAsignacionTecnicoAPedido($request);
        $this->view->formuAsignarItemPedidoATecnico($request);
    }
    public function mostrarTipoItem($request)
    {
        if($request['tipoItem']==1)
        {  $this->view->tipoItemHardware($request['tipoItem']); }
        if($request['tipoItem']==2)
        {  $this->view->tipoItemParte($request['tipoItem']); }
        
    }
    public function actualizarPedido($request)
    {
        $this->model->actualizarPedido($request);
        echo 'Pedido Actualizado';
    }
    
}