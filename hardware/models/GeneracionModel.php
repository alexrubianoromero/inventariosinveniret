<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class GeneracionModel extends Conexion
{
    public function traerGeneracion()
    {
        $sql = "select * from generacion ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $generacion = $this->get_table_assoc($consulta);
        return $generacion;
    }

}