<script>
    document.getElementById('btn-excel').addEventListener('click', function () {
        // Función para exportar la tabla a Excel
        exportTableToExcel('grid-table', 'reporte-financiero-pagina-<?php echo $page; ?>');
    });

    function exportTableToExcel(tableID, filename = '') {
        const table = document.getElementById(tableID);

        // Crear un libro de Excel (formato XML)
        let excelContent = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        excelContent += '<head>';
        excelContent += '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Hoja1</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
        excelContent += '<meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>';
        excelContent += '</head>';
        excelContent += '<body>';
        excelContent += '<table>';

        // Obtener todas las filas de la tabla
        const rows = table.rows;

        // Recorrer cada fila y columna para construir el contenido del Excel
        for (let i = 0; i < rows.length; i++) {
            excelContent += '<tr>';
            for (let j = 0; j < rows[i].cells.length; j++) {
                // Si es el encabezado, usar etiqueta <th>
                if (i === 0) {
                    excelContent += '<th style="font-weight: bold; background-color: #D3D3D3;">' + rows[i].cells[j].innerHTML + '</th>';
                } else {
                    excelContent += '<td>' + rows[i].cells[j].innerHTML + '</td>';
                }
            }
            excelContent += '</tr>';
        }

        excelContent += '</table></body></html>';

        // Crear el Blob para el archivo Excel
        const blob = new Blob([excelContent], {type: 'application/vnd.ms-excel'});

        // Crear un enlace temporal para descargar
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename + '.xls';

        // Simular clic en el enlace para iniciar la descarga
        document.body.appendChild(link);
        link.click();

        // Limpiar
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);
    }
</script>