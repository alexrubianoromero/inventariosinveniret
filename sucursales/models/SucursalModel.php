<?php
$raiz =dirname(dirname(dirname(__file__)));
//   die('rutamodelsucursal '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class SucursalModel extends Conexion
{
    public function traerSucursales()
    {
        $sql = "select * from sucursales order by id desc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $sucursales = $this->get_table_assoc($consulta);
        return $sucursales;
    } 

    public function crearSucursal($request)
    {
        $sql = "insert into sucursales (nombre,direccion,ciudad)
        values (
            '".$request['nombreSucursal']."'
            ,'".$request['direccionSucursal']."'
            ,'".$request['ciudad']."'
    
        ); 
        ";
        $consulta = mysql_query($sql,$this->connectMysql());
        
    }
    
    public function traerSucursalId($id)
    {
        $sql = "select * from sucursales where id =  '".$id."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $sucursal = mysql_fetch_assoc($consulta); 
        return $sucursal;
    }
}


?>