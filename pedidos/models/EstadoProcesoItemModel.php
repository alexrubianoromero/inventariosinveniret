<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class EstadoProcesoItemModel extends Conexion
{

    public function traerEstadoProcesoItemId($id)
    {
        $sql = "select * from estadoProcesoItem where idEstadoProceso = '".$id."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $estado = $this->get_table_assoc($consulta);
        return $estado;
    }

    public function traerEstadosProcesoItem()
    {
        $sql = "select * from estadoProcesoItem  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $estados = $this->get_table_assoc($consulta);
        return $estados;
    }



}