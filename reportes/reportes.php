<?php
date_default_timezone_set('America/Bogota');
$raiz = dirname(__file__);
//  die('asd'.$raiz);
 require_once($raiz.'/controllers/reportesController.php');  
$reportesController = new reportesController();

?>