<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class TipoContribuyenteModel extends Conexion
{
    public function traerTipoContribuyente()
    {
        $sql = "select * from tipoContribuyente ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $tipos = $this->get_table_assoc($consulta);
        return $tipos;
    }
    
    public function traerTipoId($id)
    {
        $sql = "select * from tipoContribuyente where id='".$id."'   ";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $info = mysql_fetch_assoc($consulta);
        return $info;  

    }



}