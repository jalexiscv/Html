<script>
    document.getElementById('btn-excel').addEventListener('click', function () {
        const table = document.getElementById('grid-table');
        const data = [];
        for (let i = 0; i < table.rows.length; i++) {
            const row = [];
            for (let j = 0; j < table.rows[i].cells.length; j++) {
                row.push(table.rows[i].cells[j].innerText);
            }
            data.push(row);
        }

        fetch('/sie/api/excel/xls/download/test', { // Cambia a la URL de tu script PHP
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.blob()) // Obtener la respuesta como un blob
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'reporte-inscrito-relacion-inscritos-143-<?php echo $page; ?>.xlsx'; // Nombre del archivo
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            })
            .catch(error => console.error('Error:', error));
    });
</script>