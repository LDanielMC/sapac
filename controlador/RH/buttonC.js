// Función para habilitar los campos de contrato
document.getElementById('btnEditar').addEventListener('click', function() {
    // Habilita los campos
    document.getElementById('rfc').removeAttribute('readonly');
    document.getElementById('departamento').removeAttribute('readonly');
    document.getElementById('puesto').removeAttribute('readonly');
    document.getElementById('sueldo').removeAttribute('readonly');
    document.getElementById('estatus').removeAttribute('disabled');
          
    // Habilitar btn guardar
    document.getElementById('btnGuardar').style.display = 'block';
   
});