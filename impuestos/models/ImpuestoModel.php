<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class ImpuestoModel extends Conexion
{

   public function traerImpuestos()
   {
       $sql = "select * from impuestos "; 
       $consulta = mysql_query($sql,$this->connectMysql());
       $arrImpuestos = mysql_fetch_assoc($consulta);
       return $arrImpuestos; 
    }

}