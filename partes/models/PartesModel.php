<?php
$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);
require_once($raiz.'/conexion/Conexion.php');
require_once($raiz.'/subtipos/models/SubtipoParteModel.php');

class PartesModel extends Conexion
{
    protected $subTipoModel; 

    public function __construct()
    {
        session_start();
        $this->subTipoModel = new SubtipoParteModel();
    }

  
    //esta la cree cuando se suben muchos hardware desde un archivo de excell
    public function grabarParte($idSubTipo,$capacidad)
    {
        $sql = "insert into partes (idSubtipoParte,capacidad,comentarios,idSucursal)
                values('".$idSubTipo."','".$capacidad."','Se asocia a conmputador','".$_SESSION['idSucursal']."') ";
        $consulta = mysql_query($sql,$this->connectMysql());
    }

    public function grabarParteDesdeCargarArchivo($idSubTipo,$capacidad)
    {
        $sql = "insert into partes (idSubtipoParte,capacidad,comentarios)
                values('".$idSubTipo."','".$capacidad."','la ram / disco relacionada en el archivo exxel cargado') ";
        $consulta = mysql_query($sql,$this->connectMysql());
    }

    public function grabarParteGeneral($idSubTipo,$capacidad,$comentario)
    {
        $sql = "insert into partes (idSubtipoParte,capacidad,comentarios)
                values('".$idSubTipo."','".$capacidad."','".$comentario."') ";
        $consulta = mysql_query($sql,$this->connectMysql());
    }

