<script>


    function adjustTableHeight() {
        const paginationContainer = document.querySelector('.pagination-container');
        const tableContainer = document.querySelector('.table-container');
        const paginationHeight = paginationContainer.offsetHeight + 10;
        tableContainer.style.height = `calc(100vh - ${paginationHeight}px)`;
    }

    document.addEventListener('DOMContentLoaded', adjustTableHeight);
    window.addEventListener('resize', adjustTableHeight);

    document.getElementById('btn-excel').addEventListener('click', function () {
        window.excel.Convert('grid-table', 'materias-cursadas-r124-<?php echo $page; ?>');
    });

</script>