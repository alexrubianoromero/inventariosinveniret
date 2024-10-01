<?php
$tabla1 = "categorias";
$tabla2 = "subcategorias";
$tabla3 ="cliente0";
//$tabla5 ="parametros";
$tabla10 = "empresa"; 
$tabla11 = "facturas";
$productos = "productos";  //es la misma tarifas 
$tabla16 = "usuarios";
$tabla17 = "iva";
$tabla30 = "perfiles";
$tabla31 = "menu_perfil";

$roles = "roles";
$reservas = "reservas";
$estados_reserva = "estados_reserva";
$comentarios_reserva = "comentarios_reserva";
$historial_cambios = "historial_cambios";
$recibos = "recibos";
$tipo_alimentacion = "tipo_alimentacion";
$tipo_habitacion = "tipo_habitacion";
$tarifas_impuestos = "tarifas_impuestos";
$tipo_venta = "tipo_venta";
$forma_pago = "forma_pago";
$tipo_vuelo = "tipo_vuelo";
$item_pasajeros_reserva = "item_pasajeros_reserva";
$cxp_proveedores = "cxp_proveedores";
$recibos_proveedores = "recibos_proveedores";  //son los egresos 
$liquidacion_reserva = "liquidacion_reserva";
$tipo_destino = "tipo_destino";
$tabla54 = "cargue_nombre";
$destinos = "destinos";
$hoteles = "hoteles";
$tarifas = "tarifas";
$impuestos = "impuestos";
$cxp_proveedores_eliminadas = "cxp_proveedores_eliminadas";
$cxp_conceptos = "cxp_conceptos";
//$comprobantes_egreso = "comprobantes_egreso";
$tipos_recibos_proveedores = "tipos_recibos_proveedores";
$formas_pago_egresos = "formas_pago_egresos";
$facturas_proforma = "facturas_proforma";
$tipo_proforma = "tipo_proforma";
/*valores para pc*/


/*
$servidor = "localhost";
$usuario = "root";
$clave  = "peluche2016";
$nombrebase = "base_summers";

*/


$servidor = "";
$usuario = "";
$clave  = "";
$nombrebase = "";


$conexion =mysql_connect($servidor,$usuario,$clave);
$la_base =mysql_select_db($nombrebase,$conexion);




?>
