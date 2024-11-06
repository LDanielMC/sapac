function verificarEstatus() {
    const estatusSelect = document.getElementById('estatus');
    const estatusValue = estatusSelect.value;

    if (estatusValue === "Inactivo") {
        var respuesta=confirm("¿Estas seguro que que desas cambiar el Estatus a Inactivo? si lo haces ya no podrás ver la informacion del Empleado");
        return respuesta
    }
}