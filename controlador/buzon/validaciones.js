function validarFormulario() {
    // Mostrar/ocultar campos de información personal si es anónimo
    if (document.getElementById("qa").checked) {
        document.getElementById("infoPersonal").style.display = "none";
    } else {
        document.getElementById("infoPersonal").style.display = "block";
    }

    // Mostrar/ocultar campo de especificación de pruebas
    if (document.getElementById("hasProof").checked) {
        document.getElementById("espeSection").style.display = "block";
    } else {
        document.getElementById("espeSection").style.display = "none";
    }

    // Para asegurar que solo un checkbox esté seleccionado
    // Validación para asegurarse de que solo un checkbox esté seleccionado
    const checkboxes = document.getElementsByName('hasProof');
    let checkedCount = 0;

    // Contar cuántos checkboxes están marcados
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            checkedCount++;
        }
    });

    // Si hay más de un checkbox seleccionado, desmarcar el anterior
    if (checkedCount > 1) {
        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
        });

        // Mantener solo el último seleccionado
        this.checked = true;
        console.log('Solo puedes seleccionar una opción');
        return false;
    }
}