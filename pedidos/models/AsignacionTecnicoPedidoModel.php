<?php
$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);
require_once($raiz.'/conexion/Conexion.php');

class AsisgnacionTecnicoPedidoModel extends Conexion
{
    public function registrarAsignacionTecnicoAPedido($request)
    {
        $sql = "insert into asignacionTecnicoPedido (idPedido,idTecnico,idPrioridad)   
                values ('".$request['idPedido']."','".$request['idTecnico']."','".$request['idPrioridad']."')"; 
        $consulta = mysql_query($sql,$this->connectMysql());
    }

    public function traerTecnicosAsignadosApedidos()
    {}

    
}