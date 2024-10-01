<?php

class vista
{
    public function get_table_assoc($datos)
    {
                     $arreglo_assoc='';
                        $i=0;	
                        while($row = mysql_fetch_assoc($datos)){		
                            $arreglo_assoc[$i] = $row;
                            $i++;
                        }
                    return $arreglo_assoc;
    }
    public function draw_table($datos)
                {
                
                            echo '<table border = "1" class="table">';
                                $titulos = array_keys($datos[0]);
                                    echo '<tr>';
                                    foreach   ($titulos as $d ) { 
                                        echo "<td>".strtoupper($d)."</TD>"; 
                                    } 
                                    
                                    
                                    echo '</tr>';
                                    foreach   ($datos as $d ) {   
                                        echo '<tr>';
                                        foreach   ($d as $r ) {
                                        echo "<td>$r</TD>";
                                        }
                                        echo '</tr>';		
                                    }
                                    echo '</table>';

                
                }

    public function colocarSelect($valores)
    {
        echo '<option value="-1">Seleccione...</option>';
        
            foreach($valores as $valor)
            {
                echo ' <option value="'.$valor['id'].'">'.$valor['descripcion'].'</option>';
            }
    
    }            
    public function colocarSelectCampo($valores)
    {
        echo '<option value="-1">Sel.</option>';
        
            foreach($valores as $valor)
            {
                echo ' <option value="'.$valor['id'].'">'.$valor['id'].'</option>';
            }
    
    }  
    /**
     * esta opsion es la misma de colocarSelectCampo pero el valor por defecto es espacio en blanco 
     *  */         
    public function colocarSelectCampoPorDefectoBlanco($valores)
    {
        echo '<option value="">Sel.</option>';
        
            foreach($valores as $valor)
            {
                echo ' <option value="'.$valor['id'].'">'.$valor['id'].'</option>';
            }
    
    }           
    public function colocarSelectCampoDescripcion($valores)
    {
        echo '<option value="-1">Sel.</option>';
        
            foreach($valores as $valor)
            {
                echo ' <option value="'.$valor['descripcion'].'">'.$valor['descripcion'].'</option>';
            }
    
    }           
    public function colocarSelectArreglo($valores)
    {
        echo '<option value="-1">Sel.</option>';
        
            foreach($valores as $valor)
            {
                    echo ' <option value="'.$valor['id'].'">'.$valor['descripcion'].'</option>';
            }
    
    }           
    public function colocarSelecProcesadores($valores)
    {
        echo '<option value="-1">Sel.</option>';
        
            foreach($valores as $valor)
            {
                    echo ' <option value="'.$valor['procesador'].'">'.$valor['procesador'].'</option>';
            }
    
    }           
    public function colocarSelecGeneraciones($valores)
    {
        echo '<option value="-1">Sel.</option>';
        
            foreach($valores as $valor)
            {
                    echo ' <option value="'.$valor['generacion'].'">'.$valor['generacion'].'</option>';
            }
    
    }           
   
    public function colocarSelectCampoConOpcionSeleccionada($valores,$condicion)
    {
        echo '<option value="-1">Sel.</option>';
        
            foreach($valores as $valor)
            {
                if($valor['id'] == $condicion){
                    echo ' <option selected value="'.$valor['id'].'">'.$valor['descripcion'].'</option>';
                }
                else{
                    echo ' <option value="'.$valor['id'].'">'.$valor['descripcion'].'</option>';
                }
            }
        }

    public function colocarSelectCampoConOpcionSeleccionadaPorNombre($valores,$condicion)
    {
        echo '<option value="-1">Sel.</option>';
        
            foreach($valores as $valor)
            {
                if($valor['descripcion'] == $condicion){
                    echo ' <option selected value="'.$valor['descripcion'].'">'.$valor['descripcion'].'</option>';
                }
                else{
                    echo ' <option value="'.$valor['descripcion'].'">'.$valor['descripcion'].'</option>';
                }
            }
    
    }           
    
    public function printR($arreglo)
    {
        echo '<pre>';
        print_r($arreglo); 
        echo '</pre>';
        die(); 
    }

}

?>