<?php
$raiz = dirname(dirname(dirname(__file__)));
require_once($raiz.'/login/models/UsuarioModel.php'); 
require_once($raiz.'/users/views/usersView.php'); 
// die('usuarios'.$raiz);

// die('pasooo3');
class usersController
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

        $this->model = new UsuarioModel();  
        $this->view = new usersView();  

        // echo 'llego a usercontroller';
        if(!isset($_REQUEST['opcion'])){
            $this->usersMenu();
        }    

        if($_REQUEST['opcion']=='pedirInfoUsuario'){
            $this->pedirInfoUsuario();
        }

        if($_REQUEST['opcion']=='crearUsuario'){
            // echo '<pre>'; print_r($_REQUEST) ;echo '</pre>';
            $this->crearUsuario($_REQUEST);
        }
        if($_REQUEST['opcion']=='cambiarClave'){
            // echo '<pre>'; print_r($_REQUEST) ;echo '</pre>';
            $this->view->cambiarClave();
        }
        if($_REQUEST['opcion']=='realizarCambiarClave'){
            // echo '<pre>'; print_r($_REQUEST) ;echo '</pre>';
            $this->realizarCambiarClave($_REQUEST);
        }
    }

    public function realizarCambiarClave($request)
    {
        $validarClaveActual =  $this->model->validarClaveActual($request);
        if($validarClaveActual == 1)
        {
            $this->model->actualizarClaveUsuario($request); 
            echo 'clave actualizada'; 
        }
        else{
            echo 'Clave anterior no es correcta'; 
        }
        // die('valor de valida clave actual '.$validarClaveActual); 
        // $this->view->usersMenu($users);
    }
    public function usersMenu()
    {
        $users =  $this->model->getUsers();
        $this->view->usersMenu($users);
    }
    public function pedirInfoUsuario()
    {
        $this->view->pedirInfoUsuario();
    }
    public function crearUsuario($request)
    {
        //    echo '<pre>'; print_r($_REQUEST) ;echo '</pre>'; die();
        //verificar que ese email o usuario no exista en el sistema
        //  die('llego a funcion de controller ');
         $this->model->crearUsuario($request);
         echo 'El usuario se ha creado Satisfactoriamente';
    }
}




?>