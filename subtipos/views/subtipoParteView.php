<?php
$raiz = dirname(dirname(dirname(__file__)));


class subtipoParteView
{

    public function selectSubtipos($subtipos)
    {
        echo '<option value="">Seleccione...</option>';
        foreach($subtipos as $subtipo)
        {
            echo '<option value = '.$subtipo['id'].'>'.$subtipo['descripcion'].'</option>'; 
        }
    }
}




?>