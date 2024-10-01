<?php
//este modelo es el de la tabla que une los hardware o partes al item inicio de un pedido
$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 

class AsociadoItemInicioPedidoHardwareOparteModel extends Conexion
{
    protected $itemInicioModel;

        public function __construct()
        {
          session_start();   
           
          $this->itemInicioModel  = new ItemInicioPedidoModel();

        }
        public function insertarAsociacionHardwareConItemRegistro($request)
        {
            $infoItem = $this->itemInicioModel->traerItemInicioPedidoId($request['idItemAgregar']);
            $sql = "insert into asociadoItemInicioPedidoHardwareOparte(idHardwareOParte,idItemInicioPedido,fecha,idUsuario,precioVenta) 
            values ('".$request['idHardware']."','".$request['idItemAgregar']."',now(),'".$_SESSION['id_usuario']."','".$infoItem['vrUnitario']."')	 ";
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $maximo = $this->traerMaximoId();
            return $maximo; 
        }

        public function insertarAsociacionParteConItemRegistro($request)
        {
            $sql = "insert into asociadoItemInicioPedidoHardwareOparte(idHardwareOParte,idItemInicioPedido,fecha,idUsuario) 
            values ('".$request['idParte']."','".$request['idItemAgregar']."',now(),'".$_SESSION['id_usuario']."')	 ";
            $consulta = mysql_query($sql,$this->connectMysql());
            // $estadosInicio = $this->get_table_assoc($consulta);
            // return $estadosInicio;
        }


        public function traerMaximoId()
        {
            $sql = "select max(id) as maximo from asociadoItemInicioPedidoHardwareOparte ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrMaximo= mysql_fetch_assoc($consulta); 
            return $arrMaximo['maximo'];
        }

        public function traerAsociadoItemIdAsociado($idAsociado)
        {
            $sql = "select * from asociadoItemInicioPedidoHardwareOparte where id= '".$idAsociado."'  ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $infoAsociado = mysql_fetch_assoc($consulta); 
            return $infoAsociado;
        }
        
        public function traerAsociadoItemIdItem($idItem)
        {
            $sql = "select * from asociadoItemInicioPedidoHardwareOparte where idItemInicioPedido= '".$idItem."'  ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrAsociados= mysql_fetch_assoc($consulta); 
            return $arrAsociados;
        }
        public function eliminarRegistroAsociadoId($idAsociado)
        {
            $sql = "delete from asociadoItemInicioPedidoHardwareOparte where id= '".$idAsociado."' ";   
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        public function traerUltimoItemInicioAsociadoIdHArdware($idHardware)
        {
            $sql = "select max(id) as maxId from asociadoItemInicioPedidoHardwareOparte where idHardwareOParte= '".$idHardware."' ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrMax= mysql_fetch_assoc($consulta); 
            return $arrMax['maxId'];
        }

    

        
}