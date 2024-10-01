<?php
date_default_timezone_set('America/Bogota');
$raiz = dirname(dirname(__file__));
//  die('asd'.$raiz);
require_once($raiz.'/hojasdevida/controllers/hojasdeVidaController.php');  
$hojasdeVidaController = new hojasdeVidaController();

?>