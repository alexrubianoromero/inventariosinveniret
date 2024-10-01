<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/clientes/views/clientesView.php'); 
require_once($raiz.'/clientes/models/ClienteModel.php'); 
// require_once($raiz.'/partes/models/PartesModel.php'); 
// require_once($raiz.'/movimientos/models/MovimientoParteModel.php'); 

class clientesController
{
    protected $view;
    protected $model;
    // protected $partesModel;
    // protected $MovParteModel;

    public function __construct()
    {
        session_start();
        if(!isset($_SESSION['id_usuario']))
        {
            echo 'la sesion ha caducado';
            echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
            die();
        }
        $this->view = new clientesView();
        $this->model = new ClienteModel();
        // $this->partesModel = new PartesModel();
        // $this->MovParteModel = new MovimientoParteModel();

        if($_REQUEST['opcion']=='listarClientes')
        {
            $this->listarClientes();
        }
        if($_REQUEST['opcion']=='listarClienteFiltrado')
        {
            $this->listarClienteFiltrado($_REQUEST);
        }
        if($_REQUEST['opcion']=='listarClienteFiltradoDesdeClientes')
        {
            $this->listarClienteFiltradoDesdeClientes($_REQUEST);
        }
        if($_REQUEST['opcion']=='clientesMenu')
        {
            $this->clientesMenu();
        }

        if($_REQUEST['opcion']=='formuNuevoCliente')
        {
            // die('llego a nuevo cliente');
            $this->formuNuevoCliente();
        }
        if($_REQUEST['opcion']=='grabarCliente')
        {
            // die('llego a nuevo cliente');
            $this->grabarCliente($_REQUEST);
        }
        

    }
    public function listarClientes()
    {
        $clientes = $this->model->traerClientes();
        $this->view->mostrarCLientes($clientes);   
    }
    public function listarClienteFiltrado($request)
    {
        $clientes = $this->model->traerClienteFiltrado($request['idCliente']); 
        $this->view->mostrarCLientes($clientes);   
    }
    public function listarClienteFiltradoDesdeClientes($request)
    {
        $clientes = $this->model->traerClienteFiltrado2($request['idCliente']); 
        // echo '<pre>'; print_r($clientes); echo '</pre>';
        // die(); 
        $this->view->mostrarCLientes($clientes);   
    }
    public function clientesMenu()
    {
        $clientes = $this->model->traerClientes();
        $this->view->clientesMenu($clientes);   
    }
    public function formuNuevoCliente()
    {
        // $clientes = $this->model->traerClientes();
        $this->view->formuNuevoCliente();   
    }
    public function grabarCliente($request)
    {
        // $clientes = $this->model->traerClientes();
        $this->model->grabarCliente($request);   
        echo 'Cliente grabado!';
    }
    
}    