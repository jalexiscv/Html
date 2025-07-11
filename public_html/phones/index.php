<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de búsqueda con Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
</head>
<body>
<main>
    <div class="d-flex flex-column flex-shrink-0 p-3">
        <div class="row">
            <div class="col-md-6">
                <form id="search-form" class="d-flex">
                    <input type="text" id="keyword" class="form-control" placeholder="Palabra clave" required>
                    <button type="submit" class="btn btn-primary ms-2">Buscar</button>
                </form>
            </div>
            <div class="col-md-6">
                <pre id="results" class="border bg-light p-2" style="max-height: 400px; overflow-y: scroll;"></pre>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
            crossorigin="anonymous"></script>

    <script>
        document.getElementById('search-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            const keyword = document.getElementById('keyword').value;
            const resultsElement = document.getElementById('results');

            resultsElement.textContent = 'Buscando...';

            const response = await fetch('result.php?keyword=' + encodeURIComponent(keyword), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `keyword=${encodeURIComponent(keyword)}`
            });

            // Verifica si la solicitud fue exitosa
            if (response.ok) {
                // Obtiene los resultados en formato JSON
                const searchResults = await response.json();

                // Muestra los resultados en el elemento <pre>
                resultsElement.textContent = JSON.stringify(searchResults, null, 2);
            } else {
                // Maneja el error
                resultsElement.textContent = 'Error al obtener los resultados';
            }
        });
    </script>
</main>
</body>
</html>
