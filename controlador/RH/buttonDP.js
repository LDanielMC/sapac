document.getElementById('btnEditar').addEventListener('click', function() {
    // Habilita los campos de DP
    document.getElementById('nombre').removeAttribute('readonly');
    document.getElementById('apellidoP').removeAttribute('readonly');
    document.getElementById('apellidoM').removeAttribute('readonly');
    document.getElementById('fechaNacimiento').removeAttribute('readonly');
    document.getElementById('sexo').removeAttribute('disabled');
    document.getElementById('estadoCivil').removeAttribute('disabled');
    document.getElementById('telefono').removeAttribute('readonly');
    document.getElementById('correo').removeAttribute('readonly');
    document.getElementById('domicilio').removeAttribute('readonly');
    
            
    // Cambia la visibilidad de los botones
    document.getElementById('btnGuardar').style.display = 'block';
   
});
