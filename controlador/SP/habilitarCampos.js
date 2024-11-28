    // Habilitar el campo de "Declaraciones Patrimoniales" si enRangoInicio es verdadero
    if (enRangoInicio>0 ) {
        document.getElementById("dpinicial").disabled = false;
        document.getElementById("submit_dpi").disabled = false;
        dpinicial.classList.add("border-info"); 
    }

    if (esMayo>0) {
        document.getElementById("dpmodificacion").disabled = false;
        document.getElementById("submit_dpm").disabled = false;
        dpmodificacion.classList.add("border-info"); 
    }

    if (enRangoTermino>0) {
        document.getElementById("dptermino").disabled = false;
        document.getElementById("submit_dpc").disabled = false;
        dptermino.classList.add("border-info"); 
    }



    // Habilitar el campo de "Entrega" si enRangoTermino es verdadero
    if (enRangoEntrega > 0) {
        document.getElementById("entrega").disabled = false;
        document.getElementById("submit_entrega").disabled = false;
        entrega.classList.add("border-info"); 

    }

    // Habilitar el campo de "Recepción" si esMayo es verdadero
    if (enRangoRecepcion > 0 ) {
        document.getElementById("recepcion").disabled = false;
        document.getElementById("submit_recepcion").disabled = false;
        recepcion.classList.add("border-info"); 
    }




