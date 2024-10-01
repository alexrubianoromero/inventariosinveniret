<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');
require_once($raiz.'/sucursales/models/SucursalModel.php');

class MovimientoHardwareModel extends Conexion
{
        protected $sucursalModel;
        public function __construct()
        {
            session_start();
            $this->sucursalModel = new SucursalModel();  
        }
        /**
         * esta funcion recibe los parametros contenidos en un objeto
         * idTipoMov   1 entrada  2 salida  3 cambio bodega  4 dado de baja  5 devuelto 
         */

        public function registrarMovimientohardware($infoMov)
        {
            $obseSinComillas = addslashes ($infoMov->observaciones);
            $sql ="insert into movimientosHardware (fecha,idTipoMov,idHardware,idItemInicio,observaciones ,idUsuario)  
            values (now(),$infoMov->idTipoMov,$infoMov->idHardware,$infoMov->idItemInicio,'".$obseSinComillas."','".$_SESSION['id_usuario']."') ";
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql()); 
            $idMax = $this->traerUltimoRegistro();
            return $idMax;


        }
        
        
        public function  traerMovimientosHardwareId($idHardware)
        {
            $sql = "select * from movimientosHardware  where idHardware = '".$idHardware."' order by idMovimiento desc";
            $consulta = mysql_query($sql,$this->connectMysql()); 
            $arrMov = $this->get_table_assoc($consulta);
            return $arrMov; 
        }

        public function traerMaxIdMovimientoHardwareId($idHardware)
        {
            $sql = "select max(idMovimiento) as max from movimientosHardware  where idHardware = '".$idHardware."' ";
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql()); 
            $arrMov = mysql_fetch_assoc($consulta);
            $max = $arrMov['max'];
            return $max; 
        }
        
        public function  traerMovimientoId($idMovimiento)
        {
            $sql = "select * from movimientosHardware  where idMovimiento = '".$idMovimiento."' ";
            $consulta = mysql_query($sql,$this->connectMysql()); 
            $arrMov = mysql_fetch_assoc($consulta);
            return $arrMov; 
        }

        public function traerUltimoRegistro()
        {
            $sql = "select max(idMovimiento) as maxId from movimientosHardware ";
            $consulta = mysql_query($sql,$this->connectMysql());
            $arrMax = mysql_fetch_assoc($consulta); 
            return $arrMax['maxId'];
        }
        
        public function actualizarMovimientoHardware($idMov,$infoCambio)
        {
            $infoSucAnte = $this->sucursalModel->traerSucursalId($infoCambio['idSucursalAnterior']);
            $infoSucNueva = $this->sucursalModel->traerSucursalId($infoCambio['idNuevaSucursal']);
            $infoMov = $this->traerMovimientoId($idMov);
            $observaciones = $infoMov['observaciones'];
            $observacionActualizada = 
            $observaciones.' Bodega Anterior: 
            '.$infoCambio['idSucursalAnterior'].' ' .$infoSucAnte['nombre'].' 
            Nueva: '.$infoCambio['idNuevaSucursal'].' '.$infoSucNueva['nombre'];


            $sql = "update movimientosHardware 
            set observaciones = '".$observacionActualizada."'   
            where idMovimiento = '".$idMov."'   ";
            // die($sql);
            $consulta = mysql_query($sql,$this->connectMysql());
            
        }
        
        public function actualizarRutaArchivoPdfIdMov($idMov,$nombre_archivo)
        {
            $sql = "update movimientosHardware 
            set rutaImagen = '".'archivos/'.$nombre_archivo."'   
            where idMovimiento = '".$idMov."'   ";
            $consulta = mysql_query($sql,$this->connectMysql());
        }
        


}