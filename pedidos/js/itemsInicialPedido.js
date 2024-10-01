function agregarItemInicialPedido(tipoItem)
{
    var valida = validaInfoNuevoItem();
    if(valida == 1)
    {
    var idPedido = document.getElementById('idPedido').value;
    var icantidad = document.getElementById('icantidad').value;
    var itipo = document.getElementById('itipo').value;
    var imodelo = document.getElementById('imodelo').value;
    var ipulgadas = document.getElementById('ipulgadas').value;
    var iprocesador = document.getElementById('iprocesador').value;
    var igeneracion = document.getElementById('igeneracion').value;
    var iram = document.getElementById('iram').value;
    var icapacidadram = document.getElementById('icapacidadram').value;
    var idisco = document.getElementById('idisco').value;
    var icapacidaddisco = document.getElementById('icapacidaddisco').value;
    var idEstadoInicio = document.getElementById('idEstadoInicio').value;
    if(idEstadoInicio==3){
        var idNuevaSucursal = document.getElementById('idNuevaSucursal').value;
    }else{
        var idNuevaSucursal =0;
    }
    var iprecio = document.getElementById('iprecio').value;
    var iobservaciones = document.getElementById('iobservaciones').value;
    var tipoItem = document.getElementById('tipoItem').value;
    var isubtipo = document.getElementById('isubtipo').value;

    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_items_solicitados_pedido").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=agregarItemInicialPedido'
    +'&idPedido='+idPedido
    +'&icantidad='+icantidad
    +'&itipo='+itipo
    +'&imodelo='+imodelo
    +'&ipulgadas='+ipulgadas
    +'&iprocesador='+iprocesador
    +'&igeneracion='+igeneracion
    +'&iram='+iram
    +'&icapacidadram='+icapacidadram
    +'&idisco='+idisco
    +'&icapacidaddisco='+icapacidaddisco
    +'&idEstadoInicio='+idEstadoInicio
    +'&idNuevaSucursal='+idNuevaSucursal
    +'&iprecio='+iprecio
    +'&iobservaciones='+iobservaciones
    +'&tipoItem='+tipoItem
    +'&isubtipo='+isubtipo
    );
    limpiarCampos();
    } //fin de valida
}

function agregarItemInicialPedidoParte(tipoItem)
{
    var valida = validaInfoNuevoItemParte();
    if(valida == 1)
    {
    var idPedido = document.getElementById('idPedido').value;
    var icantidad = document.getElementById('icantidad').value;
    var itipo = document.getElementById('itipo').value;
    var idEstadoInicio = document.getElementById('idEstadoInicio').value;
    var iprecio = document.getElementById('iprecio').value;
    var iobservaciones = document.getElementById('iobservaciones').value;
    var tipoItem = document.getElementById('tipoItem').value;
    var isubtipo = document.getElementById('isubtipo').value;
    cambioBodega = 3; 
    if(idEstadoInicio== cambioBodega){
        var idNuevaSucursal = document.getElementById('idNuevaSucursal').value;
    }else{
        var idNuevaSucursal = 0;
    }

    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_items_solicitados_pedido").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=agregarItemInicialPedido'
    +'&idPedido='+idPedido
    +'&icantidad='+icantidad
    +'&itipo='+itipo
    +'&idEstadoInicio='+idEstadoInicio
    +'&iprecio='+iprecio
    +'&iobservaciones='+iobservaciones
    +'&tipoItem='+tipoItem
    +'&isubtipo='+isubtipo
    +'&idNuevaSucursal='+idNuevaSucursal
    );
    limpiarCampos();
    } //fin de valida
}

function limpiarCampos()
{
    document.getElementById('icantidad').value = '';
    document.getElementById('itipo').value = '';
    document.getElementById('imodelo').value = '';
    document.getElementById('ipulgadas').value = '';
    document.getElementById('iprocesador').value= '';
    document.getElementById('igeneracion').value= '';
    document.getElementById('iram').value= '';
    document.getElementById('idisco').value= '';
    document.getElementById('idEstadoInicio').value= '';
    document.getElementById('iprecio').value= '';


}

