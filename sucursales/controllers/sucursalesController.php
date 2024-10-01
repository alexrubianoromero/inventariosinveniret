<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/sucursales/views/sucursalesView.php'); 
require_once($raiz.'/sucursales/models/SucursalModel.php'); 
class sucursalesController
{
    protected $view;
    protected $model; 

    public function __construct()
    {
        session_start();
        if(!isset($_SESSION['id_usuario']))
        {
            echo 'la sesion ha caducado';
            echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
            die();
        }
        $this->view = new sucursalesView();
        $this->model = new SucursalModel();
        // echo 'llego a sucursal controller '; 
        if($_REQUEST['opcion']=='sucursalesMenu')
        {
            $this->sucursalesMenu();
        }
        if($_REQUEST['opcion']=='pedirInfoSucursal')
        {
            $this->pedirInfoSucursal();
        }
        if($_REQUEST['opcion']=='crearSucursal')
        {
            $this->crearSucursal($_REQUEST);
        }
        if($_REQUEST['opcion']=='mostrarSelectSucursales')
        {
            $this->view->mostrarSelectSucursales();
        }

    }

    public function sucursalesMenu()
    {
        $sucursales = $this->model->traerSucursales();
        $this->view->sucursalesMenu($sucursales);
    }

    public function pedirInfoSucursal()
    {
        $this->view->pedirInfoSucursal();
    }

    public function crearSucursal($request)
    {
        $this->model->crearSucursal($request);
        echo 'Sucursal Creada Exitosamente';
    }


    
}



?>