<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/subtipos/models/SubtipoParteModel.php'); 
require_once($raiz.'/subtipos/views/subtipoParteView.php'); 
// die('control123'.$raiz);

class subtiposController
{
    protected $model ; 
    protected $view ; 

    public function __construct()
    {
        $this->model = new SubtipoParteModel();
        $this->view = new subtipoParteView();

        if($_REQUEST['opcion']=='buscarSuptiposParaSelect')
        {
            $this->buscarSuptiposParaSelect($_REQUEST);
        }


    } 

    public function buscarSuptiposParaSelect($request)
    {
        $subtipos  =  $this->model->traerSubTipoParteIdParte($request['itipo']);
        //    echo 'subtipos<pre>'; 
        //     print_r($subtipos); 
        //     echo '</pre>';
        //     die(); 
        $this->view->selectSubtipos($subtipos); 

    }
    
}    