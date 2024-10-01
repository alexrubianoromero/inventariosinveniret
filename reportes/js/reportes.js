function formuReporteVentas()
{
    // alert('funcion javascript');
    // var idEmpresaCliente = document.getElementById('idEmpresaCliente').value;
    // var idPrioridad = document.getElementById('idPrioridad').value;
    const http=new XMLHttpRequest();
    const url = 'reportes/reportes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_reportes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=formuReporteVentas'
    // +'&idEmpresaCliente='+idEmpresaCliente
    // +'&idPrioridad='+idPrioridad
    );
}
function generarReporteVentas()
{
    var fechaIn = document.getElementById('fechaIn').value;
    var fechaFin = document.getElementById('fechaFin').value;
    const http=new XMLHttpRequest();
    const url = 'reportes/reportes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_reportes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=generarReporteVentas'
    +'&fechaIn='+fechaIn
    +'&fechaFin='+fechaFin
    );
}
function verReporteFinanciero()
{
    var idEnviarExcel = document.getElementById('idEnviarExcel').value;
    // var fechaFin = document.getElementById('fechaFin').value;
    // alert(idEnviarExcel);
    const http=new XMLHttpRequest();
    const url = 'reportes/reportes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_reportes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=verReporteFinanciero'
    +'&idEnviarExcel='+idEnviarExcel
    // +'&fechaFin='+fechaFin
    );
}
function reporteEstadoEquipo()
{
    // var fechaIn = document.getElementById('fechaIn').value;
    // var fechaFin = document.getElementById('fechaFin').value;
    const http=new XMLHttpRequest();
    const url = 'reportes/reportes.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("div_resultados_reportes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=reporteEstadoEquipo'
    // +'&fechaIn='+fechaIn
    // +'&fechaFin='+fechaFin
    );
}
function traerEquiposFiltradoEstado()
{
    var idEstadoFiltrar = document.getElementById('idEstadoFiltrar').value;
    const http=new XMLHttpRequest();
    const url = 'reportes/reportes.php';
    http.onreadystatechange = function(){
        
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("div_mostrar_equipos_filtrados_estado").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=traerEquiposFiltradoEstado'
    +'&idEstadoFiltrar='+idEstadoFiltrar
    );
}
function reporteItemsAlistados()
{
    // var idEstadoFiltrar = document.getElementById('idEstadoFiltrar').value;
    const http=new XMLHttpRequest();
    const url = 'reportes/reportes.php';
    http.onreadystatechange = function(){
        
        if(this.readyState == 4 && this.status ==200){
            document.getElementById("div_resultados_reportes").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=reporteItemsAlistados'
    // +'&idEstadoFiltrar='+idEstadoFiltrar
    );
}

