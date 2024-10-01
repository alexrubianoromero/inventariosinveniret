<?php
    // $ruta = 'archivos/hoja.pdf';
    // echo '<pre>'; 
    // print_r($_REQUEST);
    // echo '</pre>';
    // die(); 
    header("Content-type: application/pdf");
    readfile($_REQUEST['ruta']);

?>