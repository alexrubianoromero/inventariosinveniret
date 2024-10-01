<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/hojasdevida/models/HojadeVidaModel.php'); 
require_once($raiz.'/hojasdevida/views/hojasdeVidaView.php'); 

class hojasdeVidaController
{
    protected $model;
    protected $view;

    public function  __construct()
    {
        session_start();
        if(!isset($_SESSION['id_usuario']))
        {
            echo 'la sesion ha caducado';
            echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
            die();
        }
        
        $this->model = new HojadeVidaModel();
        $this->view = new hojasdeVidaView();

        if($_REQUEST['opcion']=='hojasdevidaMenu')
        {
            $this->view->hojasdeVidaMenu();
        }
    }


}