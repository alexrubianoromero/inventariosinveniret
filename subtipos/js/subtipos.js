function buscarSuptiposParaSelect()
{   
    var itipo = document.getElementById('itipo').value;
    const http=new XMLHttpRequest();
    const url = 'subtipos/subtipos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("isubtipo").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=buscarSuptiposParaSelect'
    +'&itipo='+itipo
    );
}

//se crea esta funcion para creacdion de partes
//porque en creacion de partes esta el campovariable
//en las otras partes no esta
function buscarSuptiposParaSelectDesdeCrearParte()
{   
    var itipo = document.getElementById('itipo').value;
    var itipoSelect = document.getElementById('itipo');
    var selected = itipoSelect.options[itipoSelect.selectedIndex].text;
    if(selected == 'Ram')
    {
        document.getElementById("campovariable").innerHTML  = 'Capac/Veloci';
    }
    else{
        document.getElementById("campovariable").innerHTML  = 'Caracteristicas';
        
    }
    const http=new XMLHttpRequest();
    const url = 'subtipos/subtipos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("isubtipo").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=buscarSuptiposParaSelect'
    +'&itipo='+itipo
    );
}
function buscarSuptiposParaSelectDesdeFiltroParte()
{   
    var itipo = document.getElementById('itipo').value;
    var itipoSelect = document.getElementById('itipo');
    var selected = itipoSelect.options[itipoSelect.selectedIndex].text;
    const http=new XMLHttpRequest();
    const url = 'subtipos/subtipos.php';
    http.onreadystatechange = function(){

        if(this.readyState == 4 && this.status ==200){
               document.getElementById("isubtipo").innerHTML  = this.responseText;
        }
    };
    http.open("POST",url);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('opcion=buscarSuptiposParaSelect'
    +'&itipo='+itipo
    );
    fitrarParteTipoParte();
}