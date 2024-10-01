<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);
require_once($raiz.'/impuestos/models/ImpuestoModel.php'); 

require_once($raiz.'/conexion/Conexion.php');

class HojadeVidaModel extends Conexion
{
    public function traerHardware()
    {
        $sql = "select * from hardware ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }

}