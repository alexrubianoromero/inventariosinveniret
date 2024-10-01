<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);
// require_once($raiz.'/impuestos/models/ImpuestoModel.php'); 
// require_once($raiz.'/pedidos/models/ItemInicioPedidoModel.php'); 
// require_once($raiz.'/pagos/models/PagoModel.php'); 

require_once($raiz.'/conexion/Conexion.php');

class ReporteModel extends Conexion
{
    // protected $impuestoModel;
    // protected $itemPedidoModel;
    // protected $pagoModel;

        public function __construct()
        {
            // $this->impuestoModel = new ImpuestoModel();
            // $this->itemPedidoModel = new ItemInicioPedidoModel();
            // $this->pagoModel = new PagoModel();
        }
        public function traerReporteVentas($fechaIn,$fechaFin)
        {
            // $sql = "select * from pedidos where 1= 1 and idSucursal = '".$_SESSION['idSucursal']."'  order by idPedido desc";
            // $consulta = mysql_query($sql,$this->connectMysql());
            // $pedidos = $this->get_table_assoc($consulta);
            // return $pedidos;
        }
    }       