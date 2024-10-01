<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class MovimientoParteModel extends Conexion
{
    public function traerMovimientosParte($idParte)
    {
        $sql = "select * from movimientosPartes  where idParte = '".$idParte."' "; 
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $movParte = $this->get_table_assoc($consulta ); 
        return $movParte; 
    }

    public function grabarMovDesligardeHardware($infoMov)
    {
        $querySinComillas = addslashes ( $infoMov->query);
            $sql = "insert into movimientosPartes  
                    (idParte,tipoMov,observaciones,idHardware,fecha,idUsuario
                    ,loquehabia,loquequedo,cantidadQueseAfecto,query	
                    )
                    values('".$infoMov->idParte."'
                    ,'".$infoMov->tipoMov."'
                    ,'Se desligo Parte de Hardware con id =".$infoMov->idHardware." '
                    ,'".$infoMov->idHardware."'
                    ,now()
                    ,'".$_SESSION['idUsuario']."' 
                    ,'".$infoMov->loquehabia."'
                    ,'".$infoMov->loquequedo."'
                    ,'".$infoMov->cantidadQueseAfecto."'
                    ,'".$querySinComillas."'
                    )"; 
                    $consulta = mysql_query($sql,$this->connectMysql());
                    // die($sql );
                }


                
                
    public function registrarAgregarParteAHardware($infoMov)
    {
        $querySinComillas = addslashes ( $infoMov->query);
        $sql = "insert into movimientosPartes (idParte,tipoMov,observaciones,idHardware,fecha,idUsuario
        ,loquehabia,loquequedo,query,cantidadQueseAfecto )   
                values(
                    '".$infoMov->idParte."'
                    ,'".$infoMov->tipoMov."'
                    ,'".$infoMov->observaciones."'
                    ,'".$infoMov->idHardware."'
                    ,now()
                    ,'".$infoMov->idUsuario."'
                    ,'".$infoMov->loquehabia."'
                    ,'".$infoMov->loquequedo."'
                    ,'".$querySinComillas ."'
                    ,'".$infoMov->cantidadQueseAfecto."'
                    )"; 
                    // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
    }


    public function registrarAgregarParteAItemInicio($infoMov)
    {
        $querySinComillas = addslashes ( $infoMov->query);
        $sql = "insert into movimientosPartes (idParte,tipoMov,observaciones,idHardware,fecha,idUsuario
        ,loquehabia,loquequedo,query,cantidadQueseAfecto )   
                values(
                    '".$infoMov->idParte."'
                    ,'".$infoMov->tipoMov."'
                    ,'".$infoMov->observaciones."'
                    ,'".$infoMov->idHardware."'
                    ,now()
                    ,'".$infoMov->idUsuario."'
                    ,'".$infoMov->loquehabia."'
                    ,'".$infoMov->loquequedo."'
                    ,'".$querySinComillas ."'
                    ,'".$infoMov->cantidadQueseAfecto."'
                    )"; 
                    // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
    }


}