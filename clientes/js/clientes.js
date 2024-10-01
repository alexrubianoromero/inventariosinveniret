function listarClientes()
{
    //  alert('funcion javascript');
    const http=new XMLHttpRequest();
    const url = 'clientes/clientes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_clientes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=listarClientes'
    );
}
function listarClienteFiltrado()
{
    //  alert('funcion javascript');
    var idCliente = document.getElementById('idCliente').value;
    const http=new XMLHttpRequest();
    const url = 'clientes/clientes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_clientes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=listarClienteFiltrado'
            +'&idCliente='+idCliente

    );
}
function listarClienteFiltradoDesdeClientes()
{
    //  alert('funcion javascript');
    var idCliente = document.getElementById('idCliente').value;
    const http=new XMLHttpRequest();
    const url = 'clientes/clientes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_clientes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=listarClienteFiltradoDesdeClientes'
            +'&idCliente='+idCliente

    );
}


function formuNuevoCliente()
{
    //  alert('funcion javascript');
    const http=new XMLHttpRequest();
    const url = 'clientes/clientes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("modalBodyNuevoCliente").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=formuNuevoCliente'
    );

}

function grabarCliente()
{
    //  alert('funcion javascript');
    var nombre = document.getElementById('nombre').value;
    var nit = document.getElementById('nit').value;
    var telefono = document.getElementById('telefono').value;
    var email = document.getElementById('email').value;
    var direccion = document.getElementById('direccion').value;
    var ciudad = document.getElementById('ciudad').value;
    var idTipoContribuyente = document.getElementById('idTipoContribuyente').value;
    var sede = document.getElementById('sede').value;
    const http=new XMLHttpRequest();
    const url = 'clientes/clientes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("modalBodyNuevoCliente").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=grabarCliente'
    +'&nombre='+nombre
    +'&nit='+nit
    +'&telefono='+telefono
    +'&email='+email
    +'&direccion='+direccion
    +'&ciudad='+ciudad
    +'&idTipoContribuyente='+idTipoContribuyente
    +'&sede='+sede
    );

}





