<?php
$raiz = dirname(dirname(dirname(__file__)));
// require_once($raiz.'/hardware/models/HardwareModel.php'); 
// require_once($raiz.'/partes/models/PartesModel.php'); 
// require_once($raiz.'/subtipos/models/SubtipoParteModel.php'); 
// require_once($raiz.'/tipoParte/models/TipoParteModel.php'); 

class movimientosView
{

    public function verMovimientosParte($movimientos)
    {
        //       echo '<pre>';
        // print_r($movimientos); 
        // echo '</pre>';
      
  

            echo '<table class="table">'; 
            echo '<tr>';
            echo '<th>Fecha.</th>';
            echo '<th>Observaciones</th>';
            echo '</tr>';
            foreach($movimientos as $mov)
            {
                echo '<tr>';
                echo '<td>'.$mov['fecha'].'</td>';
                echo '<td>'.$mov['observaciones'].'</td>';
                echo '</tr>';
                
            }
            echo '</table>';
        
        
        // echo 'movimientos '.$idParte; 
    }


}



?>