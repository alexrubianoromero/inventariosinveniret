<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class TipoParteModel extends Conexion
{

    public function traerTipoParteId($id)
    {
        $sql = "select * from tipoparte where id = '".$id."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $tipoparte = mysql_fetch_assoc($consulta);
        return $tipoparte;  
    }


}