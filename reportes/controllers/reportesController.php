<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/reportes/views/reportesView.php'); 
require_once($raiz.'/pedidos/models/PedidoModel.php'); 
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 
require_once($raiz.'/hardware/models/HardwareModel.php'); 
require_once($raiz.'/vista/vista.php'); 
// require_once($raiz.'/pagos/models/PagoModel.php'); 
// require_once($raiz.'/pedidos/models/AsignacionTecnicoPedidoModel.php'); 
// die('controller'.$raiz);
// die('control123'.$raiz);

class reportesController extends vista
{
    protected $view; 
    protected $pedidoModel;
    protected $itemInicioModel;
    protected $HardwareModel;
    // protected $model ; 
    // protected $pagoModel ; 

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
        $this->view = new reportesView();
        $this->pedidoModel = new PedidoModel();
        $this->itemInicioModel = new ItemInicioPedidoModel();
        $this->HardwareModel = new HardwareModel();

        if($_REQUEST['opcion']=='reportesMenu')
        {
            $this->view->reportesMenu();
        }
        if($_REQUEST['opcion']=='formuReporteVentas')
        {
            $this->view->formuReporteVentas();
        }
        if($_REQUEST['opcion']=='generarReporteVentas')
        {
            // echo '<pre>'; print_r($_REQUEST);  echo '</pre>';
            // die('llego aca '); 
            $this->generarReporteVentas($_REQUEST);
        }
        if($_REQUEST['opcion']=='reporteEstadoEquipo')
        { 
            $this->reporteEstadoEquipo($_REQUEST);
        }
        if($_REQUEST['opcion']=='traerEquiposFiltradoEstado')
        {
            // $this->printR($_REQUEST);
            $this->traerEquiposFiltradoEstado($_REQUEST);
        }
        if($_REQUEST['opcion']=='verReporteFinanciero')
        {
            // echo '<pre>'; print_r($_REQUEST);  echo '</pre>';
            // die('llego aca '); 
            $this->verReporteFinanciero($_REQUEST);
        }
        if($_REQUEST['opcion']=='reporteItemsAlistados')
        {
            // echo '<pre>'; print_r($_REQUEST);  echo '</pre>';
            // die('llego aca '); 
            $this->reporteItemsAlistados($_REQUEST);
        }
    
    }


    public function generarReporteVentas($request)
    {
        //  $traerPedidosFechas = $this->pedidoModel->traerPedidosFechas($request);     
         $itemsVentasPedidosFechas = $this->pedidoModel->traerItemsPedidoFechas($request);  
        //  $this->printR($itemsVentasPedidosFechas);

        //  echo '<pre>'; print_r($_REQUEST);  echo '</pre>';  
        //  $traerVentasdePedidos =  $this->itemInicioModel->traerItemsVentas(); 
        $this->view->mostrarReporteVentas($itemsVentasPedidosFechas);
    }

    // public function reporteEstadoEquipo($request)
    // {
    //     $hardwards = $this->HardwareModel->traerHardwareTodosLosEstados(); 
    //     //    echo '<pre>'; print_r($hardwards);  echo '</pre>';
    //     //     die('llego aca '); 
    //     $this->view->reporteEstadoEquipo($hardwards);
    // }
    public function reporteEstadoEquipo($request)
    {
        $hardwards = $this->HardwareModel->traerHardwareTodosLosEstados(); 
        //    echo '<pre>'; print_r($hardwards);  echo '</pre>';
        //     die('llego aca '); 
        $this->view->verEquiposFinancieroEstadoEquipo($hardwards,$request['idEnviarExcel']) ;
    }

    public function traerEquiposFiltradoEstado($request)
    {
        $hardwarsFiltrados =  $this->HardwareModel->traerEquiposFiltradoEstado($request['idEstadoFiltrar']);

        $this->view->verEquipos($hardwarsFiltrados) ;
    }
    public function verReporteFinanciero($request)
    {
        $hardwards = $this->HardwareModel->traerHardwareSinDadosDeBaja(); 
            // echo '<pre>'; print_r($hardwards);  echo '</pre>';
            // die('llego aca '); 
        $this->view->verReporteFinanciero($hardwards,$request['idEnviarExcel']) ;
    }
    public function reporteItemsAlistados($request)
    {
        $pedidos = $this->pedidoModel->traerPedidos(); 
            // echo '<pre>'; print_r($hardwards);  echo '</pre>';
            // die('llego aca '); 
        $this->view->reporteItemsAlistados($pedidos) ;
    }


    

}   