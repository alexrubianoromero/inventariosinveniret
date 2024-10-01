<?php
// die('llego aca '); 
date_default_timezone_set('America/Bogota');
$raiz = dirname(dirname(__file__));
//  die('asd'.$raiz);
 require_once($raiz.'/tablerotecnicos/controllers/tablerotecnicosController.php');  
$tablerotecnicosController = new tablerotecnicosController();

?>