    //esta es para cuando se crean las partes independientes 
    public function grabarParteIndividual($request)
    {
        $sql = "insert into partes (idSubtipoParte,capacidad,comentarios,cantidad,idSucursal,costo)
                values('".$request['isubtipo']."','".$request['capacidad']."'
                ,'Creacion desde Modulo','".$request['cantidad']."','".$_SESSION['idSucursal']."','".$request['costo']."')
        ";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
   
    public function traerParte($id)
    {
        $sql = "select * from partes where id = '".$id."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $parte = $this->get_table_assoc($consulta);
        return $parte;
    }
    
    
    public function traerTodasLasPartes()
    {
        $sql = "select * from partes  where 1=1 and idSucursal = '".$_SESSION['idSucursal']."'  order by id desc";
        $consulta = mysql_query($sql,$this->connectMysql());
        $partes = $this->get_table_assoc($consulta);
        return $partes;
    }
    public function traerPartesFiltroTipoParte($tipoParte)
    {
        $sql = "select * from partes p
        inner join subtipoParte s on (s.id = p.idSubtipoParte)
        inner join tipoparte t on  (t.id = s.idParte)
        where 1=1 
        and p.idSucursal = '".$_SESSION['idSucursal']."'  
        and s.idParte = '".$tipoParte."' 
        order by p.id desc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $partes = $this->get_table_assoc($consulta);
        return $partes;
    }
    public function traerPartesFiltroSubTipoParte($subTipoParte)
    {
        $sql = "select * from partes p
        inner join subtipoParte s on (s.id = p.idSubtipoParte)
        inner join tipoparte t on  (t.id = s.idParte)
        where 1=1 
        and p.idSucursal = '".$_SESSION['idSucursal']."'  
        and p.idSubtipoParte = '".$subTipoParte."'
        order by p.id desc";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $partes = $this->get_table_assoc($consulta);
        return $partes;
    }
    public function traerPartesCaracteristicasParte($tipo,$subtipo,$caracteristicas)
    {
        $sql = "select * from partes p
        inner join subtipoParte s on (s.id = p.idSubtipoParte)
        inner join tipoparte t on  (t.id = s.idParte)
        where 1=1 
        and p.idSucursal = '".$_SESSION['idSucursal']."'";
        if($tipo > -1){
            $sql .= "   and s.idParte = '".$tipo."' ";
        }   
        if($subtipo > -1){
            $sql .= "    and p.idSubtipoParte = '".$subtipo."'";
        }   
        $sql .= "and capacidad like '%".$caracteristicas."%' "; 
        $sql .= " order by p.id desc "; 
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $partes = $this->get_table_assoc($consulta);
        return $partes;
    }

    //trae todas las ram que esten disponibles osea en estado 0 
    public function traerMemoriasDisponibles()
    {
        $sql = "select id from tipoparte where descripcion = 'Ram' ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $ArridTipoParte = mysql_fetch_assoc($consulta);
        $idTipoParteRam = $ArridTipoParte['id'];
        $sql = "select p.id,p.idSubtipoParte,t.descripcion as descriParte, s.descripcion as descriSubParte, p.capacidad ,p.cantidad 
        from  partes p
        inner join subtipoParte s on (s.id = p.idSubtipoParte )
        inner join tipoparte t on (t.id = s.idParte)
        where t.descripcion = 'Ram'    
        and p.idHardware = 0
        and p.idEstadoParte = 0
        and p.idSucursal = '".$_SESSION['idSucursal']."'
        ";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $ram = $this->get_table_assoc($consulta);
        return $ram;  
    }
    public function traerDiscosDisponibles()
    {
        $sql = "select id from tipoparte where descripcion = 'Disco' ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $ArridTipoParte = mysql_fetch_assoc($consulta);
        $idTipoParteDisco = $ArridTipoParte['id'];
        $sql = "select p.id,t.descripcion as descriParte, s.descripcion as descriSubParte, p.capacidad,p.cantidad  
        from  partes p
        inner join subtipoParte s on (s.id = p.idSubtipoParte )
        inner join tipoparte t on (t.id = s.idParte)
        where t.descripcion = 'Disco'    
        and p.idHardware = 0
        and p.idEstadoParte = 0
        and p.idSucursal = '".$_SESSION['idSucursal']."'        
        ";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $discos = $this->get_table_assoc($consulta);
        return $discos;  
    }
    public function traerCargadoresDisponibles()
    {
        $sql = "select id from tipoparte where descripcion = 'Cargador' ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $ArridTipoParte = mysql_fetch_assoc($consulta);
        $idTipoParteDisco = $ArridTipoParte['id'];
        $sql = "select p.id,t.descripcion as descriParte, s.descripcion as descriSubParte, p.capacidad,p.cantidad  
        from  partes p
        inner join subtipoParte s on (s.id = p.idSubtipoParte )
        inner join tipoparte t on (t.id = s.idParte)
        where s.descripcion = 'CARGADOR'    
        and p.idHardware = 0
        and p.idEstadoParte = 0
        ";
        //  die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $cargadores = $this->get_table_assoc($consulta);
        return $cargadores;  
    }
    //aqui busca en la tabla de partes si existe un producto 
    //que tenga el mismo idSubtipo y la misma capacidad 
    //para evitar crear el mismo producto 
    public function traerParteConIdSubtipoyCapacidad($idSubtipo,$capacidad)
    {
        $sql = "select * from partes 
        where idSubtipoParte = '".$idSubtipo."'    
        and capacidad = '".$capacidad."' 
        order by id asc limit 1  "; 
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $filas = mysql_num_rows($consulta); 
        $arrParte = mysql_fetch_assoc($consulta); 
        $respu['filas'] = $filas;
        $respu['info'] = $arrParte; 
        return $respu ; 
    }

    public function traerUltimoIdPartes()
    {
        $sql = "select max(id) as maximo from partes ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrParte = mysql_fetch_assoc($consulta); 
        $maximo = $arrParte['maximo']; 
        return $maximo;
    }

    public function desligarParteDeHardware($idDisco)
    {
        $sql = "update partes set idHardware = 0 where id = '".$idDisco."'  "; 
        $consulta = mysql_query($sql,$this->connectMysql());
    }
    
    // public function asociarHardwareEnTablaPartes($request)
    // {
    //     $sql = "update partes set  idHardware = '".$request['idHardware']."'      where id=  '".$request['idDisco']."'  "; 
    //     $consulta = mysql_query($sql,$this->connectMysql());
    // }
    // public function asociarRamHardwareEnTablaPartes($request)
    // {
    //     $sql = "update partes set  idHardware = '".$request['idHardware']."'      where id=  '".$request['idRam']."'  "; 
    //     $consulta = mysql_query($sql,$this->connectMysql());
    // }
    // public function desligarRamDeHardware($request)
    // {
    //     $sql = "update partes set  idHardware = 0      where id=  '".$request['idRam']."'  "; 
    //     $consulta = mysql_query($sql,$this->connectMysql());
        
    // }
    // public function cambiarEstadodePArte($idParte,$estado)
    // {
        //     $sql = "update partes set estado = '".$estado."'  where idParte = '".$idParte."' ";
        //     $consulta = mysql_query($sql,$this->connectMysql());
        // }
        
        //debemos conocer el tipo de movimiento  para saber si suma o resta 
        //se reciben estos parametros 
        //tipo  movimiento 1 entrada  suma   2 salida resta  
        //id de la parte 
        //si se asocia a un hardware se puede indicar en el movimiento no en esta parte 
        //colocar la parte al hardware 
    public function sumarDescontarPartes($tipoMov,$idParte,$cantidadParaActualizar)
    {
            //colocar un control que no se pueda descontar cuando el saldo quede negativo 
            $infoParte = $this->traerParte($idParte);
        //          echo '<pre>';
        // print_r($infoParte); 
        // echo '</pre>';
        // die();
            $nuevoSaldo = 0;
            $saldoActual = $infoParte[0]['cantidad']; 
            if($tipoMov == 1)
            { // si entra aca es porque es entrada y hay que sumar al inventario  
                // die('entro a 1');
                $nuevoSaldo = $saldoActual + $cantidadParaActualizar; 
            }else{
                // echo '<br>saldoActual '.$saldoActual;
                // echo '<br>cantidadParaActualizar'.$cantidadParaActualizar;
                // echo '<br>nuevoSaldo '.$nuevoSaldo;
                // die();
                $nuevoSaldo = $saldoActual - $cantidadParaActualizar; 
                if($nuevoSaldo < 0){
                    die('Saldo Menor que cero operacion no permitida '); 
                }
            }
            $sql = "update partes set cantidad = '".$nuevoSaldo."'   where id = '".$idParte."'   "; 
            // die($sql ); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $respu['query'] = $sql; 
            $respu['loquehabia'] =  $infoParte[0]['cantidad']; 
            $respu['loquequedo'] =  $nuevoSaldo;
            $respu['cantidadQueseAfecto'] =  $cantidadParaActualizar;
            return $respu; 
    }
        // r es ram
        // d es disco 
        // c es cargador  
        public function asociarParteAHardware($idHardware,$idParte,$numeroRam,$ramODisco,$idSubtipoParte)
        {
            if($ramODisco == 'r'){$arr = ['','idRam1','idRam2','idRam3','idRam4']; }
            if($ramODisco == 'd'){$arr = ['','idDisco1','idDisco2']; }
            if($ramODisco == 'c'){$arr = ['','idCargador']; }
            
            if($ramODisco == 'r' || $ramODisco == 'd'){
                $sql = "update hardware set ".$arr[$numeroRam]." = '".$idSubtipoParte."'  where id = '".$idHardware."'    ";  
            }
            if($ramODisco == 'c'){
                $sql = "update hardware set ".$numeroRam." = '".$idSubtipoParte."'  where id = '".$idHardware."'    ";  
            }
            // die($sql ); 
            $consulta = mysql_query($sql,$this->connectMysql());
        }

        public function traerTodasLasPartesDisponibles()
        {
            $sql = "select * from partes  where idEstadoParte =  0  and idSucursal = '".$_SESSION['idSucursal']."' order by id asc";
            $consulta = mysql_query($sql,$this->connectMysql());
            $partes = $this->get_table_assoc($consulta);
            return $partes;
        }
        public function filtrarBusquedaParteTipoParte($idTipoParte)
        {
            $sql = "select p.* from partes p 
            inner join subtipoParte s on ( s.id = p.idSubtipoParte)
            inner join tipoparte t on (t.id = s.idParte)
            where p.idEstadoParte =  0  
            and  t.id = '".$idTipoParte."'
            and p.idSucursal = '".$_SESSION['idSucursal']."'
            order by id asc";
            // die($sql); 
            $consulta = mysql_query($sql,$this->connectMysql());
            $partes = $this->get_table_assoc($consulta);
            return $partes;

        }
        
   
    
        
    }