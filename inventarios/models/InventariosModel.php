<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class InventariosModel extends Conexion
{

    public function traerInventarios()
    {
        $sql = "select * from inventario order by idInventario asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $inventario = $this->get_table_assoc($consulta);
        return $inventario;
    } 
    
    public function traerComputadoresMonitores()
    {
        $sql = "select * from inventario where idTipoParte in ('1','2') order by idInventario asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $inventario = $this->get_table_assoc($consulta);
        return $inventario;
    }
    public function traerPartesEnGeneral()
    {
        $sql = "select * from inventario where idTipoParte not in ('1','2') order by idInventario asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $inventario = $this->get_table_assoc($consulta);
        return $inventario;
    }
   


    public function crearProducto($request)
    {
        $sql = "insert into inventario 
                (idImportacion,lote,serial,marca,idTipoProducto,chasis,modelo
                 ,pulgadas,procesador,generacion,ramTipo,ram,discoTipo,capacidadDisco,comentarios) 
        values (
                '".$request['idImportacion']."'
                ,'".$request['lote']."'
                ,'".$request['serial']."'
                ,'".$request['marca']."'
                ,'".$request['tipoProd']."'
                ,'".$request['chasis']."'
                ,'".$request['modelo']."'
                ,'".$request['pulgadas']."'
                ,'".$request['procesador']."'
                ,'".$request['generacion']."'
                ,'".$request['ramTipo']."'
                ,'".$request['ram']."'
                ,'".$request['discoTipo']."'
                ,'".$request['capacidadDisco']."'
                ,'".$request['comentarios']."'

        ) " ; 
        // die($sql);    
        $consulta = mysql_query($sql,$this->connectMysql());
        
    }
    public function verProducto($id)
    {
        $sql = "select * from inventario where idInventario = '".$id."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $producto = mysql_fetch_assoc($consulta);
        return $producto;  
    }

}