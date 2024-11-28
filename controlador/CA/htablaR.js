// Alternar la visibilidad de las tablas
document.getElementById('toggleTableBtn').addEventListener('click', function() {
    const table1 = document.getElementById('tableContainer1');
    const table2 = document.getElementById('tableContainer2');
    
    if (table1.style.display === 'none') {
        table1.style.display = 'block';
        table2.style.display = 'none';
        this.innerHTML = '<i class="bi bi-arrow-left-circle"></i> Ver Sin entregar';
    } else {
        table1.style.display = 'none';
        table2.style.display = 'block';
        this.innerHTML = '<i class="bi bi-arrow-left-circle"></i> Ver Entregados';
    }
});



document.getElementById("sendEmailsBtn").addEventListener("click", function () {
    // Capturar todos los correos de la segunda tabla
    const emails = Array.from(document.querySelectorAll("#tableDP2 .email-column"))
        .map(td => td.textContent.trim())
        .filter(email => email !== ""); // Filtrar valores vacíos

    if (emails.length === 0) {
        alert("No hay correos para enviar.");
        return;
    }
    
    // Enviar los correos a sendcorreos.php
    fetch('../../controlador/CA/recordarR.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ emails: emails })
    })
    .then(response => response.json())  
    .then(data => {
        if (data.success) {
            alert(`${data.message}`);
        } else {
            alert("Error al enviar los correos.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Hubo un problema al procesar la solicitud.");
    });
});
