<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');
require_once($raiz.'/partes/models/PartesModel.php');

class HardwareModel extends Conexion
{
    protected $parteModel; 
    public function __construct()
    {
        session_start();
        $this->parteModel = new PartesModel();
    }
    public function traerHardware()
    {
        $sql = "select * 
                from hardware where 1=1 
                and 	idEstadoInventario = 0
                and idSucursal = '".$_SESSION['idSucursal']."' 
                order by id asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    
    public function traerHardwareTodosLosEstados()
    {
        // and idSucursal = '".$_SESSION['idSucursal']."' 
        $sql = "select * 
                from hardware where 1=1 
                order by id asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }

    public function traerHardwareSinDadosDeBaja()
    {
        $sql = "select * from hardware 
        where 1=1 and idSucursal = '".$_SESSION['idSucursal']."' 
        order by id asc";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    
    public function traerHardwareFiltro($traerHardwareFiltro)
    {
        $sql = "select * 
                from hardware 
                where serial like '%".$traerHardwareFiltro."%' 
                and 	idEstadoInventario = 0
                and idSucursal = '".$_SESSION['idSucursal']."'  
                order by id asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwareFiltroSerialHojasDeVida($traerHardwareFiltro)
    {
        $sql = "select * 
                from hardware 
                where serial like '%".$traerHardwareFiltro."%' 
                and idSucursal = '".$_SESSION['idSucursal']."'  
                order by id asc";
                // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwareFiltroHojasDeVida($traerHardwareFiltro)
    {
        $sql = "select * 
                from hardware 
                where serial like '%".$traerHardwareFiltro."%' 
                and idSucursal = '".$_SESSION['idSucursal']."'  
                order by id asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }

    public function traerHardwarePulgadasFiltro($inputBuscarPulgadas)
    {
        $sql = "select * from hardware where pulgadas like '%".$inputBuscarPulgadas."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwareProcesadorFiltro($inputBuscarProcesador)
    {
        $sql = "select * from hardware where procesador like '%".$inputBuscarProcesador."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function filtrarUbicacionInventario($inputBuscarUbicacion)
    {
        $sql = "select * from hardware where ubicacion like '%".$inputBuscarUbicacion."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function filtrarSkuInventario($inputBuscarSku)
    {
        $sql = "select * from hardware where comodin like '%".$inputBuscarSku."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function filtrarChasisInventario($inputBuscarChasis)
    {
        $sql = "select * from hardware where chasis like '%".$inputBuscarChasis."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function filtrarPulgadasInventario($inputBuscarPulgadas)
    {
        $sql = "select * from hardware where pulgadas like '%".$inputBuscarPulgadas."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function filtrarBuscarProducto($inputBuscarProducto)
    {
        $sql = "select * from hardware where idSubInv = '".$inputBuscarProducto."' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwaregeneracionFiltro($inputBuscarProcesador)
    {
        $sql = "select * from hardware where generacion like '%".$inputBuscarProcesador."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwareImportacionFiltro($inputBuscarProcesador)
    {
        $sql = "select * from hardware where idImportacion like '%".$inputBuscarProcesador."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0   order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    /**
     * el mismo campo de importacion para hardware , se utiliza como proveedor para partes con Serial 
     */
    public function traerHardwareProveedorFiltro($inputBuscarProcesador)
    {
        $sql = "select * from hardware where idImportacion like '%".$inputBuscarProcesador."%' and idSucursal = '".$_SESSION['idSucursal']."' and idEstadoInventario = 0   order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwareLoteFiltro($inputBuscarProcesador)
    {
        $sql = "select * from hardware 
        where lote like '%".$inputBuscarProcesador."%' 
        and idSucursal = '".$_SESSION['idSucursal']."' 
        and idEstadoInventario = 0  
        and hardwareoparte = 1
        order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    /**
     * el campo factura es para partes con serial y utiliza el mismo campo lote de hardware
     */
    public function traerHardwareFacturaFiltro($inputBuscarFactura)
    {
        $sql = "select * from hardware 
        where lote like '%".$inputBuscarFactura."%' 
        and idSucursal = '".$_SESSION['idSucursal']."' 
        and idEstadoInventario = 0  
        and hardwareoparte = 2
        order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwareTipoFiltro($inputBuscarProcesador)
    {
        $sql = "select * from hardware where idTipoInv = '".$inputBuscarProcesador."' and idSucursal = '".$_SESSION['idSucursal']."'  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerHardwareSubTipoFiltro($inputBuscarProcesador)
    {
        $sql = "select * from hardware where idSubInv = '".$inputBuscarProcesador."' and idSucursal = '".$_SESSION['idSucursal']."'  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }
    public function traerEquiposFiltradoEstado($idEstado)
    {
        $sql = "select * from hardware where idEstadoInventario = '".$idEstado."' and idSucursal = '".$_SESSION['idSucursal']."'  order by id asc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = $this->get_table_assoc($consulta);
        return $hardware;
    }



    public function traerHardwareId($idHarware)
    {
        $sql = "select * from hardware where id= '".$idHarware."' ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = mysql_fetch_assoc($consulta);
        return $hardware;
    }

    public function verHardware($id)
    {
        $sql = "select * from hardware where id = '".$id."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $hardware = mysql_fetch_assoc($consulta);
        // echo '<pre>';
        // print_r($hardware); 
        // echo '</pre>';
        // die();
        return $hardware;  
    }

    public function totalizarRamHardwareId($idHardware)
    {
        $infoH = $this->verHardware($idHardware);
        $ram1 = $this->parteModel->traerParte($infoH['idRam1']);
        $ram2 = $this->parteModel->traerParte($infoH['idRam2']);
        $ram3 = $this->parteModel->traerParte($infoH['idRam3']);
        $ram4 = $this->parteModel->traerParte($infoH['idRam4']);
        $totalRam = $ram1[0]['capacidad'] + $ram2[0]['capacidad'] + $ram3[0]['capacidad'] + $ram4[0]['capacidad'] ; 
        return $totalRam;
    }
    public function totalizarDiscoHardwareId($idHardware)
    {
        $infoH = $this->verHardware($idHardware);
        $disco1 = $this->parteModel->traerParte($infoH['idDisco1']);
        $disco2 = $this->parteModel->traerParte($infoH['idDisco2']);
        $totalDisco = $disco1[0]['capacidad'] + $disco2[0]['capacidad'] ; 
        return $totalDisco;
    }

    public function agregarTemporalDividirMemoria($request)
    {
        $sql = "insert into tablaTemporalDividirMemoria (idHardware,idSubtipo,capacidad)     
        values ('".$request['idHardware']."','".$request['idSubTipoRamHardware']."','".$request['capacidadRamHardware']."')"; 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    public function traerRegistrosTemporales($idHardware)
    {
        $sql = "select * from tablaTemporalDividirMemoria   where idHardware =  '".$idHardware."'  order by id asc  " ;    
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrTempo = $this->get_table_assoc($consulta); 
        return $arrTempo; 
    }
    
    public function asignarDivisionHadware($idHardware)
    {
        $temporales = $this->traerRegistrosTemporales($idHardware);
        $memorias = [
            "0" => "idRam1",
           "1" => "idRam2",
           "2" => "idRam3",
           "3" => "idRam4"
        ];
        $conta = 0; 
        foreach($temporales as $temp)
        {
            //busque si ya existe la parte con esa caracteristica 
            //si no existe toca crearla 
            $conRam = $this->parteModel->traerParteConIdSubtipoyCapacidad($temp['idSubtipo'],$temp['capacidad']);
            //     echo '<pre>';
            //  print_r($conRam); 
            //  echo '</pre>';
            //  die();
            if($conRam['filas']>0)
            {
                //el id de la parte 
                $idParteRam = $conRam['info']['id'];     
            }else{
                // die('entro aca '); 
                //se debe crear la parte con estas caracteristicas
                $this->parteModel->grabarParteGeneral($temp['idSubtipo'],$temp['capacidad'],'se crea al dividir memoria');
                $idParteRam = $this->parteModel->traerUltimoIdPartes();
            }  
            //ahora asignarle ese idParte a las 4 ram del hardware     
            $sql = "update hardware set ".$memorias[$conta]." =   '".$idParteRam."'  where id = '".$idHardware."'    ";
            $consulta = mysql_query($sql,$this->connectMysql());
            // die ('<br>'.$sql);  
            $conta++; 
        }
        
    }
    
    public function inactivarBotonDividir($idHardware)
    {
        $sql = "update hardware set  ramdividida = '1' where id = '".$idHardware."'  ";    
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    public function limpiarTablaDivisionRam($idHardware)
    {
        $sql ="delete from 	tablaTemporalDividirMemoria	 where idHardware = '".$idHardware."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    public function actualizarEstadoHardware($idHardware,$estado)
    {
        $sql = "update hardware set idEstadoInventario = '".$estado."'   where id = '".$idHardware."'     "; 
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function  reiniciaridAsociacionItemHardwareId($idHardware)
    {
        $sql = "update hardware set idAsociacionItem = '0' where id =  '".$idHardware."'  "; 
        $consulta = mysql_query($sql,$this->connectMysql());

    }


    public function actualizarIdAsociacionItemEnHardware($idHardware,$idItem)
    {
        $sql = "update hardware set idAsociacionItem = '".$idItem."'   where id = '".$idHardware."'     "; 
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());

    }








    public function desligarRamDeEquipo($request)
    {
        $slots= ['','idRam1','idRam2','idRam3','idRam4'];
        // $ram = $slots[$request['numeroRam']]; 
        $sql = "update hardware set  ".$slots[$request['numeroRam']]." = 0  where  id= '".$request['idHardware']."'   ";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }


    public function desligarDiscoDeEquipo($request)
    {
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('');
        $slots= ['','idDisco1','idDisco2'];
        $sql = "update hardware set  ".$slots[$request['numeroDisco']]." = 0  where  id= '".$request['idHardware']."'   ";
        //  die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function desligarCargadorDeEquipo($request)
    {
        // echo '<pre>';
        // print_r($request); 
        // echo '</pre>';
        // die('');
        $sql = "update hardware set  idCargador = 0  where  id= '".$request['idHardware']."'   ";
        //  die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }


    public function asociarParteEnTablaHardware($request)
    {
        $sql = "update hardware set idDisco = '".$request['idDisco']."'      where id =   '".$request['idHardware']."'   "; 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function asociarParteRamEnTablaHardware($request)
    {
        $sql = "update hardware set idRam = '".$request['idRam']."'      where id =   '".$request['idHardware']."'   "; 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    public function grabarNuevoHardware($request)
    {
        $sql = "insert into hardware(idImportacion,lote,serial,idMarca,idTipoInv,idSubInv,
        chasis,modelo,pulgadas,procesador,generacion,ramdividida,idSucursal)
        values ( '".$request['idImportacion']."'
        ,'".$request['lote']."'
        ,'".$request['serial']."'
        ,'".$request['marca']."'
        ,'".$request['itipo']."'
        ,'".$request['isubtipo']."'
        ,'".$request['chasis']."'
        ,'".$request['modelo']."'
        ,'".$request['pulgadas']."'
        ,'".$request['procesador']."'
        ,'".$request['generacion']."'
        ,'1'
        ,'".$_SESSION['idSucursal']."'
        )";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        
    }
    
    
    //este funcion trae la informacion de la tabla hardware
    //y se soloca el nombre del campo de la tabla hardware 
    public function traerInfoCampoTablaHardware($campo)
    {
        $sql = "select distinct(".$campo.") as id from hardware  
        where 1=1 
        and idSucursal = '".$_SESSION['idSucursal']."' 
        and hardwareoparte = 1
        group by ".$campo ;
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrIdImport = $this->get_table_assoc($consulta); 
        return $arrIdImport;
    }
    /**
     * para las partes con serial se maneja el mismo campo de importacion
     * pero aqui se aclara que es para las partes con serial osea hardwareoparte = 2
     */
    public function traerInfoCampoPartesConserialHardware($campo)
    {
        $sql = "select distinct(".$campo.") as id 
        from hardware  where 1=1 
        and idSucursal = '".$_SESSION['idSucursal']."' 
        and hardwareoparte = 2
        group by ".$campo ;
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrIdImport = $this->get_table_assoc($consulta); 
        return $arrIdImport;
    }

    //esta funcion trae el campo tal cual osea graba el valor de la descripcion 
    //esto para evitar despues tener que buscar el id 
    //entonces simplmente se pone el valor y ya 
    public function traerInfoCampoTabla($campo)
    {
        $sql = "select distinct(".$campo.") as id from ".$campo." group by ".$campo ;
        //  die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrIdImport = $this->get_table_assoc($consulta); 
        return $arrIdImport;
    }
    public function traerInfoTablaParaColocarenSelect($campo)
    {
        $sql = "select id , ".$campo."  as descripcion from ".$campo ;
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrIdImport = $this->get_table_assoc($consulta); 
        return $arrIdImport;
    }
    
    public function traerInfoCampoTablaId($id,$tabla)
    {
        $sql = "select ".$tabla." from ".$tabla." where id = '".$id."'    " ;
        //  die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrIdImport = mysql_fetch_assoc($consulta); 
        return $arrIdImport[$tabla];
    }
    public function actualizarCondicionHardware($request)
    {
        $sql = "update hardware set idCondicion = '".$request['idCondicion']."'  where id='".$request['idHardware']."'"; 
        //  die($sql ); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function actualizarCondicion2Hardware($request)
    {
        $sql = "update hardware set idCondicion2 = '".$request['idCondicion2']."'  where id='".$request['idHardware']."'"; 
        //  die($sql ); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function actualizarOnchengeUbicacion($request)
    {
        $sql = "update hardware set ubicacion = '".$request['ubicacion']."'  where id='".$request['idHardware']."'"; 
        //  die($sql ); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function actualizarOnchangeProcesador($request)
    {
        $sql = "update hardware set procesador = '".$request['procesador']."'  where id='".$request['idHardware']."'"; 
        //  die($sql ); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    public function traerHardwareDisponibles()
    {
        $sql =  "select * from hardware where 1=1 	and  idEstadoInventario = 0  and anulado = 0 
        and idSucursal = '".$_SESSION['idSucursal']."' "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrInfo = $this->get_table_assoc($consulta); 
        return $arrInfo;
    }
    public function traerHardwareDisponiblesFiltradosSerial($request)
    {
        $sql =  "select * from hardware where 1=1 	and  serial = '".$request['serialABuscar']."' 
        and   idEstadoInventario = 0  and anulado = 0 and idSucursal = '".$_SESSION['idSucursal']."' "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrInfo = $this->get_table_assoc($consulta); 
        return $arrInfo;
    }
    
    public function cambiarEstadoHArdwareId()
    {
        
    }
    
    public function realizarCambioDeBodega($idHardware,$idNuevaSucursal)
    {
        $infoHardware =  $this->traerHardwareId($idHardware);
        $idSucursalAnterior = $infoHardware['idSucursal'];
        $sql = "update hardware set idSucursal = '".$idNuevaSucursal."'  where id =  '".$idHardware."'  ";  
        $consulta = mysql_query($sql,$this->connectMysql());
        $respu['idHardware'] = $idHardware;
        $respu['idSucursalAnterior'] = $idSucursalAnterior;
        $respu['idNuevaSucursal'] = $idNuevaSucursal;
        return $respu;
    }
    
    public function actualizarCostos($request)
    {
        $sql = "update hardware set 
        costoItem = '".$request['costoItem']."'
        ,costoImportacion = '".$request['costoImportacion']."'
        ,costoProducto = '".$request['costoProducto']."'
        ,precioMinimoVenta = '".$request['precioMinimoVenta']."'
        
        where id = '".$request['idHardwareCosto']."'       
        ";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    public function traerUbicaciones()
    {
        $sql="select DISTINCT(ubicacion) from hardware  group by ubicacion";
        $consulta = mysql_query($sql,$this->connectMysql());
        $ubicaciones = $this->get_table_assoc($consulta); 
        return $ubicaciones;
    }

    /**
     * se definio que el valor de sku que trae el archivo de exccel se almacenaria en comodin
     * y para mostrarlo se concatenara con el campo sku que es el contador de devoluviones de renta 
     */
    public function traerSkus()
    {
        $sql="select DISTINCT(comodin) as comodin from hardware  group by comodin";
        $consulta = mysql_query($sql,$this->connectMysql());
        $skus = $this->get_table_assoc($consulta); 
        return $skus;
    }
    public function traerChasises()
    {
        $sql="select DISTINCT(chasis) as chasis from hardware  group by chasis";
        $consulta = mysql_query($sql,$this->connectMysql());
        $chasises = $this->get_table_assoc($consulta); 
        return $chasises;
    }
    
    public function traerPulgadas()
    {
        $sql="select DISTINCT(pulgadas) as pulgadas from hardware  group by pulgadas";
        $consulta = mysql_query($sql,$this->connectMysql());
        $pulgadas = $this->get_table_assoc($consulta); 
        return $pulgadas;
    }
    public function traerIdsSubInv()
    {
        $sql="select DISTINCT(idSubInv) as idSubInv from hardware  group by idSubInv";
        $consulta = mysql_query($sql,$this->connectMysql());
        $idsSubInv = $this->get_table_assoc($consulta); 
        return $idsSubInv;
    }
    
    public function aumentarSkuIdHardware($idHardware,$valorSku)
    {
        $sql= "update hardware set sku = '".$valorSku."'  where id = '".$idHardware."'";  
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    
    /**
     * Esta funcion verifica si el serial ya existe en la tabla de hardware
     */
    public function traerHardwareXSerial($serial)
    {
        $sql = "select * from hardware  where serial = '".$serial."'";
        $consulta = mysql_query($sql,$this->connectMysql());
        $filas = mysql_num_rows($consulta);
        return $filas;  
    }
 
}
