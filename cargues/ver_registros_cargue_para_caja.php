<?php
session_start();
include('../valotablapc.php');
include('../funciones.php');
date_default_timezone_set('America/Bogota');

//
$sql_cuenta_recaudo = "select codigo_cuenta from $tabla57   where id_empresa =  '".$_SESSION['id_empresa']."' and nombre_cuenta  = 'RECAUDO' ";
//echo '<br>consulta cuenta <br>'.$sql_cuenta_recaudo;
$consulta_cuenta = mysql_query($sql_cuenta_recaudo);
$arreglo_cuenta = mysql_fetch_assoc($consulta_cuenta);
$codigo_cuenta = $arreglo_cuenta['codigo_cuenta'];

$sql_traer_suma_recibos_cuenta_14900500 = "select sum(creditos) as suma  from $tabla53  where id_cargue_nombre =  '".$_REQUEST['id_archivo']."' 
 and cuenta = '".$codigo_cuenta."' ";
$consulta_suma = mysql_query($sql_traer_suma_recibos_cuenta_14900500,$conexion);
$arreglo_suma = mysql_fetch_assoc($consulta_suma);
$suma_dia = $arreglo_suma['suma'];

echo '<BR> TOTAL RECAUDO DIA '.$suma_dia.'<BR><BR>';

$sql_mostrar_registros_cargue = "select cuenta,descripcion1,saldo_cuenta,comprobante,fecha,
nit,nombre,descripcion2,inv_cruce_cheque,
creditos,saldo_mov
 from $tabla53    where id_cargue_nombre =  '".$_REQUEST['id_archivo']."' 
 and cuenta = '".$codigo_cuenta."' ";
$consulta_registros = mysql_query($sql_mostrar_registros_cargue);

//cho '<br>'.$sql_mostrar_registros_cargue;
$ancho_tabla = '80%';
$datos = get_table_assoc($consulta_registros);

draw_table($datos,$ancho_tabla);

?>