function validaInfoNuevoItem()
{
    
    if( document.getElementById('icantidad').value == ''){
        alert('Por favor digitar cantidad');
        document.getElementById('icantidad').focus();
        return 0;
    }
    if( document.getElementById('itipo').value == ''){
        alert('Por favor digitar itipo');
        document.getElementById('itipo').focus();
        return 0;
    }
    // if( document.getElementById('imodelo').value == ''){
    //     alert('Por favor digitar imodelo');
    //     document.getElementById('imodelo').focus();
    //     return 0;
    // }
    // if( document.getElementById('ipulgadas').value == ''){
    //     alert('Por favor digitar ipulgadas');
    //     document.getElementById('ipulgadas').focus();
    //     return 0;
    // }
    // if( document.getElementById('iprocesador').value == ''){
    //     alert('Por favor digitar iprocesador');
    //     document.getElementById('iprocesador').focus();
    //     return 0;
    // }
    // if( document.getElementById('igeneracion').value == ''){
    //     alert('Por favor digitar igeneracion');
    //     document.getElementById('igeneracion').focus();
    //     return 0;
    // }
    // if( document.getElementById('iram').value == ''){
    //     alert('Por favor digitar iram');
    //     document.getElementById('iram').focus();
    //     return 0;
    // }
    // if( document.getElementById('idisco').value == ''){
    //     alert('Por favor digitar idisco');
    //     document.getElementById('idisco').focus();
    //     return 0;
    // }
    if( document.getElementById('idEstadoInicio').value == ''){
        alert('Por favor digitar Estado');
        document.getElementById('idEstadoInicio').focus();
        return 0;
    }
    if( document.getElementById('iprecio').value == ''){
        alert('Por favor digitar iprecio');
        document.getElementById('iprecio').focus();
        return 0;
    }
    if( document.getElementById('iobservaciones').value == ''){
        alert('Por favor digitar observaciones');
        document.getElementById('iobservaciones').focus();
        return 0;
    }
    return 1;
}
function validaInfoNuevoItemParte()
{
    
    if( document.getElementById('icantidad').value == ''){
        alert('Por favor digitar cantidad');
        document.getElementById('icantidad').focus();
        return 0;
    }
    if( document.getElementById('itipo').value == ''){
        alert('Por favor digitar itipo');
        document.getElementById('itipo').focus();
        return 0;
    }
  
    if( document.getElementById('idEstadoInicio').value == ''){
        alert('Por favor digitar idEstadoInicio');
        document.getElementById('idEstadoInicio').focus();
        return 0;
    }
    if( document.getElementById('iprecio').value == ''){
        alert('Por favor digitar iprecio');
        document.getElementById('iprecio').focus();
        return 0;
    }
    if( document.getElementById('iobservaciones').value == ''){
        alert('Por favor digitar observaciones');
        document.getElementById('iobservaciones').focus();
        return 0;
    }
    return 1;
}


function eliminarItemInicialPedido(id)
{
    // alert('funcion javascript');
    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_items_solicitados_pedido").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=eliminarItemInicialPedido'
    +'&id='+id
    );

}

function verItemsAsignadosTecnico(id)
{
    // alert('funcion javascript');
    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_tableros_tecnicos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=verItemsAsignadosTecnico'
    +'&id='+id
    );

}

function mostrarItemsInicioPedidoTecnico(idPedido,idTecnico)
{
    //  alert('funcion javascript');
    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("modalBodyPedidoVerItemTecnico").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=mostrarItemsInicioPedidoTecnico'
    +'&idPedido='+idPedido
    +'&idTecnico='+idTecnico
    );

}
//esta se crea para mejorar la parte visual cuando se quieren ver los items
//que tiene un tecnico de forma mas horizontal en un div 
//no en una ventana modal y de esta manera que se a mas facil ver la info
function mostrarItemsInicioPedidoTecnicoNuevo(idPedido,idTecnico)
{
    //  alert('funcion javascript');
    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("divMostrarItemsPedidoTecnico").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=mostrarItemsInicioPedidoTecnicoNuevo'
    +'&idPedido='+idPedido
    +'&idTecnico='+idTecnico
    );

}
function limpiarDivItems()
{
    document.getElementById("divMostrarItemsPedidoTecnico").innerHTML  = '';
}
function actulizarEstadoProcesoItem(idItem)
{
    //  alert('funcion javascript');
    var idEstadoProcesoItem = document.getElementById('idEstadoProcesoItem').value;
    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            //    document.getElementById("divMostrarItemsPedidoTecnico").innerHTML  = '';
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=actulizarEstadoProcesoItem'
    +'&idItem='+idItem
    +'&idEstadoProcesoItem='+idEstadoProcesoItem
    );

}
function eliminarHardwareAsociadoItem(idHardware,idAsociado,idItemInicio)
{
    //  alert(idHardware+' '+idAsociado);
    // var idEstadoProcesoItem = document.getElementById('idEstadoProcesoItem').value;
    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            //    document.getElementById("divMostrarItemsPedidoTecnico").innerHTML  = '';
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=eliminarHardwareAsociadoItem'
    +'&idHardware='+idHardware
    +'&idAsociado='+idAsociado
    );

    setTimeout(() => {
        modificarItemInicioPedido(idItemInicio);
    }, 500);

}
function modificarItemInicioPedido(idItem)
{
    //  alert('funcion javascript');
    // var idEstadoProcesoItem = document.getElementById('idEstadoProcesoItem').value;
    const http=new XMLHttpRequest();
    const url = 'pedidos/itemInicioPedido.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
                document.getElementById("modalBodyModificarItem").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=modificarItemInicioPedido'
    +'&idItem='+idItem
    // +'&idEstadoProcesoItem='+idEstadoProcesoItem
    );

}