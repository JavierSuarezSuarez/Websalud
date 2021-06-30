function deleteEspecialist(idfila,idespec,idpac) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function() {
        if(this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            if(res.deleted == true) {
                var row = document.getElementById(idfila);
                row.parentNode.removeChild(row);
            }
        }
    };
    ajax.open("post","delete_espec_js.php",true);
    ajax.setRequestHeader("Content-Type","application/json;charset-UTF-8");
    ajax.send(JSON.stringify({"idpac":idpac,"idespec":idespec}));
}

function checkSubjDesc() {
    var asunto = document.getElementById("as").value;
    var descripcion = document.getElementById("des").value;
    var errorasunto = document.getElementById("errorasunto");
    var errordesc = document.getElementById("errordesc");
    var flag = false;
    if(asunto == undefined || asunto.length < 1 || asunto.length > 32) {
        errorasunto.innerHTML="Error: En el asunto se permiten de 1 a 32 caracteres";
        flag = true;
    } else {
        errorasunto.innerHTML="";
    } 
    
    if(descripcion == undefined || descripcion.length < 12 || descripcion.length > 5000) {
        errordesc.innerHTML="Error: En la descripción debe haber un mínimo de 12 caracteres y máximo 5000";
        flag = true;
    } else {
        errordesc.innerHTML="";
    }
    return ! flag;
}

function updateSearch(id) {
    var timeout = null;
    var txtsearch = document.getElementById("txtsearch").value;
    var tablamod = document.getElementById("tablapac");
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange=function() {
        if(this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            var arr = res.result;
            tablamod.innerHTML = setInnerHTML(arr);
        }
    };
    if(txtsearch.length > 1) {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
           ajax.open("post","showpatientresponse_js.php",true);
           ajax.setRequestHeader("Content-Type","application/json;charset-UTF-8");
           ajax.send(JSON.stringify({"id":id,"txtsearch":txtsearch})); 
        },100);
    }
}

function setInnerHTML(filas) {
    var htmlfirst ="<table id=\"tablapac\">\
                    <tr>\
                       <th class=\"fila_header\">Cuenta</th>\
                       <th class=\"fila_header\">Nombre</th>\
                       <th class=\"fila_header\">Ver Historial</th>\
                       <th class=\"fila_header\">Añadir Anotacion</th>\
                    </tr>";
    var htmlmedium="";
    if (filas.length > 0) {
        for(var filadata of filas) {
            htmlmedium +=  "<tr>\
                                <td class=\"fila_data\">"+ filadata.cuenta + "</td>\
                                <td class=\"fila_data\">"+ filadata.nombre + "</td>\
                                <td class=\"fila_data\"><form action='medichist.php' method=\"POST\">\
	                                                    <input type='submit' value=\"Ver Historial\">\
	                                                    <input type='hidden' name='id' value='"+ filadata.id + "''>\
	                                                    </form></td>\
	                            <td class=\"fila_data\"><form action='addhist.php' method=\"POST\">\
	                                                    <input type='submit' value=\"Añadir Anotacion\">\
	                                                    <input type='hidden' name='iduser' value='"+ filadata.id + "'>\
	                                                    <input type='hidden' name='type' value='2'>\
	                                                    </form></td>\
                            </tr>"; 
        }
    }
    
    var htmllast = "</table>";
    return htmlfirst + htmlmedium + htmllast;
}

