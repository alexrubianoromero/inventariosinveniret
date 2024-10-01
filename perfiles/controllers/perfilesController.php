<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/perfiles/views/perfilesView.php'); 
require_once($raiz.'/perfiles/models/PerfilModel.php'); 
// die($raiz);

class perfilesController
{
    protected $view;
    protected $model; 

    public function __construct()
    {
        $this->view = new perfilesView();
        $this->model = new PerfilModel();

        if($_REQUEST['opcion']=='perfilesMenu')
        {
            $this->perfilesMenu();
        }

    }    

    public function perfilesMenu()
    {
        $perfiles = $this->model->traerPerfiles();
        //    echo '<pre>'; print_r($perfiles) ;echo '</pre>'; die();
        $this->view->perfilesMenu($perfiles);
    }
}


