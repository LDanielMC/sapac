
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

