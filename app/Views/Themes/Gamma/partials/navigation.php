<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/">Inicio</a>
    </li>

    {% if is_logged_in %}
    <li class="nav-item">
        <a class="nav-link" href="/dashboard">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/profile">Perfil</a>
    </li>
    {% if is_admin %}
    <li class="nav-item">
        <a class="nav-link text-warning" href="/admin">Administración</a>
    </li>
    {% endif %}
    {% endif %}

    <li class="nav-item">
        <a class="nav-link" href="/about">Acerca de</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/contact">Contacto</a>
    </li>
</ul>
