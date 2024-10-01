function computadoresMenu()
{
    const http=new XMLHttpRequest();
    const url = 'inventarios/inventarios.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("divResultadosInventario").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=computadoresMenu'
    );

}

function hardwareMenu()
{
    const http=new XMLHttpRequest();
    const url = 'hardware/hardware.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("divResultadosInventario").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=hardwareMenu'
    );

}


function partesMenu()
{
    const http=new XMLHttpRequest();
    const url = 'partes/partes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("divResultadosInventario").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=partesMenu'
    );

}
function pedirInfoProducto()
{
    // alert('verificando credenciales');
    const http=new XMLHttpRequest();
    const url = 'inventarios/inventarios.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("modalBodyInventario").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=pedirInfoProducto'
    );

    //  verificarCredencialesJsonAsignarSessionStorage(user,clave);
}


function crearProducto()
{
    var valida =  validaInfoProducto();
    // alert(valida);
    if(valida == '1')
    {
        // alert('validacion correcta');
        var idImportacion = document.getElementById('idImportacion').value;
        var lote = document.getElementById('lote').value;
        var serial = document.getElementById('serial').value;
        var marca = document.getElementById('marca').value;
        var tipoProd = document.getElementById('tipoProd').value;
        var chasis = document.getElementById('chasis').value;
        var modelo = document.getElementById('modelo').value;
        var pulgadas = document.getElementById('pulgadas').value;
        var procesador = document.getElementById('procesador').value;
        var generacion = document.getElementById('generacion').value;
        var ramTipo = document.getElementById('ramTipo').value;
        var ram = document.getElementById('ram').value;
        var discoTipo = document.getElementById('discoTipo').value;
        var capacidadDisco = document.getElementById('capacidadDisco').value;
        var comentarios = document.getElementById('comentarios').value;
  
        const http=new XMLHttpRequest();
        const url = 'inventarios/inventarios.php';
        http.onreadystatechange = function(){
            
                if(this.readyState == 4 && this.status ==200){
                           document.getElementById("modalBodyInventario").innerHTML  = this.responseText;
                    }
                };
                http.open("POST",url);
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.send('opcion=crearProducto'
                    +'&idImportacion='+idImportacion
                    +'&lote='+lote
                    +'&serial='+serial
                    +'&marca='+marca
                    +'&tipoProd='+tipoProd
                    +'&chasis='+chasis
                    +'&modelo='+modelo
                    +'&pulgadas='+pulgadas
                    +'&procesador='+procesador
                    +'&generacion='+generacion
                    +'&ramTipo='+ramTipo
                    +'&ram='+ram
                    +'&discoTipo='+discoTipo
                    +'&capacidadDisco='+capacidadDisco
                    +'&comentarios='+comentarios
           
                );
                
    }
}

function  validaInfoProducto()
{
    if( document.getElementById('idImportacion').value == ''){
        alert('Por favor digitar idImportacion');
        document.getElementById('idImportacion').focus();
        return 0;
    }
    if( document.getElementById('lote').value == ''){
        alert('Por favor digitar lote');
        document.getElementById('lote').focus();
        return 0;
    }
    if( document.getElementById('serial').value == ''){
        alert('Por favor digitar serial ');
        document.getElementById('serial').focus();
        return 0;
    }
    if( document.getElementById('marca').value == ''){
        alert('Por favor digitar marca ');
        document.getElementById('marca').focus();
        return 0;
    }
    if( document.getElementById('tipoProd').value == ''){
        alert('Por favor digitar tipoProd ');
        document.getElementById('tipoProd').focus();
        return 0;
    }
    if( document.getElementById('chasis').value == ''){
        alert('Por digitar chasis');
        document.getElementById('chasis').focus();
        return 0;
    }
    if( document.getElementById('modelo').value == ''){
        alert('Por digitar modelo');
        document.getElementById('modelo').focus();
        return 0;
    }
    if( document.getElementById('pulgadas').value == ''){
        alert('Por digitar pulgadas');
        document.getElementById('pulgadas').focus();
        return 0;
    }
    if( document.getElementById('procesador').value == ''){
        alert('Por digitar procesador');
        document.getElementById('procesador').focus();
        return 0;
    }
    if( document.getElementById('generacion').value == ''){
        alert('Por digitar generacion');
        document.getElementById('generacion').focus();
        return 0;
    }
    if( document.getElementById('ramTipo').value == ''){
        alert('Por digitar ramTipo');
        document.getElementById('ramTipo').focus();
        return 0;
    }
    if( document.getElementById('ram').value == ''){
        alert('Por digitar ram');
        document.getElementById('ram').focus();
        return 0;
    }
    if( document.getElementById('discoTipo').value == ''){
        alert('Por digitar discoTipo');
        document.getElementById('discoTipo').focus();
        return 0;
    }
    if( document.getElementById('capacidadDisco').value == ''){
        alert('Por digitar capacidadDisco');
        document.getElementById('capacidadDisco').focus();
        return 0;
    }
    if( document.getElementById('comentarios').value == ''){
        alert('Por digitar comentarios');
        document.getElementById('comentarios').focus();
        return 0;
    }

    return 1;
}



function verProducto(id)
{
        const http=new XMLHttpRequest();
        const url = 'inventarios/inventarios.php';
        http.onreadystatechange = function(){
                if(this.readyState == 4 && this.status ==200){
                           document.getElementById("modalBodyInventarioMostrar").innerHTML  = this.responseText;
                    }
                };
                http.open("POST",url);
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.send('opcion=verProducto'
                    +'&id='+id
                );
}