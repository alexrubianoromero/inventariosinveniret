function pedirInfoSucursal()
{
    // alert('verificando credenciales');
    const http=new XMLHttpRequest();
    const url = 'sucursales/sucursales.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("modalBodySucursal").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=pedirInfoSucursal'
    );

    //  verificarCredencialesJsonAsignarSessionStorage(user,clave);
}



function crearSucursal()
{
    var valida =  validaInfoSucursal();
    // alert(valida);
    if(valida == '1')
    {
        // alert('validacion correcta');
        var nombreSucursal = document.getElementById('nombreSucursal').value;
        var direccionSucursal = document.getElementById('direccionSucursal').value;
        var ciudad = document.getElementById('ciudad').value;
        // var password = document.getElementById('password').value;
        // var email = document.getElementById('email').value;
        const http=new XMLHttpRequest();
        const url = 'sucursales/sucursales.php';
        http.onreadystatechange = function(){
            
                if(this.readyState == 4 && this.status ==200){
                           document.getElementById("modalBodySucursal").innerHTML  = this.responseText;
                    }
                };
                http.open("POST",url);
                http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                http.send('opcion=crearSucursal'
                    +'&nombreSucursal='+nombreSucursal
                    +'&direccionSucursal='+direccionSucursal
                    +'&ciudad='+ciudad
                );
                
    }
}
function  validaInfoSucursal()
{
    if( document.getElementById('nombreSucursal').value == ''){
        alert('Por favor digitar nombre Sucursal');
        document.getElementById('nombreSucursal').focus();
        return 0;
    }
    if( document.getElementById('direccionSucursal').value == ''){
        alert('Por favor digitar direccion Sucursal');
        document.getElementById('direccionSucursal').focus();
        return 0;
    }
    // if( document.getElementById('password').value == ''){
    //     alert('Por favor digitar password ');
    //     document.getElementById('password').focus();
    //     return 0;
    // }
    // if( document.getElementById('email').value == ''){
    //     alert('Por favor digitar email ');
    //     document.getElementById('email').focus();
    //     return 0;
    // }

    return 1;
}
