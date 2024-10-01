<?php
session_start();
include('../valotablapc.php');
include('../funciones_sumers.php');
date_default_timezone_set('America/Bogota');

$datos_detalle = consulta_assoc98741($tabla54,'id_cargue_nombre',$_REQUEST['id_archivo'],$conexion)
$sql_mostrar_registros_cargue = "select *
 from $tabla53    where id_cargue_nombre =  '".$_REQUEST['id_archivo']."' ";
$consulta_registros = mysql_query($sql_mostrar_registros_cargue);

//cho '<br>'.$sql_mostrar_registros_cargue;
$ancho_tabla = '80%';
$datos = get_table_assoc($consulta_registros);

draw_table($datos,$ancho_tabla);
echo 'fffffffffffffffffffffffffff';


  function  consulta_assoc98741($tabla,$campo,$parametro,$conexion)
  {
       $sql="select * from $tabla  where ".$campo." = '".$parametro."' ";
       //echo '<br>'.$sql;
       $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con;
  }

?>