<?php
 session_start();
//  echo '<pre>';
//  print_r($_SESSION);
//  echo '</pre>';
//  die();
 if(!isset($_SESSION['id_usuario']))
 {
     echo 'la sesion ha caducado';
     echo '<button class="btn btn-primary" onclick="irPantallaLogueo();">Continuar</button>';
     die();
 }
//hay que evaluar si los datos de la sesion de usuario estan correctas 
include('../valotablapc.php');
date_default_timezone_set('America/Bogota');
$raiz =dirname(dirname(__file__));
// die('rutacargar archivo '.$raiz);

require_once($raiz.'/partes/models/PartesModel.php'); 
require_once($raiz.'/subtipos/models/SubtipoParteModel.php'); 
require_once($raiz.'/marcas/models/MarcaModel.php'); 
require_once($raiz.'/marcas/models/MarcaModel.php'); 
require_once($raiz.'/hardware/models/CondicionModel.php'); 
require_once($raiz.'/hardware/models/HardwareModel.php'); 

$marcaModel = new MarcaModel(); 
$subtipoParteModel = new SubtipoParteModel();
$condicionModel = new CondicionModel();
$hardwareModel = new HardwareModel();
?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?php 
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/
function traerUltimoIdPartes($conexion){
    $sql_maximo_id_parte = "select max(id) as maximo   from partes  ";
    $consulta_maximo_id_parte = mysql_query($sql_maximo_id_parte,$conexion);
    $arreglo_maximo_id_parte = mysql_fetch_assoc($consulta_maximo_id_parte);
    $maximo_id = $arreglo_maximo_id_parte['maximo'];
    return $maximo_id; 
}
?>

<h3>Seleccionar archivo Excel que contiene los tikets<br />
<br />
 </h3>
    <form name="frmload" method="post" action="cargar_stickers.php" enctype="multipart/form-data">
        <input type="file" name="file" />       <input type="submit" value="----- IMPORTAR -----" />
    </form>
