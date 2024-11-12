function validarFormulario() {
    // Mostrar/ocultar campos de información personal si es anónimo
    if (document.getElementById("qa").checked) {
        document.getElementById("infoPersonal").style.display = "none";
    } else {
        document.getElementById("infoPersonal").style.display = "block";
    }

    // Mostrar/ocultar campo de especificación de pruebas
    if (document.getElementById("flexRadioDefault1").checked) {
        document.getElementById("espeSection").style.display = "block";
    } else {
        document.getElementById("espeSection").style.display = "none";
    }
}