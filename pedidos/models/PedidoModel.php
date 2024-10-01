<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);
require_once($raiz.'/impuestos/models/ImpuestoModel.php'); 
require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 
require_once($raiz.'/pagos/models/PagoModel.php'); 

require_once($raiz.'/conexion/Conexion.php');

class PedidoModel extends Conexion
{
    protected $impuestoModel;
    protected $itemPedidoModel;
    protected $pagoModel;

        public function __construct()
        {
            session_start();
            $this->impuestoModel = new ImpuestoModel();
            $this->itemPedidoModel = new ItemInicioPedidoModel();
            $this->pagoModel = new PagoModel();
        }
        public function traerPedidos()
        {
            $sql = "select * from pedidos where 1= 1 and idSucursal = '".$_SESSION['idSucursal']."'  order by idPedido desc";
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidos = $this->get_table_assoc($consulta);
            return $pedidos;
        }
        public function traerPedidosFechas($request)
        {
            $sql = "select * from pedidos p
                    where 1= 1 
                    and p.idSucursal = '".$_SESSION['idSucursal']."' ";
            if($request['fechaIn'] != '')
            {  $sql .= " and p.fecha >= '".$request['fechaIn']."'   "; }        
            if($request['fechaFn'] != '')
            { $sql .= " and p.fecha <= '".$request['fechaFin']."'   "; }        
            $sql .= "order by p.idPedido desc";
            die($sql ); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidos = $this->get_table_assoc($consulta);
            return $pedidos;
        }
        public function traerItemsPedidoFechas($request)
        {
            $sql = "select p.idPedido,p.fecha,p.idCliente,
                    i.id,i.tipoItem,i.idHardwareOParte,i.total 
                    from pedidos p
                    inner join itemsInicioPedido i on (i.idPedido = p.idPedido)
                    where 1= 1 
                    and i.estado = 1
                    and p.idSucursal = '".$_SESSION['idSucursal']."' ";
            if($request['fechaIn'] != '')
            {  $sql .= " and p.fecha >= '".$request['fechaIn']."'   "; }        
            if($request['fechaFn'] != '')
            { $sql .= " and p.fecha <= '".$request['fechaFin']."'   "; }        
            $sql .= "  group by p.idPedido order by p.idPedido desc";
            // die($sql ); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidos = $this->get_table_assoc($consulta);
            return $pedidos;
        }
        public function pedidosFiltrados($idCliente)
        {
            $sql = "select * from pedidos where 1= 1 and idSucursal = '".$_SESSION['idSucursal']."'
                    and idCliente = '".$idCliente."'  order by idPedido desc";
                    // die($sql ); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidos = $this->get_table_assoc($consulta);
            return $pedidos;
        }
        public function traerPedidoId($id)
        {
            $sql = "select * from pedidos where idPedido = '".$id."'   ";
            //  die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedido = mysql_fetch_assoc($consulta);
            // echo '<pre>'; 
            // print_r($pedido); 
            // echo '</pre>';
            // die(); 
            return $pedido;
        }

        
        
        public function grabarEncabezadoPedido($request)
        {
            $impuestos = $this->impuestoModel->traerImpuestos();

            $sql = "insert into pedidos (idCliente,fecha,porcenretefuente,porcenreteica,idSucursal,	idusuarioCreacion)   
                values ('".$request['idEmpresaCliente']."',now(),'".$impuestos['porcenretefuente']."'
                ,'".$impuestos['porcenreteica']."','".$_SESSION['idSucursal']."','".$_SESSION['id_usuario']."')";
                $consulta = mysql_query($sql,$this->connectMysql());
                //  die($sql); 
            $ultimoId =  $this->obtenerUltimoIdPedidos();   
            return $ultimoId;
        }
        
        public function obtenerUltimoIdPedidos()
        {
            $sql = "select max(idPedido) as maximo from pedidos ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $arr = mysql_fetch_assoc($consulta);
            $ultimo = $arr['maximo']; 
            // die($ultimo); 
            return $ultimo;
            
        }
        
        public function actualizarWoPedido($request)
        {
            $sql = "update pedidos set wo = '".$request['valor']."'   where idPedido = '".$request['idPedido']."'    "; 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        
        public function actualizarRPedido($request)
        {
            $sql = "update pedidos set r = '".$request['valor']."'   where idPedido = '".$request['idPedido']."'    "; 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        public function actulizarIPedido($request)
        {
            $sql = "update pedidos set i = '".$request['valor']."'   where idPedido = '".$request['idPedido']."'    "; 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        
        public function actualizarPedido($request)
        {
            $sql = "update pedidos set observaciones = '".$request['comentarios']."'   
                    ,porcenretefuente = '".$request['porcenretefuente']."'   
                     ,porcenreteica = '".$request['porcenreteica']."'   
                    where idPedido = '".$request['idPedido']."'    "; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        
        public function realizarAsignacionTecnicoAItem($request)
        {
            $sql = "update itemsInicioPedido  
            set idPrioridad = '".$request['idPrioridad']."' , idTecnico = '".$request['idTecnico']."' , asignado = '1'  
            where id= '".$request['idItemPedido']."'  ";
            // die($sql );         
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        
        //esta funcion trae todos los tecnicos que tengan una asignacion
        //idenpendiente del pedido los trae todos los que figuren como asignadoa a algun item inicio
        public function traerLosTecnicosConAsginacion()
        {
            $sql = "select  DISTINCT ( i.idTecnico ) as idTecnico 
            from  itemsInicioPedido i 
            where 1=1 
            and i.idEstadoItem = 0
            and i.asignado = 1
            group by i.idTecnico
            "; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $idTecnicos = $this->get_table_assoc($consulta);
            return $idTecnicos; 
        }       

        //esta funcion trae los tecnicos asignados a los items de un pedido 

        public function traerLosTecnicosConAsginacionIdPedido($idPedido)
        {
            $sql = "select  DISTINCT ( i.idTecnico ) as idTecnico 
            from  itemsInicioPedido i 
            where 1=1 
            and i.idEstadoItem = 0
            and i.asignado = 1
            and i.idPedido = '".$idPedido."'
            group by i.idTecnico
            "; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $idTecnicos = $this->get_table_assoc($consulta);
            return $idTecnicos; 
        }       
        public function traerLosTecnicosConAsginacionIdPedidoSoloTecnicoLogueado($idPedido)
        {
            $sql = "select  DISTINCT ( i.idTecnico ) as idTecnico 
            from  itemsInicioPedido i 
            where 1=1 
            and i.idEstadoItem = 0
            and i.asignado = 1
            and i.idPedido = '".$idPedido."'
            and i.idTecnico = '".$_SESSION['id_usuario']."'
            group by i.idTecnico
            "; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $idTecnicos = $this->get_table_assoc($consulta);
            return $idTecnicos; 
        }       
        
        public function traerPedidosPendientes()
        {
            //definir el estado de los pedidos pendientes 
            //pues los que no esten finalizados 
            //estados de un pedido 
            $sql = "select * from pedidos where idestadoPedido = 0  and  idSucursal = '".$_SESSION['idSucursal']."' "; 
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidos = $this->get_table_assoc($consulta);
            // die($sql); 
            return $pedidos; 
        }

     

        public function traerSaldoPedido($idPedido)
        {
            $sumaItems = $this->itemPedidoModel->traerSumaItemInicioPedido($idPedido);
            $sumaPagos = $this->pagoModel->traerSumaPagosPedido($idPedido);
            $saldo = $sumaItems - $sumaPagos; 
            return $saldo;   
        }

        
}