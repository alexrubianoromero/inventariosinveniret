<?php
$raiz = dirname(dirname(dirname(__file__)));
// die($raiz);
require_once($raiz.'/tablerotecnicos/views/tablerotecnicosView.php'); 
// require_once($raiz.'/tablerotecnicos/models/TableroTecnicoModel.php'); 
// die('controol'.$raiz);
// require_once($raiz.'/hardware/models/HardwareModel.php'); 
// require_once($raiz.'/partes/models/PartesModel.php'); 
// require_once($raiz.'/movimientos/models/MovimientoParteModel.php'); 

class tablerotecnicosController
{
    protected $view;
    // protected $model;
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
        $this->view = new tableroTecnicosView();
        // $this->view = new hardwareView();
        // $this->model = new HardwareModel();
        // $this->partesModel = new PartesModel();
        // $this->MovParteModel = new MovimientoParteModel();
        if($_REQUEST['opcion']=='tablerotecnicosMenu')
        {
            // echo 'llego a controlador '; 
            $this->view->tablerotecnicosMenu();
        }

    }   


}    