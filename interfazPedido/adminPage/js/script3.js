document.addEventListener('DOMContentLoaded', function () {
    const headers = document.querySelectorAll('th i');

    headers.forEach(header => {
        header.addEventListener('click', function () {
            const field = header.getAttribute('data-field');
            console.log(`Click en el orden (campo): ${field}`);

            // Aquí puedes incluir el código de ordenamiento si es necesario
            // sortTable(...);
        });
    });

    function sortTable(table, field, ascending) {
        const rowsArray = Array.from(table.querySelector('tbody').rows);
        const index = Array.from(table.querySelectorAll('th i')).findIndex(i => i.getAttribute('data-field') === field);
        const sortedRows = rowsArray.sort((rowA, rowB) => {
            const cellA = rowA.cells[index].innerText;
            const cellB = rowB.cells[index].innerText;

            if (ascending) {
                return cellA.localeCompare(cellB, undefined, {numeric: true});
            } else {
                return cellB.localeCompare(cellA, undefined, {numeric: true});
            }
        });

        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';
        sortedRows.forEach(row => tbody.appendChild(row));
    }
});