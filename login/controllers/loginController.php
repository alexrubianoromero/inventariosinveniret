<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/login/views/loginView.php');  
require_once($raiz.'/login/models/UsuarioModel.php');  
// require_once($raiz.'/pruebaAdminLteStared/controladores/plantilla.controlador.php');  
class loginController
{
    protected $view;
    protected $model;
    // protected $viewPlantilla;

    public function __construct()
    {
        $this->view = new loginView();
        $this->model = new UsuarioMOdel();
        // $this->viewPlantilla = new PlantillaControlador();
           
        // if(!isset($_REQUEST['opcion'])){
        //     $this->pantallaInicial();
        // }    

        // if(!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario']=='' ){
        //     $this->pantallaInicial();
        // }    
        
    //     if($_REQUEST['opcion']=='verificarCredenciales'){
    //         $this->verificarCredenciales($_REQUEST);

    //    }   
    //    if($_REQUEST['opcion']=='verificarCredencialesRespJson'){

    //     $this->verificarCredencialesRespJson($_REQUEST);
    //    }

    //    if($_REQUEST['opcion']=='menuPrincipal'){

    //     $this->menuPrincipal($_REQUEST);
    //    }

    //    if($_REQUEST['opcion']=='salirSistema'){

    //     $this->salirSistema();
    //    }    

         
    }
    // public function pantallaInicial()
    // {
    //     $this->view->pantallaInicial();
    // }
    public function pantallaInicial()
    {
        $this->view->pantallaInicial();

    }

    public function verificarCredenciales($request){

        $validacion =  $this->model->verificarCredenciales($request);
        //  die('la validacion:'.$validacion['valida']);
         //   $validacion['valida'] = 1;
        if($validacion['valida'] == 1)
        {
            //aqui se define si las credenciales estan bien 
            // echo '<br>estatus de sesion '.session_status().'<br>';
            // echo '<pre>';
            // print_r($_SESSION);
            // echo '</pre>';
         //    $valor = session_status();
         //    echo '<br>estatus session desde validacion '.$valor.'<br>';
            if (!isset($_SESSION)) { session_start(); }
            
            $_SESSION['id_usuario'] = $validacion['datos']['id_usuario'];
            $_SESSION['usuario'] = $validacion['datos']['login'];
            $_SESSION['nivel'] = $validacion['datos']['nivel'];
            // echo '<br>despues de iniciada '.session_status().'<br>';
            // echo '<pre>';
            // print_r($_SESSION);
            // echo '</pre>';
            // echo '<br>estadus'.session_status().'<br>';
            // session_destroy();
            // echo '<br>estatus despues de destroy'.session_status().'<br>';
            // die();
 
         
         //    $this->menuPrincipal();
        //  echo 'validacion correcta';
            
         }
         else{
             session_destroy();
             $this->view->pantallaInicial();
         }
         
     } 


     public function verificarCredencialesRespJson($request){

        $validacion =  $this->model->verificarCredenciales($request);
     //    $resultado = $validacion['valida'];
          echo json_encode($validacion);
     } 



    //  public function menuPrincipal($request){

    //     $this->view->menuPrincipal($request);

    // } 

     public function menuPrincipal($request){

        // $this->view->menuPrincipal($request);
        // $this->viewPlantilla = new PlantillaControlador();
        echo 'antes del llamado de plantilla '; 
        $this->viewPlantilla = new PlantillaControlador();
        // include('pruebaAdminLteStared/index.php');

    } 


    
    public function salirSistema(){
        session_destroy();
        $this->view->pantallaInicial();

    } 

}


?>