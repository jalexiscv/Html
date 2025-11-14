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
<body>
<!-- Header -->
<header id="header">
    <div class="header-left" id="headerLeft">
        ${headerLeft_content}
    </div>
    <div class="header-center" id="headerCenter">
        ${headerCenter_content}
    </div>
    <div class="header-right" id="headerRight">
        ${headerRight_content}
    </div>
</header>

<!-- Sidebar -->
<nav id="sidebar">
    ${sidebar_content}
</nav>

<!-- Rightbar (Aside) -->
<aside id="rightbar">
    ${aside_content}
</aside>

<!-- Main Content -->
<main id="main-content">
    ${main_content}
</main>
{% include 'partials/modals' %}
{% include 'partials/modals/options' %}
<!-- Scripts-->
{% include 'partials/scripts' %}
</body>
</html>
