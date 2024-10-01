<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/inventarios/views/inventariosView.php'); 
// die('controller '.$raiz);
require_once($raiz.'/inventarios/models/InventariosModel.php'); 
// die($raiz);

class inventariosController
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
        $this->view = new inventariosView();
        $this->model = new InventariosModel();

        if($_REQUEST['opcion']=='inventariosMenu')
        {
            $this->inventariosMenu();
        }
        if($_REQUEST['opcion']=='computadoresMenu')
        {
            $this->computadoresMenu();
        }
        if($_REQUEST['opcion']=='pedirInfoProducto')
        {
            $this->pedirInfoProducto();
        }
        if($_REQUEST['opcion']=='crearProducto')
        {
            $this->crearProducto($_REQUEST);
        }
        if($_REQUEST['opcion']=='verProducto')
        {
            $this->verProducto($_REQUEST);
        }
        if($_REQUEST['opcion']=='partesMenu')
        {
            $this->partesMenu($_REQUEST);
        }


    }    

    public function inventariosMenu()
    {
        $inventarios = $this->model->traerInventarios();
        $this->view->inventariosMenu($inventarios);
    }
    public function computadoresMenu()
    {
        $computadoresMonitores  = $this->model->traerComputadoresMonitores();
        $this->view->computadoresMenu($computadoresMonitores);
    }
    public function partesMenu()
    {
        // die('esta en partes de controller ');
        $partes  = $this->model->traerPartesEnGeneral();
        $this->view->partesMenu($partes);

    }
    
    
    public function pedirInfoProducto()
    {
        $this->view->pedirInfoProducto();
    }
    
    
    public function crearProducto($request)
    {
        $this->model->crearProducto($request);
        echo 'Producto creado de forma exitosa';
    }
    
    public function verProducto($request)
    {
        $producto = $this->model->verProducto($request['id']);
        $this->view->verProducto($producto);

    }
}