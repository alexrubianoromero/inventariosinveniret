<?php

$raiz =dirname(dirname(dirname(__file__)));
//  die('rutamodel '.$raiz);

require_once($raiz.'/conexion/Conexion.php');

class SubtipoParteModel extends Conexion
{

    public function traerSubTipoParteNombre($nombre)
    {
        $sql = "select * from subtipoParte where descripcion = '".$nombre."'  ";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $subTipoParte = mysql_fetch_assoc($consulta);
        return $subTipoParte;
    }
    public function traerIdSubtipoConNombreSubtipo($nombre)
    {
        $sql = "select id from subtipoParte where descripcion = '".$nombre."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrSubtipo = mysql_fetch_assoc($consulta);
        return $arrSubtipo['id'];
    }

    public function existeNombreSubtipo($nombre)
    {
        $sql = "select * from subtipoParte where descripcion = '".$nombre."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $filas = mysql_num_rows($consulta);
        return $filas ;  
    }
    // la idea es que si no existe la parte pues que la cree y ya 
    //para esto debe haber un parametro donde se indique que tipo de parte dede ser creada enb caso que no exista 
    //para ram debe ser 4
    //para disco debe ser 3
    public function traerSubTipoParteNombreRespuestaMejoradaCargues($nombre,$idTipoParte)
    {
        $sql = "select * from subtipoParte where descripcion = '".$nombre."'  ";
        // die($sql); 
        $consulta = mysql_query($sql,$this->connectMysql());
        $filas = mysql_num_rows($consulta); 
        // echo 'filas '.$filas;
        if($filas == 0 ){
            //debe ser creada la parte son el nombre que no se encontro 
            // die('no lo encontro'); 
            $idSubtipoParte = $this->crearSubtipoPArte($nombre,$idTipoParte);
            $subTipoParte = $this->traerSubTipoParte($idSubtipoParte);

        }else{
            // die('si lo encontro'); 
            $subTipoParte = mysql_fetch_assoc($consulta);
        }
        return $subTipoParte;
    }
    
    public function crearSubtipoPArte($nombre,$idTipoParte)
    {
        $sql = "insert into subtipoParte (idParte,Descripcion) values('".$idTipoParte."','".$nombre."')"; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $maxId = $this->traerMaxIdSubtipoPArte(); 
        return $maxId; 
    }
    
    public function traerMaxIdSubtipoPArte()
    {
        $sql = "select max(id) as maxId from subtipoParte ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $arrId = mysql_fetch_assoc($consulta); 
        return $arrId['maxId'];
    }

    
    public function traerSubTipoParte($id)
    {
        $sql = "select * from subtipoParte where id = '".$id."'  ";
        // die($sql);
        $consulta = mysql_query($sql,$this->connectMysql());
        $subTipoParte = $this->get_table_assoc($consulta);
        return $subTipoParte;
    }


    //esta trae todas las subpartes del id parte indicado 
    //por ejemplo ram = 4
    //discos = 3
    public function traerSubTipoParteIdParte($idParte)
    {
        $sql = "select * from subtipoParte where idParte = '".$idParte."'  ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $subTiposParte = $this->get_table_assoc($consulta);
        return $subTiposParte;
    }
    //esta trae los subtipos de acuerdo  a la descripcion de la parte 
    public function traerSubtiposPartesConDescriptParte($decriParte)
    {
        $sql = "select s.id as id ,s.descripcion from subtipoParte s
        inner join tipoparte t on (t.id = s.idparte)
        where t.descripcion = '".$decriParte."'
        ";
        $consulta = mysql_query($sql,$this->connectMysql());
        $subTiposParte = $this->get_table_assoc($consulta);
        return $subTiposParte;
    }
    
    public function traerSubtiposHardware()
    {
        $sql = "select s.id,s.descripcion from subtipoParte  s    
        inner join tipoparte t on (t.id = s.idParte)
        where t.hardwareoparte	= 1
        "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $subTiposParte = $this->get_table_assoc($consulta);
        return $subTiposParte;
    }
    public function traerSubtiposParte()
    {
        $sql = "select s.id,s.descripcion from subtipoParte  s    
        inner join tipoparte t on (t.id = s.idParte)
        where t.hardwareoparte	= 2
        "; 
        $consulta = mysql_query($sql,$this->connectMysql());
        $subTiposParte = $this->get_table_assoc($consulta);
        return $subTiposParte;
    }
    
    


}