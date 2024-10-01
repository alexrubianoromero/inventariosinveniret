<?php
$raiz = dirname(dirname(dirname(__file__)));
// require_once($raiz.'/hardware/views/hardwareView.php'); 
// require_once($raiz.'/hardware/models/HardwareModel.php'); 
// require_once($raiz.'/partes/models/PartesModel.php'); 
require_once($raiz.'/movimientos/views/movimientosView.php'); 
require_once($raiz.'/movimientos/models/MovimientoParteModel.php'); 
// die('control123'.$raiz);

class movimientosController
{
    protected $vista; 
    protected $model ; 

    public function __construct()
    {
        // echo 'movimientosController1234'; 
        $this->vista = new movimientosView(); 
        $this->model = new MovimientoParteModel(); 

        if($_REQUEST['opcion']=='verMovimientosParte')
        {
            // die('ver movimientos parte ');
           $this->verMovimientosParte($_REQUEST);
        }
    }

    public function verMovimientosParte($request)
    {
        $movimientos = $this->model->traerMovimientosParte($request['idParte']); 
        //     echo '<pre>';
        // print_r($movimientos); 
        // echo '</pre>';
        // die();

        $this->vista->verMovimientosParte($movimientos);
    }

}
?>