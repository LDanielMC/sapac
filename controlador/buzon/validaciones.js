
document.addEventListener("DOMContentLoaded", function() {
    const anonymousCheckbox = document.getElementById("qa");
    const personalInfoFields = document.getElementById("infoPersonal");

    anonymousCheckbox.addEventListener("change", function() {
        if (anonymousCheckbox.checked) {
            personalInfoFields.style.display = "none";
        } else {
            personalInfoFields.style.display = "block";
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const tienepruebras = document.getElementById("p");
    const pruebass = document.getElementById("espe");

    tienepruebras.addEventListener("change", function() {
        if (tienepruebras.checked) {
            pruebass.style.display = "none";
        } else {
            pruebass.style.display = "block";
        }
    });
});