<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');
require_once($raiz.'/partes/models/PartesModel.php');

class CondicionModel extends Conexion
{
    public function traerCondicionId($id)
    {
        $sql = "select * from condicion where id = '".$id."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $cliente = $this->get_table_assoc($consulta);
        return $cliente;
    }
    public function traerCondicionXCondicion($condicion)
    {
        $sql = "select * from condicion where condicion like '%".$condicion."%'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $condicion = mysql_fetch_assoc($consulta);
        return $condicion;
    }

}