function verMovimientosParte(idParte)
{

        const http=new XMLHttpRequest();
        const url = 'movimientos/movimientos.php';
        http.onreadystatechange = function(){
    
            if(this.readyState == 4 && this.status ==200){
                   document.getElementById("modalBodyVerMovimientos").innerHTML  = this.responseText;
            }
        };
        http.open("POST",url);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send('opcion=verMovimientosParte'
                  +'&idParte='+idParte
        );
}