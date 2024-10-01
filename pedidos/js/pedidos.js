function pedirInfoNuevoPedido()
{
    // alert('funcion javascript');
    // var idCliente = document.getElementById("idCLiente").value; 
    // if(idCliente==-1)
    // {
    //     alert('Debe seleccionar un cliente '); 
    // } 
    // else
    // {
        const http=new XMLHttpRequest();
        const url = 'pedidos/pedidos.php';
        http.onreadystatechange = function(){
            
            if(this.readyState == 4 && this.status ==200){
                document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
            }
        };
        http.open("POST",url);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send('opcion=pedirInfoNuevoPedido'
        );
    // }

}
function pedidosFiltrados()
{
    // alert('funcion javascript');
    var idCLiente = document.getElementById("idCLiente").value; 
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("divResultadosPedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=pedidosFiltrados'
            +'&idCLiente='+idCLiente
    );

}

function buscarSucursal()
{
    var idEmpresa = document.getElementById("idEmpresaCliente").value; 
    alert('Escogio algo '+idEmpresa); 

    // const http=new XMLHttpRequest();
    // const url = 'pedidos/pedidos.php';
    // http.onreadystatechange = function(){

    //     if(this.readyState == 4 && this.status ==200){
    //            document.getElementById("modalBodyPedido").innerHTML  = this.responseText;
    //     }
    // };
    // http.open("POST",url);
    // http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // http.send('opcion=pedirInfoNuevoPedido'
    // );


}

function continuarAItemsPedido()
{
    // alert('funcion javascript');
    var idEmpresaCliente = document.getElementById('idEmpresaCliente').value;
    if(idEmpresaCliente == '-1')
    {
        alert('Por favor escoja un cliente ')
    }else{

        
        // var idPrioridad = document.getElementById('idPrioridad').value;
        const http=new XMLHttpRequest();
        const url = 'pedidos/pedidos.php';
        http.onreadystatechange = function(){
            
            if(this.readyState == 4 && this.status ==200){
                document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
            }
        };
        http.open("POST",url);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send('opcion=continuarAItemsPedido'
        +'&idEmpresaCliente='+idEmpresaCliente
        // +'&idPrioridad='+idPrioridad
        );
    }

}

function llamarSiguientePantallaPedido()
{
    var idPedidoActualizar = document.getElementById('idPedidoActualizar').value;
    siguientePantallaPedido(idPedidoActualizar);
}
function siguientePantallaPedido(idPedido)
{
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=siguientePantallaPedido'
    +'&idPedido='+idPedido
    );

}


function actulizarWoPedido(idPedido)
{
    var valor ;
    if(document.getElementById('checkwo').checked)
    {
        valor = 1;
    }
    else{
        valor = 0;
    }
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=actualizarWoPedido'
    +'&idPedido='+idPedido
    +'&valor='+valor
    );
    siguientePantallaPedido(idPedido);
}

function actulizarRPedido(idPedido)
{
    var valor ;
    if(document.getElementById('checkr').checked)
    {
        valor = 1;
    }
    else{
        valor = 0;
    }
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=actualizarRPedido'
    +'&idPedido='+idPedido
    +'&valor='+valor
    );
    siguientePantallaPedido(idPedido);
}

function actulizarIPedido(idPedido)
{
    var valor ;
    if(document.getElementById('checki').checked)
    {
        valor = 1;
    }
    else{
        valor = 0;
    }
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=actulizarIPedido'
    +'&idPedido='+idPedido
    +'&valor='+valor
    );
    siguientePantallaPedido(idPedido);
}



function formuAsignarItemPedidoATecnico(idItemPedido)
{
        const http=new XMLHttpRequest();
        const url = 'pedidos/pedidos.php';
        http.onreadystatechange = function(){

            if(this.readyState == 4 && this.status ==200){
                document.getElementById("modalBodyPedidoAsignartecnico").innerHTML  = this.responseText;
            }
        };
        http.open("POST",url);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send('opcion=formuAsignarItemPedidoATecnico'
        +'&idItemPedido='+idItemPedido
        );
//    }

}


function realizarAsignacionTecnicoAItem(idItemPedido)
{
    //  alert(' idItem '+ idItemPedido);
    var valida = validarInfoTecnico();
    if(valida==1)
    {
        var idPrioridad = document.getElementById('idPrioridad').value;
        var idTecnico = document.getElementById('idTecnico').value;
        const http=new XMLHttpRequest();
        const url = 'pedidos/pedidos.php';
        http.onreadystatechange = function(){

            if(this.readyState == 4 && this.status ==200){
                respu = JSON.parse(this.responseText);
                // alert(respu);
                idPedido = respu;
                document.getElementById("modalBodyPedidoAsignartecnico").innerHTML  = this.responseText;
                //aqui deberia devolver el numero del pedido para enviarserlo
                //a  la funcion siguientePantallaPedido
            }
        };
        http.open("POST",url);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send('opcion=realizarAsignacionTecnicoAItem'
        +'&idItemPedido='+idItemPedido
        +'&idPrioridad='+idPrioridad
        +'&idTecnico='+idTecnico
        );
    
        setTimeout(() => {
            siguientePantallaPedido(idPedido);
        }, 500);
   }
}

