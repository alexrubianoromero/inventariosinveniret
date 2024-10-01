<?php

// $raiz= $_SERVER['DOCUMENT_ROOT'];
date_default_timezone_set('America/Bogota');
// die($raiz);
$ruta = dirname(dirname(dirname(__FILE__)));
// die('ruta'.$ruta); 
require_once($ruta.'/fpdf/fpdf.php');
require_once($ruta .'/pedidos/models/PedidoModel.php');
require_once($ruta .'/clientes/models/ClienteModel.php');
require_once($ruta .'/pedidos/models/ItemInicioPedidoModel.php');
require_once($ruta .'/tipoParte/models/TipoParteModel.php');
require_once($ruta .'/subtipos/models/SubtipoParteModel.php');
require_once($ruta .'/pedidos/models/EstadoInicioPedidoModel.php');

$pedidoModel = new PedidoModel();
$clienteModel = new ClienteModel();
$itemInicioModel = new ItemInicioPedidoModel();
$tipoParteModel = new TipoParteModel();
$subTipoParteModel = new SubtipoParteModel();
$estadoInicioPedidoModel = new EstadoInicioPedidoModel();

$infoPedido = $pedidoModel->traerPedidoId($_REQUEST['idPedido']); 
$infoCliente = $clienteModel->traerClienteId($infoPedido['idCliente']); 
$itemsPedido = $itemInicioModel->traerItemInicioPedido($_REQUEST['idPedido']);
        //   echo '<pre>';
        //     print_r($infoPedido); 
        //     echo '</pre>';
        //     die('antes de movimiento ');

// require_once($ruta .'/orden/modelo/OrdenesModelo.class.php');
// require_once($ruta .'/inventario_codigos/modelo/CodigosInventarioModelo.php');
// die($ruta);
// require_once($ruta .'/vehiculos/modelo/VehiculosModelo.php');

// $orden = new OrdenesModelo();
// $infoCode = new CodigosInventarioModelo();
// $vehiculo = new VehiculosModelo(); 
// $datoOrden = $orden->traerOrdenId($_REQUEST['idOrden']);
// $datosCarro = $orden->traerDatosCarroConPlaca($datoOrden['placa']);
// $datosCliente = $orden->traerDatosPropietarioConPlaca($datosCarro['propietario']); 
// $datosItems = $orden->traerItemsAsociadosOrdenPorIdOrden($_REQUEST['idOrden']); 



$pdf=new FPDF();

$pdf->AddPage();
    $pdf->Ln(10);

    // $pdf->Image('../../logos/logokaymo.png',15,20,50);

    $pdf->SetFont('Arial','',12);
    // Movernos a la derecha
    // $pdf->Cell(80);
    // T�tulo
    $pdf->Cell(25,10,'FECHA:',0,0,'');
    $pdf->Cell(40,10,$infoPedido['fecha'],0,0,'');
    $pdf->Cell(30);
    $pdf->Cell(25,10,'OC:',0,0,'R');
    $pdf->Cell(40,10,$infoPedido['idPedido'],0,1,'');
    
    
    $pdf->Ln(5);
    // $pdf->SetFont('Arial','',10);
    // $pdf->Cell(80);
    
    $pdf->Cell(25,6,'Cliente:',0,0,'');
    $pdf->Cell(50,6,$infoCliente[0]['nombre'],0,1,'');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(10,6,'Cant.',1,0,'C');
    $pdf->Cell(20,6,'Tipo',1,0,'C');
    $pdf->Cell(16,6,'SubTipo',1,0,'C');
    $pdf->Cell(28,6,'Modelo',1,0,'C');
    $pdf->Cell(11,6,'Pulg',1,0,'C');
    $pdf->Cell(20,6,'Procesad',1,0,'C');
    $pdf->Cell(17,6,'Genera',1,0,'C');
    $pdf->Cell(15,6,'Ram',1,0,'C');
    $pdf->Cell(15,6,'Disco',1,0,'C');
    $pdf->Cell(16,6,'Estado',1,0,'C');
    $pdf->Cell(16,6,'Total',1,1,'C');
    // $pdf->Cell(16,6,'Total',1,0,'');
    $pdf->SetFont('Arial','',8);
    
    $subtotal = 0;        
    foreach($itemsPedido as $item)
    {
        $infoparte = $tipoParteModel->traerTipoParteConId($item['tipo']);
        $infoSubtipo = $subTipoParteModel->traerSubTipoParte($item['subtipo']);
        $infoEstado = $estadoInicioPedidoModel->traerEstadosInicioPedidoId($item['estado']);
        if($item['tipoItem']== 1)
        {
            $pdf->Cell(10,6,$item['cantidad'],1,0,'C');
            $pdf->Cell(20,6,$infoparte[0]['descripcion'],1,0,'');
            $pdf->Cell(16,6,$infoSubtipo[0]['descripcion'],1,0,'');
            $pdf->Cell(28,6,$item['modelo'],1,0,'C');
            $pdf->Cell(11,6,$item['pulgadas'],1,0,'C');
            $pdf->Cell(20,6,$item['procesador'],1,0,'C');
            $pdf->Cell(17,6,$item['generacion'],1,0,'C');
            $pdf->Cell(15,6,$item['ram'].'-'.$item['capacidadRam'],1,0,'');
            $pdf->Cell(15,6,substr($item['disco'],0,2).'-'.$item['capacidadDisco'],1,0,'');
            $pdf->Cell(16,6,$infoEstado['descripcion'],1,0,'C');
            $pdf->Cell(16,6,number_format($item['total'],0,",","."),1,1,'R');
            
        }
        
        if($item['tipoItem']== 2)
        {
            $pdf->Cell(10,6,$item['cantidad'],1,0,'C');
            $pdf->Cell(20,6,$infoparte[0]['descripcion'],1,0,'');
            $pdf->Cell(16,6,$infoSubtipo[0]['descripcion'],1,0,'');
            
            $pdf->Cell(106,6,$item['observaciones'],1,0,'C');
            
            $pdf->Cell(16,6,$infoEstado['descripcion'],1,0,'C');
            $pdf->Cell(16,6,number_format($item['total'],0,",","."),1,1,'R');
        }    
        $subtotal = $subtotal + $item['total']; 

    }
    $vertical =  $pdf->GetY();
    $valorR = 0; 
    if($infoPedido['r']==1)
    { $valorR = ($subtotal *  $infoPedido['porcenretefuente'])/100;  }
    $valorI = 0; 
    if($infoPedido['i']==1)
    { $valorI = ($subtotal *  $infoPedido['porcenreteica'])/100;  }
   
     $granTotal = $subtotal + $valorR + $valorI;  


    $pdf->Ln(5);
    $pdf->MultiCell(150,6,$infoPedido['observaciones'],0,'J','');
    $pdf->SetY($vertical+5,'');
    $pdf->Cell(152);
    $pdf->Cell(16,6,'Subtotal: ',1,0,'C');
    $pdf->Cell(16,6,number_format($subtotal,0,",","."),1,1,'R');
    $pdf->Cell(152);
    $pdf->Cell(16,6,'ValorR: ',1,0,'C');
    $pdf->Cell(16,6,number_format($valorR,0,",","."),1,1,'R');
    $pdf->Cell(152);
    $pdf->Cell(16,6,'ValorI: ',1,0,'C');
    $pdf->Cell(16,6,number_format($valorI,0,",","."),1,1,'R');
    $pdf->Cell(152);
    $pdf->Cell(16,6,'Total: ',1,0,'C');
    $pdf->Cell(16,6,number_format($granTotal,0,",","."),1,1,'R');

    $pdf->Output();
    
    ?>