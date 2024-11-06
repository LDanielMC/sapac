
function validarContrasenas() {
    var contrasena = document.getElementById("contrasena").value;
    var confirmarContrasena = document.getElementById("confirmarContrasena").value;

    if (contrasena !== confirmarContrasena) {
        alert("Las contraseñas no coinciden. Por favor, verifique.");
        return false;
    }
    return true;
}