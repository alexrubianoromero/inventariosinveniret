<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class EstadoInicioPedidoModel extends Conexion
{

        public function traerEstadosInicioPedido()
        {
            $sql = "select * from estadosInicioPedido where 1=1   and 	mostrarEnAgregarItem = '1'	 ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $estadosInicio = $this->get_table_assoc($consulta);
            return $estadosInicio;
        }
        
        public function traerEstadosInicioPedidoId($id)
        {
            $sql = "select * from estadosInicioPedido where id= '".$id."'  ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $infoEstado = mysql_fetch_assoc($consulta); 
            return $infoEstado;
        }
        
}