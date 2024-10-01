<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);
// require_once($raiz.'/impuestos/models/ImpuestoModel.php'); 

require_once($raiz.'/conexion/Conexion.php');

class PagoModel extends Conexion
{
    public function traerPagosPedido($idPedido)
    {
        $sql = "select * from pagos where idPedido = '".$idPedido."' "; 
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $pagos = $this->get_table_assoc($consulta);
        return $pagos;
    }
    public function traerSumaPagosPedido($idPedido)
    {
        $sql = "select sum(valor) as suma from pagos where idPedido = '".$idPedido."' "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrSuma = mysql_fetch_assoc($consulta);
        return $arrSuma['suma'];
    }
    public function crearRegistrosPagosPedido($idPedido)
    {
        for($i=1;$i<=4;$i++)
        {
            $sql = "insert into pagos (idPedido)  values ('".$idPedido."')";      
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
        } 
    }
    
    public function aplicarPagosPedido($request)
    {
        $sql = "update pagos 
        set fecha = '".$request['fecha']."'
        ,observaciones = '".$request['obse']."'
        ,valor = '".$request['valor']."'
        where id = '".$request['idPago']."'  "; 
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    public function traerpedidoIdPago($idPago)
    {
        $sql= "select * from pagos where id = '".$idPago."'   "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arr = mysql_fetch_assoc($consulta);
        return $arr['idPedido'];  

    }

    


}