<div id="show_excel">

        <?php
 
        if($_FILES['file']['name'] != '')
        {
           // require_once 'reader/Classes/PHPExcel/IOFactory.php';
		   require_once '../Classes/PHPExcel/IOFactory.php';
 
            //Funciones extras
 
            function get_cell($cell, $objPHPExcel){
                //select one cell
                $objCell = ($objPHPExcel->getActiveSheet()->getCell($cell));
                //get cell value
                return $objCell->getvalue();
            }
 
            function pp(&$var){
                $var = chr(ord($var)+1);
                return true;
            }
 
            $name     = $_FILES['file']['name'];
            $tname    = $_FILES['file']['tmp_name'];
            $type     = $_FILES['file']['type'];
 
            if($type == 'application/vnd.ms-excel')
            {
                // Extension excel 97
                $ext = 'xls';
            }
            else if($type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            {
                // Extension excel 2007 y 2010
                $ext = 'xlsx';
            }else{
                // Extension no valida
                echo -1;
                exit();
            }
 
            $xlsx = 'Excel2007';
            $xls  = 'Excel5';
 
            //creando el lector
            $objReader = PHPExcel_IOFactory::createReader($$ext);
 
            //cargamos el archivo
            $objPHPExcel = $objReader->load($tname);
 
            $dim = $objPHPExcel->getActiveSheet()->calculateWorksheetDimension();
 
            // list coloca en array $start y $end
            list($start, $end) = explode(':', $dim);
 
            if(!preg_match('#([A-Z]+)([0-9]+)#', $start, $rslt)){
                return false;
            }
            list($start, $start_h, $start_v) = $rslt;
            if(!preg_match('#([A-Z]+)([0-9]+)#', $end, $rslt)){
                return false;
            }
            list($end, $end_h, $end_v) = $rslt;

            $fechapan =  time();
            $fechapan= date ( "Y/m/j" , $fechapan );
            $fecha_hora_actual = date('Y-m-d H:i:s'); 

            $nombre_archivo = $_FILES['file']['name'].'-'.$fecha_hora_actual;

            //echo '<br>nombrearchivo<b>'.$_FILES['file']['name'].'-'.$fechapan;
            $sql_grabar_nombre_archivo = "insert into cargue_nombre  (nombre_archivo,id_empresa) values('".$nombre_archivo."','".$_SESSION['id_empresa']."')";
           // echo '<br>consulta_grabar_nombre<br>'.$sql_grabar_nombre_archivo.'<br>';
            $consulta_grabar_nombre = mysql_query($sql_grabar_nombre_archivo,$conexion);

            $sql_maximo_id_nombre = "select max(id_archivo) as maximo   from cargue_nombre  ";
            $consulta_maximo_id = mysql_query($sql_maximo_id_nombre,$conexion);
            $arreglo_maximo_id = mysql_fetch_assoc($consulta_maximo_id);
            $maximo_id = $arreglo_maximo_id['maximo'];
            //echo '<br>maximo_id<br>'.$maximo_id;
            //empieza  lectura vertical
            
            
            $table = "<table  border='1'>";

            for($v=$start_v+1; $v<=$end_v; $v++){
                //empieza lectura horizontal
                $table .= "<tr>";
                for($h=$start_h; ord($h)<=ord($end_h); pp($h)){
                    $cellValue = get_cell($h.$v, $objPHPExcel);
					//$arreglo_mostrar[$h][$v] = $cellValue; 
                    $table .= "<td>***<input type ='text' name = 'loco_".$v."_".$h."' value ='".$cellValue."'";
					if($h == 'A'){$arreglo_mostrar[$v]['A'] = $cellValue; }
					if($h == 'B'){$arreglo_mostrar[$v]['B'] = $cellValue; }
					if($h == 'C'){$arreglo_mostrar[$v]['C'] = $cellValue; }
                    if($h == 'D'){$arreglo_mostrar[$v]['D'] = $cellValue; }
					if($h == 'E'){$arreglo_mostrar[$v]['E'] = $cellValue; }
                    if($h == 'F'){$arreglo_mostrar[$v]['F'] = $cellValue; }
                    if($h == 'G'){$arreglo_mostrar[$v]['G'] = $cellValue; }
                    if($h == 'H'){$arreglo_mostrar[$v]['H'] = $cellValue; }
                    if($h == 'I'){$arreglo_mostrar[$v]['I'] = $cellValue; }
                    if($h == 'J'){$arreglo_mostrar[$v]['J'] = $cellValue; }
                    if($h == 'K'){$arreglo_mostrar[$v]['K'] = $cellValue; }
                    if($h == 'L'){$arreglo_mostrar[$v]['L'] = $cellValue; }
                    if($h == 'M'){$arreglo_mostrar[$v]['M'] = $cellValue; }
                    if($h == 'N'){$arreglo_mostrar[$v]['N'] = $cellValue; }
                    if($h == 'O'){$arreglo_mostrar[$v]['O'] = $cellValue; }
                    if($h == 'P'){$arreglo_mostrar[$v]['P'] = $cellValue; }
                    if($h == 'Q'){$arreglo_mostrar[$v]['Q'] = $cellValue; }
                    if($h == 'R'){$arreglo_mostrar[$v]['R'] = $cellValue; }
                    if($h == 'S'){$arreglo_mostrar[$v]['S'] = $cellValue; }
                    if($h == 'T'){$arreglo_mostrar[$v]['T'] = $cellValue; }
                    if($h == 'U'){$arreglo_mostrar[$v]['U'] = $cellValue; }
                    if($h == 'V'){$arreglo_mostrar[$v]['V'] = $cellValue; }
                    if($h == 'W'){$arreglo_mostrar[$v]['W'] = $cellValue; }
                    if($h == 'X'){$arreglo_mostrar[$v]['X'] = $cellValue; }
                    if($h == 'Y'){$arreglo_mostrar[$v]['Y'] = $cellValue; }
                    
                   
					//$arreglo_mostrar[$v][$h] = $cellValue; 
                    if($cellValue !== null){
                        $table .= $cellValue;
                    }
                    
					$table .= "></td>";
					
                }
                $table .= "</tr>";
            }
            $table .= "</table>";
            
            ////////////////////////////////
           // echo 'resultado'.$table;

        }
		/*
		echo '<pre>';
		print_r($arreglo_mostrar);
		echo '</pre>';
		*/

        //////////////////////////////////////////////

		echo '<form name = "hoja1" method = "post" action = "mostrar_arreglo.php">';
		echo '<table border = "1">';
		
		$i = 1;
        // die('amtes de preguntaer si esta vacio');
		if (sizeof($arreglo_mostrar)> 0);
					{
                        // die('entro si encuentra info');
						foreach ($arreglo_mostrar as $am)
								{
                                    // die('entro aa leer el arreglo');
									// echo '<br>'.$am['A'];
                                    //aqui comeinzan traduccion de datos 
                                    $infoMarca =  $marcaModel->traerMarcaXMarca($am['G']);

                                    // $infoSubtipoProducto = $subtipoParteModel->traerSubTipoParteNombre($am['H']);

                                    if($am['A']=='1')
                                    {
                                        $infoSubtipoProducto = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['H'],1);
                                    }
                                    if($am['A']=='2')
                                    {
                                        $infoSubtipoProducto = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['H'],1);
                                    }


                                    //estas son las 4 solumnas de ram 
                                    //si no existe la descripcion de la ram entonces debe ser creada
                                    //la subparte de ram va con id de tipoParte = 4
                                    //y asignarle ese id 
                                    $infoSubtipoRam1 = $subtipoParteModel->traerSubTipoParteNombre($am['M']);
                                    $infoSubtipoRam2 = $subtipoParteModel->traerSubTipoParteNombre($am['N']);
                                    $infoSubtipoRam3 = $subtipoParteModel->traerSubTipoParteNombre($am['O']);
                                    $infoSubtipoRam4 = $subtipoParteModel->traerSubTipoParteNombre($am['P']);
                                    
                                    // $existeRam1 = $subtipoParteModel->existeNombreSubtipo($am['M']);
                                    // if($existeRam1){
                                    //     $idRam1 = $subtipoParteModel->traerIdSubtipoConNombreSubtipo($am['M']);
                                    // }else{
                                    //     $subtipoParteModel->crearSubtipoPArte($am['M'],4);
                                    // }

                                    // $infoSubtipoRam1 = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['M'],4);
                                    // $infoSubtipoRam2 = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['N'],4);
                                    // $infoSubtipoRam3 = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['O'],4);
                                    // $infoSubtipoRam4 = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['P'],4);
                                    
                                    
                                    //estos son las 2 columnas de disco
                                    $infoSubtipoDisco1 = $subtipoParteModel->traerSubTipoParteNombre($am['Q']);
                                    $infoSubtipoDisco2 = $subtipoParteModel->traerSubTipoParteNombre($am['R']);
                                    
                                    // $infoSubtipoDisco1 = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['Q'],3);
                                    // $infoSubtipoDisco2 = $subtipoParteModel->traerSubTipoParteNombreRespuestaMejoradaCargues($am['R'],3);


                                    //hay que traer el id de las condiciones y ese es el que queda eh hardware 
                                    // $infoCondicion1  = $condicionModel->traerCondicionXCondicion($am['S']);    
                                    // $idCondicion1 = $infoCondicion1['id'];
                                    //modelo pasa igual que como viene
                                    //pulgasdas consicion pasa igual 
                                    //procesador pasa igual 
                                    //la ram si toca trasladar al id
                                    //condicion 1 y condicion 2 vana apsar igual 

                                    // echo '<pre>';
                                    // print_r($idCondicion);
                                    // echo '</pre>';
                                    // die();
                                    
                                    $sql = "insert into hardware 
                                    (hardwareoparte,serial,ubicacion,idImportacion,lote,
                                    idMarca,idSubInv,chasis,
                                    modelo,pulgadas,procesador,
                                    idRam1,idRam2,idRam3,idRam4,
                                    idDisco1, idDisco2,
                                    idCondicion,idCondicion2,comentarios,
                                    costoItem,costoImportacion,costoProducto,precioMinimoVenta,comodin
                                    ,idSucursal
                                    )
                                    values (
                                        '".$am['A']."','".$am['B']."','".$am['C']."','".$am['D']."'
                                        ,'".$am['E']."','".$infoMarca['id']."','".$infoSubtipoProducto['id']."'
                                        ,'".$am['I']."','".$am['J']."','".$am['K']."','".$am['L']."'
                                        ,'".$infoSubtipoRam1['id']."','".$infoSubtipoRam2['id']."','".$infoSubtipoRam3['id']."','".$infoSubtipoRam4['id']."'
                                        ,'".$infoSubtipoDisco1['id']."','".$infoSubtipoDisco2['id']."'
                                        ,'".$am['S']."','".$am['T']."'
                                        ,'".$am['U']."','".$am['V']."','".$am['W']."','".$am['X']."'
                                        ,'".$am['Y']."','".$am['F']."'
                                        ,'".$_SESSION['idSucursal']."'
                                    
                                    )"; 
                                    // die($sql); 
                                    // $sql = "insert into hardware 
                                    // (hardwareoparte,serial,ubicacion,idImportacion,lote,
                                    // sku,idMarca,idSubInv,chasis,
                                    // modelo,pulgadas,procesador,idRam1,
                                    // idRam2,idRam3,idRam4,idDisco1,
                                    // idDisco2,idCondicion,idCondicion2,comentarios,
                                    // costoItem,costoImportacion,costoProducto,precioMinimoVenta
                                    // )
                                    // values (
                                    //     '".$am['A']."','".$am['B']."','".$am['C']."','".$am['D']."'
                                    //     ,'".$am['E']."','".$am['F']."','".$am['G']."','".$am['H']."'
                                    //     ,'".$am['I']."','".$am['J']."','".$am['K']."','".$am['L']."'
                                    //     ,'".$am['M']."','".$am['N']."','".$am['O']."','".$am['P']."'
                                    //     ,'".$am['Q']."','".$am['R']."','".$am['S']."','".$am['T']."'
                                    //     ,'".$am['U']."','".$am['V']."','".$am['W']."','".$am['X']."'
                                    
                                    // )"; 
                                    //  die($sql);    

                                    //validar que el serial no exista ya en la base de datos 
                                    //la columna que trae el serial es $am['B']
                                    $validaExisteSerial = $hardwareModel->traerHardwareXSerial( $am['B'] );
                                    if($validaExisteSerial==0){
                                        $consulta = mysql_query($sql,$conexion); 
                                    }     
                                    // die(); 
									$i++;
                                    // if($i==2){die(); }
								}
					 } // parece fin de sizeof
							
		//echo '<tr><td><input type ="submit" value ="enviar" ></td></tr>';		
		echo '<table>';
		echo '</form>';		
         
        echo '<BR>IMPORTACION REALIZADA REGISTRADA BAJO EL NOMBRE DE ARCHIVO '.$nombre_archivo;
        //////////////aqui se van a mostrar los cargues existentes en el sistema 
        
        /*
        echo '<br><br>CARGUES EXISTENTES EN EL SISTEMA<br>';
        $sql_archivos_cargados = "select * from $tabla54  where id_empresa = '".$_SESSION['id_empresa']."' and activo = 1 order by id_archivo desc";
        $consulta_archivos_cargados = mysql_query($sql_archivos_cargados,$conexion);
       echo '<table border = "1">';
       while ($cargados = mysql_fetch_assoc($consulta_archivos_cargados))
                {
                    echo '<tr>';
                    echo '<td>'.$cargados['nombre_archivo'].'</td>';
                    echo '<td><a href ="../cargues/ver_registros_cargue.php?id_archivo='.$cargados['id_archivo'].'">Ver Contenido</a></td>';
                    echo '<tr>';
                }
         echo '</table>';   
        */ 

        
		?>
		
</div>

</body>
</html>
