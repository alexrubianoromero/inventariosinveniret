<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');
require_once($raiz.'/hardware/models/HardwareModel.php');


class ItemInicioPedidoModel extends Conexion
{
    protected $hardwareModel; 


        public function __construct()
        {
            $this->hardwareModel = new HardwareModel(); 
     
        }

        public function traerItemInicioPedido($idPedido)
        {
            $sql = "select * from itemsInicioPedido  where idPedido = '".$idPedido."' and anulado = 0 order by id asc ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $itemsInicioPedido = $this->get_table_assoc($consulta);
            return $itemsInicioPedido;
        }
        public function traerSumaItemInicioPedido($idPedido)
        {
            $sql = "select sum(total) as total from itemsInicioPedido  
                    where idPedido = '".$idPedido."' 
                    and anulado = 0 
                    order by id asc ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrSuma = mysql_fetch_assoc($consulta);
            return $arrSuma['total'];
        }
        
        // esto es para hardware
        public function agregarItemInicialPedido($request)
        {
            // echo '<pre>'; 
            // print_r($request); 
            // echo '</pre>';
            // die(); 
            $total = $request['icantidad'] * $request['iprecio'];

            $sql = "insert into itemsInicioPedido(idPedido,cantidad,tipo,subtipo,modelo,pulgadas,
            procesador,generacion,ram,disco,estado,fecha,precio,total,observaciones,tipoItem,capacidadRam
            ,capacidadDisco,idNuevaSucursal,vrUnitario,idSucursalTecnico) 
            values ('".$request['idPedido']."','".$request['icantidad']."','".$request['itipo']."'
            ,'".$request['isubtipo']."'
            ,'".$request['imodelo']."'
            ,'".$request['ipulgadas']."','".$request['iprocesador']."','".$request['igeneracion']."'
            ,'".$request['iram']."','".$request['idisco']."','".$request['idEstadoInicio']."',now()
            ,'".$request['iprecio']."'
            ,'".$total."'
            ,'".$request['iobservaciones']."'
            ,'".$request['tipoItem']."'
            ,'".$request['icapacidadram']."'
            ,'".$request['icapacidaddisco']."'
            ,'".$request['idNuevaSucursal']."'
            ,'".$request['iprecio']."'
            ,'".$_SESSION['idSucursal']."'
            )";   
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
        }

        public function agregarItemInicialPedidoParte($request)
        {
            // echo '<pre>'; 
            // print_r($request); 
            // echo '</pre>';
            // die(); 
            $total = $request['icantidad'] * $request['iprecio'];

            $sql = "insert into itemsInicioPedido(idPedido,cantidad,tipo,subtipo
           ,estado,fecha,precio,total,observaciones,tipoItem,capacidadRam) 
            values ('".$request['idPedido']."','".$request['icantidad']."','".$request['itipo']."'
            ,'".$request['isubtipo']."'
           ,'".$request['idEstadoInicio']."',now()
            ,'".$request['iprecio']."'
            ,'".$total."'
            ,'".$request['iobservaciones']."'
            ,'".$request['tipoItem']."'
            ,'".$request['icapacidadram']."'
            )";   
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        
        public function eliminarItemInicialPedido($id,$infoAsociadoItem)
        {
            //desasociar el hardware
            $sql ="update hardware set  idEstadoInventario =  0 , 	idAsociacionItem = 0  where id = '".$infoAsociadoItem['idHardwareOParte']."'   "; 
            $consulta = mysql_query($sql,$this->connectMysql());
            //limpiar info de asociacionItem
            $sql = "delete from asociadoItemInicioPedidoHardwareOparte  where idItemInicioPedido = '".$id."'  "; 
            $consulta = mysql_query($sql,$this->connectMysql());
            //eliminar item
            $sql = "delete from  itemsInicioPedido   where id = '".$id."'"; 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
    
        
        public function traerItemInicioPedidoId($idItem)
        {
            $sql = "select  * from itemsInicioPedido   where id = '".$idItem."'  and anulado = 0"; 
            $consulta = mysql_query($sql,$this->connectMysql());
            $infoPedido =  mysql_fetch_assoc($consulta);
            return $infoPedido;   
        }
        
        public function traerPedidoConIdAsociadoItem($idAsociacion)
        {
            $sql = "select p.idPedido  as pedido , a.precioVenta as precioVenta
            from asociadoItemInicioPedidoHardwareOparte  a
            inner join  itemsInicioPedido i on (i.id = a.idItemInicioPedido)
            inner join pedidos p on (p.idPedido = i.idPedido)
            where a.id = '".$idAsociacion."'  "; 
            // echo '<br>'.$sql;
            $consulta = mysql_query($sql,$this->connectMysql());
            $infoPedido =  mysql_fetch_assoc($consulta);
            // echo '<pre>'; 
            // print_r($infoItemInicio); 
            // echo '</pre>';
            // die(); 
            return $infoPedido;   
        }
        
        public function sumaItemsInicioPedidoIdPedido($idPedido)
        {
            $sql = "select sum(total) as suma from itemsInicioPedido
            where idPedido = '".$idPedido."' 
            and anulado = 0
            ";
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrSuma = mysql_fetch_assoc($consulta);
            return $arrSuma['suma'];
        }
        
        
        public function traerItemInicioPedidoIdTecnico($id,$idTecnicoAsignado)
        {
            $sql = "select  * from itemsInicioPedido   
            where id = '".$id."'  
            and anulado = 0
            and idasignarA = '".$idTecnicoAsignado."'   "; 
            $consulta = mysql_query($sql,$this->connectMysql());
            $infoItemInicio =  mysql_fetch_assoc($consulta);
            // echo '<pre>'; 
            // print_r($infoItemInicio); 
            // echo '</pre>';
            // die(); 
            return $infoItemInicio;   
        }
        
        public function traerEstadoItemInicioPedidoIdTecnico($idPedido,$idTecnicoAsignado)
        {
            $sql = "select * from itemsInicioPedido   
            where idPedido = '".$idPedido."'  
            and anulado = 0
            and idTecnico = '".$idTecnicoAsignado."'   limit 1 "; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $infoItemInicio =  mysql_fetch_assoc($consulta);
            // echo '<pre>'; 
            // print_r($infoItemInicio); 
            // echo '</pre>';
            // die(); 
            // return $infoItemInicio['idEstadoProcesoItem']; 
            return  $infoItemInicio;
        }
        
        
        public function traerItemsAsignadosATecnico($idTecnico)
        {
            $sql = "select * from itemsInicioPedido  
            where  idTecnico = '".$idTecnico."'   "; 
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());
            $itemsInicioPedido = $this->get_table_assoc($consulta);
            return $itemsInicioPedido;
        }
        public function traerItemsAsignadosATecnicoDeUnPedido($idPedido,$idTecnico)
        {
            $sql = "select * from itemsInicioPedido  
            where  idTecnico = '".$idTecnico."'   
            and idPedido = '".$idPedido."'    "; 
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());
            $itemsInicioPedido = $this->get_table_assoc($consulta);
            return $itemsInicioPedido;
        }
        
        public function relacionarHardwareAItemPedido($request)
        {
            // $sql = "delete  from itemsInicioPedido   where id = '".$id."'"; 
            $sql = "update  itemsInicioPedido set  idHardwareOParte =  '".$request['idHardware']."'     where id = '".$request['idItemAgregar']."'"; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
        }

        public function relacionarparteAItemPedido($request)
        {
            // $sql = "delete  from itemsInicioPedido   where id = '".$id."'"; 
            $sql = "update  itemsInicioPedido set  idHardwareOParte =  '".$request['idParte']."'     where id = '".$request['idItemAgregar']."'"; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        
        public function actulizarEstadoProcesoItem($request)
        {
            // $sql = "delete  from itemsInicioPedido   where id = '".$id."'"; 
            $sql = "update  itemsInicioPedido set  idEstadoProcesoItem =  '".$request['idEstadoProcesoItem']."'     where id = '".$request['idItem']."'"; 
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        public function traerIdHardwarsAsociadosItem($idItem)
        {
           $sql ="select h.serial,a.idHardwareOParte,a.id,a.idItemInicioPedido	 from asociadoItemInicioPedidoHardwareOparte  a
                  inner join hardware h on (h.id = a.idHardwareOParte)
                  where a.idItemInicioPedido = '".$idItem."'  
                  order by a.id asc "; 
           $consulta = mysql_query($sql,$this->connectMysql());
           $hardwars = $this->get_table_assoc($consulta);    
           return $hardwars;
        }

        public function traerIdPArtesAsociadasItem($idItem)
        {
           $sql = "select p.id,p.idSubtipoParte,p.capacidad from   asociadoItemInicioPedidoHardwareOparte a
                    inner join partes p on  (p.id = a.idHardwareOParte)
                    where a.idItemInicioPedido = '".$idItem."'  
                    order by a.id asc "; 
                    // die($sql); 
           $consulta = mysql_query($sql,$this->connectMysql());
           $partes = $this->get_table_assoc($consulta);    
           return $partes;
        }
        
        // public function traerClienteConIdAsociacion($idItemAsociacion)
        // {
            //     $sql ="select c.nombre 
            //     from asociadoItemInicioPedidoHardwareOparte a
            //     inner join itemsInicioPedido i on (i.id =  a.idItemInicioPedido) 
            //     inner join pedidos  p on (p.idPedido = i.idPedido)
            //     inner join cliente0 c on (c.idcliente = p.idCliente)
            //     where a.id = '".$idItemAsociacion."' 
            //     "; 
            //     // echo $sql .'<br>'; 
            //     $consulta = mysql_query($sql,$this->connectMysql());
            //     $arrCliente = mysql_fetch_assoc($consulta);  
            //     return $arrCliente['nombre'];
            // }
            public function traerClientePedido($idPedido)
        {
               $sql = "select c.nombre from pedidos p
               inner join cliente0 c on (c.idcliente = p.idCliente)
               where idPedido = '".$idPedido."'";
               $consulta = mysql_query($sql,$this->connectMysql());
               $arrnombre = mysql_fetch_assoc($consulta);   
               return $arrnombre['nombre'];
               
        }
        public function eliminarRegistroAsociadoId($idAsociado)
        {
            
        }

        public function traerItemInicioPedidosPendientes()
        {
            //definir el estado de los pedidos pendientes 
            //pues los que no esten finalizados 
            //estados de un pedido 
            
            $sql = "select * from itemsInicioPedido where idEstadoProcesoItem < 2   and  idSucursal = '".$_SESSION['idSucursal']."' "; 
            $consulta = mysql_query($sql,$this->connectMysql());
            $itemsInicio = $this->get_table_assoc($consulta);
            // die($sql); 
            return $itemsInicio; 
        }
        
        public function traerPedidosConItemsInicioPendientesTodos(){
            
        }
        public function traerPedidosConItemsInicioPendientesXSucursalYTecnico(){
            $sql = "SELECT DISTINCT(idPedido) FROM itemsInicioPedido 
                    WHERE idEstadoProcesoItem < 2 
                    and idSucursalTecnico = '".$_SESSION['idSucursal']."' 
                    and idTecnico = '".$_SESSION['id_usuario']."'
                    and anulado=0
                    order by idPedido asc";
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidosConItemsPendientes = $this->get_table_assoc($consulta);
            return $pedidosConItemsPendientes;
        }
        public function traerPedidosConItemsInicioPendientesXSucursal(){
            $sql = "SELECT DISTINCT(idPedido) FROM itemsInicioPedido 
                    WHERE idEstadoProcesoItem < 2 
                    and idSucursalTecnico = '".$_SESSION['idSucursal']."' 
                    and anulado=0
                    order by idPedido asc";
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidosConItemsPendientes = $this->get_table_assoc($consulta);
            return $pedidosConItemsPendientes;
        }
        
        public function traerInfodePedidosRelacionados($idPedidos)
        {
            $params = '';
            foreach($idPedidos as $idPedido)
            {
                $params .= "'".$idPedido['idPedido']."',";
            }
            $params .= "' '";
            $sql ="select * from pedidos  where idPedido in (".$params.") and idSucursal = '".$_SESSION['idSucursal']."' ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidosConItemsPendientes = $this->get_table_assoc($consulta);
            
            // die($sql);  
            return $pedidosConItemsPendientes; 
        }
        
        
        
        public function itemsInicioCompletadosHistorialXSucursal(){
            $sql = "SELECT DISTINCT(idPedido) 
                    FROM itemsInicioPedido 
                    WHERE idEstadoProcesoItem = 2 
                    and idSucursalTecnico = '".$_SESSION['idSucursal']."' 
                        and anulado=0
                    order by idPedido asc";
            $consulta = mysql_query($sql,$this->connectMysql());
            $pedidosConItemsFinalizados = $this->get_table_assoc($consulta);
            return $pedidosConItemsFinalizados;
        }
        public function traertecnicosAsociadosAidPedido($idPedido)
        {
            $sql = "  select u.nombre from itemsInicioPedido  i
            inner join usuarios u on (u.id_usuario = i.idTecnico)
            where idpedido = '".$idPedido."'  ";    
            $consulta = mysql_query($sql,$this->connectMysql());
            $tecnicos = $this->get_table_assoc($consulta);
            //   echo '<pre>'; 
            // print_r($tecnicos); 
            // echo '</pre>';
            // die(); 
            return $tecnicos; 
        }
        
        // public function traerInfodePedidosRelacionados($idPedidos)
        // {
        //     $params = '';
        //     foreach($idPedidos as $idPedido)
        //     {
        //         $params .= "'".$idPedido['idPedido']."',";
        //     }
        //     $params .= "' '";
        //     $sql ="select * from pedidos  where idPedido in (".$params.") and idSucursal = '".$_SESSION['idSucursal']."' ";
        //     $consulta = mysql_query($sql,$this->connectMysql());
        //     $pedidosConItemsPendientes = $this->get_table_assoc($consulta);
            
        //     // die($sql);  
        //     return $pedidosConItemsPendientes; 
        // }
    }
    
    
    
    ?>