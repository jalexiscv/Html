<!-- layout/default.php //-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="${charset}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${page_title} - ${site_name}</title>
    <meta name="description" content="${meta_description}">
    <!-- Estilos del Tema -->
    {% include 'partials/styles' %}
    <!-- Estilos Adicionales (si son necesarios) -->

</head>
<body class="d-flex align-items-center min-vh-100">
<!-- Main Content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            ${main_content}
        </div>
    </div>
</div>
<!-- Scripts-->
{% include 'partials/scripts' %}
</body>
</html>