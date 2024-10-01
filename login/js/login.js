function verifiqueCredeciales123()
{
    var user = document.getElementById("txtUsuario").value;
    var clave = document.getElementById("txtClave").value;
    const http=new XMLHttpRequest();
    const url = './index.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
           document.getElementById("div_principal").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=verificarCredenciales'
    + "&user="+user
    + "&clave="+clave
    );

     verificarCredencialesJsonAsignarSessionStorage(user,clave);
}

function verificarCredencialesJsonAsignarSessionStorage(user,clave)
{
    //  alert(user+ '--'+ clave);
    
    const http=new XMLHttpRequest();
    const url = './index.php';
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status ==200){
            var  resp = JSON.parse(this.responseText); 
            if(resp.valida == 1)
            {    
                // alert('respuesta: '+ resp.valida + 'usuario '+ resp.datos.login+ ' '+resp.datos.id_usuario+ ' '+resp.datos.nivel);
                sessionStorage.id_usuario = resp.datos.id_usuario;
                sessionStorage.usuario = resp.datos.login;
                sessionStorage.nivel = resp.datos.nivel;
                menuPrincipal();
            }
            else{
                alert('Usuario o Clave incorrectos '); 
            }
        }
    };
    
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send("opcion=verificarCredencialesRespJson"
    + "&user="+user
    + "&clave="+clave
    );
}


function menuPrincipal(){

    // document.getElementById("imagenInicial").style.display = 'block';

    // document.getElementById("divBotonesPrincipales").style.display = 'none';

    const http=new XMLHttpRequest();

    const url = './index.php';

    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
            // alert('pasa por aqui ');
            var id_usuario = sessionStorage.id_usuario;
            var usuario = sessionStorage.usuario;
            var nivel =  sessionStorage.nivel;
            // alert(nivel);
            document.getElementById("id_usuario").value = id_usuario;
             document.getElementById("usuario").value = usuario;
            document.getElementById("nivel").value = nivel;
            //  console.log(this.responseText);

             //var respuesta = JSON.parse(this.responseText);

            // console.log(respuesta.marca);

				// alert(respuesta[0]+' '+ respuesta[1]);

         //		document.getElementById("tipooperacion").text = respuesta[1];

           document.getElementById("div_principal").innerHTML  = this.responseText;
        //    document.getElementById("div_principal").innerHTML  = 'buenas desde js';

           

        }

    };

    http.open("POST",url);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.send('opcion=menuPrincipal'
    + "&nivel="+ sessionStorage.nivel
    );

}

function salirSistema(){

    const http=new XMLHttpRequest();

    const url = './index.php';

    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){

           document.getElementById("div_principal").innerHTML  = this.responseText;

        }

    };

    http.open("POST",url);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.send('opcion=salirSistema'

    );

}

function usersMenu(){
    const http=new XMLHttpRequest();

    const url = './users/users.php';

    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){

           document.getElementById("div_principal").innerHTML  = this.responseText;

        }

    };

    http.open("POST",url);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.send();
}
