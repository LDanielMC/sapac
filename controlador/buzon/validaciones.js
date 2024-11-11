document.addEventListener("DOMContentLoaded", function() {
    const anonymousCheckbox = document.getElementById("qa");
    const personalInfoFields = document.getElementById("infoPersonal");
    const hasProofCheckbox = document.getElementById("hasProof");
    const proofSection = document.getElementById("espeSection");
    
    // Mostrar/ocultar campos de información personal si es anónima
    anonymousCheckbox.addEventListener("change", function() {
        if (anonymousCheckbox.checked) {
            personalInfoFields.style.display = "none";
        } else {
            personalInfoFields.style.display = "block";
        }
    });
    
    // Mostrar/ocultar campo de especificación de pruebas
    hasProofCheckbox.addEventListener("change", function() {
        if (hasProofCheckbox.checked) {
            proofSection.style.display = "block";
        } else {
            proofSection.style.display = "none";
        }
    });

    // Notificación de estado de inserción
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    if (status === 'success') {
        document.getElementById('successMsg').style.display = 'block';
    } else if (status === 'error') {
        document.getElementById('errorMsg').style.display = 'block';
    }
});