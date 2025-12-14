<style>
    .table {
        border-collapse: collapse;
        font-size: 13px;
        line-height: 13px;
    }


    .table-container {
        height: calc(100vh - 120px); /* Altura total menos espacio para paginaciÃ³n */
        position: absolute;
        top: 0px;
        left: 0px;
    }

    .table-scroll {
        height: 100%;
        overflow: auto;
    }

    .table-wrapper {
        position: relative;
    }

    .table-wrapper table {
        margin-bottom: 0;
    }

    .table thead th {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 1;
        border-bottom: 2px solid #dee2e6;
    }

    .pagination-container {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #fff;
        border-top: 1px solid #dee2e6;
    }


    .table th, .table td {
        border: 1px solid #dee2e6;
        padding-top: 5px;
        padding-bottom: 5px;
    }

</style>