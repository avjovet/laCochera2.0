/* ==========================================================================
  Este script gestiona la visibilidad del dropdown (agregados, precio unitario
   y cantidad) al hacer clic en el boton Ver agregados.
  ========================================================================== */

document.addEventListener("DOMContentLoaded", function() {
    var dropdownLabel = document.getElementById("dropdownLabel");
    var dropdownContent = document.getElementById("ingredientesMenu");
    var imgModal = document.querySelector(".img-modal");

    function toggleDropdown(event) {
        event.stopPropagation();

        // Se verifica si el dropdown está actualmente visible
        var isVisible = dropdownContent.classList.contains("visible");

        if (!isVisible) {
            dropdownContent.style.display = "block";
            setTimeout(function() {
                dropdownContent.classList.add("visible");
            }, 10); // Retraso para asegurar que la transición se active después de mostrar el contenido
            imgModal.classList.add("active");
            dropdownLabel.classList.add("active");

            console.log("Mostrando dropdown");
        } else {
            dropdownContent.classList.remove("visible");
            imgModal.classList.remove("active");
            setTimeout(function() {
                dropdownContent.style.display = "none";
            }, 300); // Retraso para esperar la transición antes de ocultar el dropdown
            console.log("Ocultando dropdown");
            dropdownLabel.classList.remove("active");

        }
    }

    dropdownLabel.addEventListener("click", toggleDropdown);
});
