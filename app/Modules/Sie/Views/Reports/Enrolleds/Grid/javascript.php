<script>
    // FunciÃ³n para generar datos de prueba

    function adjustTableHeight() {
        const paginationContainer = document.querySelector('.pagination-container');
        const tableContainer = document.querySelector('.table-container');
        const paginationHeight = paginationContainer.offsetHeight + 10;
        tableContainer.style.height = `calc(100vh - ${paginationHeight}px)`;
    }

    // Call on page load and window resize
    document.addEventListener('DOMContentLoaded', adjustTableHeight);
    window.addEventListener('resize', adjustTableHeight);

    document.getElementById('btn-excel').addEventListener('click', function () {
        window.excel.Convert('grid-table', 'reporte-matriculados-ref61-<?php echo $page; ?>');
    });

</script>