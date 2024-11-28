// Función para mostrar/ocultar información personal
function toggleInfoPersonal() {
    const infoPersonal = document.getElementById("infoPersonal");
    if (document.getElementById("qa").checked) {
        infoPersonal.style.display = "none";
    } else {
        infoPersonal.style.display = "block";
    }
}

// Función para mostrar/ocultar sección de pruebas
function togglePruebas(hasPruebas) {
    const espeSection = document.getElementById("espeSection");
    espeSection.style.display = hasPruebas ? "block" : "none";
}

// Validar todo el formulario antes de enviar
function validarFormulario(event) {
    event.preventDefault();

    // Validar si hay archivos seleccionados si se indicó que hay pruebas
    const files = document.getElementById("formFileMultiple").files;
    const pruebasChecked = document.getElementById("flexRadioDefault1").checked;
    if (pruebasChecked && files.length === 0) {
        alert("Por favor, selecciona al menos un archivo como prueba.");
        return false;
    }

    // Validar tamaño de cada archivo (máximo 5 MB por archivo)
    const maxFileSize = 5 * 1024 * 1024; // 5 MB
    for (let i = 0; i < files.length; i++) {
        if (files[i].size > maxFileSize) {
            alert(`El archivo ${files[i].name} excede el tamaño máximo permitido (5 MB).`);
            return false;
        }
    }

    // Validar campos obligatorios
    const camposRequeridos = document.querySelectorAll("[required]");
    let formularioCompleto = true;

    camposRequeridos.forEach(campo => {
        if (!campo.value.trim()) {
            formularioCompleto = false;
        }
    });

    if (!formularioCompleto) {
        alert("Por favor, complete todos los campos requeridos.");
        return;
    }

    // Si todo está correcto, enviar el formulario
    const frm = document.getElementById('frm');
    frm.submit(); // Enviar formulario correctamente
    return false;
}

// Asegurarse de que los campos de información personal estén visibles al cargar la página
document.addEventListener("DOMContentLoaded", () => {
    toggleInfoPersonal();
});