function validarInfoTecnico()
{
    if( document.getElementById('idPrioridad').value == ''){
        alert('Por escoger urgencia');
        document.getElementById('idPrioridad').focus();
        return 0;
    }
    if( document.getElementById('idTecnico').value == ''){
        alert('Por escoger Tecnico');
        document.getElementById('idTecnico').focus();
        return 0;
    }
    return 1;
}

function mostrarTipoItem()
{
    // alert('cambio de opcion ');
    var tipoItem = document.getElementById('tipoItem').value;
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            document.getElementById("divTipoItemPedido").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=mostrarTipoItem'
    +'&tipoItem='+tipoItem
    );
}

function actualizarPedido(idPedido)
{
    var comentarios = document.getElementById('comentarios').value;
    var porcenretefuente = document.getElementById('porcenretefuente').value;
    var porcenreteica = document.getElementById('porcenreteica').value;
    // alert(comentarios);
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            document.getElementById("modalBodyPedidoActualizar").innerHTML  = this.responseText;
            document.getElementById("idPedidoActualizar").value= idPedido;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=actualizarPedido'
    +'&idPedido='+idPedido
    +'&comentarios='+comentarios
    +'&porcenretefuente='+porcenretefuente
    +'&porcenreteica='+porcenreteica
    );
}
function verPagosPedido(idPedido)
{
    // var comentarios = document.getElementById('comentarios').value;
    // var porcenretefuente = document.getElementById('porcenretefuente').value;
    // var porcenreteica = document.getElementById('porcenreteica').value;
    // alert(comentarios);
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
            // document.getElementById("idPedidoActualizar").value= idPedido;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=verPagosPedido'
    +'&idPedido='+idPedido
    // +'&comentarios='+comentarios
    // +'&porcenretefuente='+porcenretefuente
    // +'&porcenreteica='+porcenreteica
    );
}
function aplicarPagosPedido(idPago)
{
     var fecha = document.getElementById('date_'+idPago).value;
     var obse = document.getElementById('obse_'+idPago).value;
     var valor = document.getElementById('valor_'+idPago).value;
    //  alert(fecha + ' '+ obse+ ' '+valor);

    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            document.getElementById("div_general_pedidos").innerHTML  = this.responseText;
            // document.getElementById("idPedidoActualizar").value= idPedido;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=aplicarPagosPedido'
    +'&idPago='+idPago
    +'&fecha='+fecha
    +'&obse='+obse
    +'&valor='+valor
    );
}


function pedidosConItemsIniciopendientes()
{
    
    // var comentarios = document.getElementById('comentarios').value;
    // var porcenretefuente = document.getElementById('porcenretefuente').value;
    // var porcenreteica = document.getElementById('porcenreteica').value;
    // alert(comentarios);
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            document.getElementById("divResultadosPedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=pedidosConItemsIniciopendientes'
    // +'&idPedido='+idPedido
    // +'&comentarios='+comentarios
    // +'&porcenretefuente='+porcenretefuente
    // +'&porcenreteica='+porcenreteica
    );
}

function pedidosPorCompletar()
{
    
    // var comentarios = document.getElementById('comentarios').value;
    // var porcenretefuente = document.getElementById('porcenretefuente').value;
    // var porcenreteica = document.getElementById('porcenreteica').value;
    // alert(comentarios);
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            document.getElementById("divResultadosPedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=pedidosPorCompletar'
    // +'&idPedido='+idPedido
    // +'&comentarios='+comentarios
    // +'&porcenretefuente='+porcenretefuente
    // +'&porcenreteica='+porcenreteica
    );
}
function itemsCompletadosHistorial()
{
    
    // var comentarios = document.getElementById('comentarios').value;
    // var porcenretefuente = document.getElementById('porcenretefuente').value;
    // var porcenreteica = document.getElementById('porcenreteica').value;
    // alert(comentarios);
    const http=new XMLHttpRequest();
    const url = 'pedidos/pedidos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            document.getElementById("divResultadosPedidos").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=itemsCompletadosHistorial'
    // +'&idPedido='+idPedido
    // +'&comentarios='+comentarios
    // +'&porcenretefuente='+porcenretefuente
    // +'&porcenreteica='+porcenreteica
    );
}


function verificarSiEsCambioBodega()
{
    // alert('cambio de opcion ');
    var idEstadoInicio = document.getElementById('idEstadoInicio').value;
    if(idEstadoInicio==3)
    {
        // alert('cambio de bodega')
        const http=new XMLHttpRequest();
        const url = 'sucursales/sucursales.php';
        http.onreadystatechange = function(){
            
            if(this.readyState == 4 && this.status ==200){
                // document.getElementById("div_escoger_bodega").innerHTML  = this.responseText;
                document.getElementById("div_mostrar_opciones_sucursal").innerHTML  = this.responseText;
            }
        };
        http.open("POST",url);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send('opcion=mostrarSelectSucursales'
        // +'&tipoItem='+tipoItem
        );
    }else{
        document.getElementById("div_mostrar_opciones_sucursal").innerHTML  = '';

    }
}



