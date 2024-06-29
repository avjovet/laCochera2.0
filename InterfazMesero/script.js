window.onload = function(){
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");
    const searchBtn = document.querySelector(".bx-search")

    closeBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })

    searchBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })

    function menuBtnChange(){
        if(sidebar.classList.contains("open")){
            closeBtn.classList.replace("bx-menu","bx-menu-alt-right")
        }else{
            closeBtn.classList.replace("bx-menu-alt-right","bx-menu")
        }
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const productoSelects = document.querySelectorAll('.producto-select');

    productoSelects.forEach(select => {
        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const precioUnitario = selectedOption.getAttribute('data-precio');
            const precioUnitarioCell = this.closest('tr').querySelector('.precio-unitario');

            precioUnitarioCell.textContent = precioUnitario;
        });
    });
});
