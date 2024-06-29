document.addEventListener("DOMContentLoaded", function() {
    var dropdownArrow = document.getElementById("dropdownArrow");
    var dropdownLabel = document.getElementById("dropdownLabel");
    var dropdownContent = document.getElementById("ingredientesMenu");

    function toggleDropdown(event) {
        event.stopPropagation();
        if (dropdownContent.classList.contains("show")) {
            dropdownContent.classList.remove("show");
            setTimeout(function() {
                dropdownContent.style.display = "none";
            }, 300); // Duración de la transición
        } else {
            dropdownContent.style.display = "block";
            setTimeout(function() {
                dropdownContent.classList.add("show");
            }, 10); // Pequeño retraso para asegurar que el display: block se aplique antes de la transición
        }
    }

    // Muestra u oculta el dropdown al hacer clic en la flecha o en el label
    dropdownArrow.addEventListener("click", toggleDropdown);
    dropdownLabel.addEventListener("click", toggleDropdown);

    // Cierra el dropdown si el usuario hace clic en otra parte del documento
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn') && !event.target.matches('.dropdown-content') && !event.target.matches('#dropdownLabel')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                    setTimeout(function() {
                        openDropdown.style.display = "none";
                    }, 300); // Duración de la transición
                }
            }
        }
    }

    // Detener la propagación de clics dentro del menú desplegable
    dropdownContent.addEventListener("click", function(event) {
        event.stopPropagation();
    });



   
    
});
