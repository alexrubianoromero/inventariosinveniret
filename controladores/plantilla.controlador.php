<?php
$raiz = dirname(dirname(__file__));

// require_once($raiz.'/login/controllers/loginController.php');  
// require_once($raiz.'/login/views/loginView.php');  
require_once($raiz.'/login/models/UsuarioModel.php');  

class PlantillaControlador
{
    // protected $view;
    protected $model;
    
    
    public function __construct()
    {
        $this->model = new UsuarioModel();

        if( (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario']=='') && !isset($_REQUEST['opcion']) )
        {
        //    echo 'no hay session'; 
           include("vistas/plantillaLogueo.php");
           
        }
        // else{
        //    

        // }
        if(isset($_REQUEST['opcion']))
        {
            if($_REQUEST['opcion']== 'verificarCredenciales')
            {
                $this->verificarCredenciales($_REQUEST);
            }
            
            if($_REQUEST['opcion']== 'menuPrincipal')
            {
                $this->menuPrincipal();
            }
            if($_REQUEST['opcion']== 'salir')
            {
                $this->salir();
            }
            
           
        }
        
    }

    public function CargarPlantilla(){
        include("vistas/plantilla.php");
    }
    
    public function mostrarPlantillaLogueo()
    {
        include("vistas/plantillaLogueo.php");
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
            $_SESSION['idSucursal'] = $validacion['datos']['idSucursal'];
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
    
            echo json_encode($validacion);
            exit();
            
         }
         else{
             session_destroy();
            //  $this->view->pantallaInicial();
            //  include("vistas/plantillaLogueo.php");
             echo json_encode($validacion);
             exit();
         }
         
     } 

     
     public function menuPrincipal(){
        $this->CargarPlantilla();
    } 

    public function salir()
    {
        include("vistas/plantillaLogueo.php");
    }

}


?>