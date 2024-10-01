<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class ProcesadorModel extends Conexion
{
    public function traerProcesadores()
    {
        $sql = "select * from procesador  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $procesador = $this->get_table_assoc($consulta);
        return $procesador;
    }

}