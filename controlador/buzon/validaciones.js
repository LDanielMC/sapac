var expreNomyApe =/^[a-zA-ZÀ-ÿ\s]{1,50}$/;
var expreDir =/^[a-zA-Z0-9À-ÿ\s]{1,40}$/;
var expreTel =/^\d{7,14}$/;


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

    //validaciones del llenado
    if (document.frm.rp.value.trim().length <= 2 || !expreNomyApe.test(document.frm.rp.value)) {
        document.getElementById("rp").focus();
        nom.style.display="";
        return false;
    }
    nom.style.display="none";

    if (document.frm.telefono.value.trim().length <= 10 || !expreTel.test(document.frm.telefono.value)) {
        document.getElementById("telefono").focus();
        tel.style.display="";
        return false;
    }
    tel.style.display="none";

    btn.style.display="";

    frm.submit();
}