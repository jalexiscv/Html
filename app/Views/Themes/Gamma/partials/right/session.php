<!-- Formulario de Inicio de Sesión -->
<div class="right-sidebar bg-light" id="rightSidebar">
    <div class="section-header">
        Inicio de Sesión
    </div>
    <div class="container-fluid p-4" style="max-width: 250px;">
        <!-- Mensaje de bienvenida -->
        <div class="text-center mb-4">
            <h5 class="text-dark mb-3">¡Te damos la bienvenida de nuevo!</h5>
            <p class="text-muted small">
                Completa tus datos. Si ya tienes una cuenta en nuestros portales informativos,
                inicia sesión con tu correo electrónico y contraseña registrada.
            </p>
        </div>

        <!-- Formulario -->
        <form action="/security/session/signin/${pk}" id="loginForm" method="post">
            <input name="submited" type="hidden" value="${pk}">
            <input name="origin" type="hidden" value="signin">
            <input name="${csrf_name}" type="hidden" value="${csrf_value}">
            <!-- Campo de correo electrónico -->
            <div class="mb-3">
                <label class="form-label text-dark" for="email">Correo electrónico</label>
                <input class="form-control bg-warning bg-opacity-25 border-0"
                       id="email"
                       name="email"
                       placeholder="jalexiscv@gmail.com"
                       required
                       type="email">
            </div>

            <!-- Campo de contraseña -->
            <div class="mb-3">
                <label class="form-label text-dark" for="password">Contraseña</label>
                <input class="form-control bg-warning bg-opacity-25 border-0"
                       id="password"
                       name="password"
                       placeholder="••••••••••"
                       required
                       type="password">
            </div>

            <!-- Enlace de recuperación -->
            <div class="mb-3">
                <a class="text-primary text-decoration-none small" href="#">
                    ¿Has olvidado la contraseña?
                </a>
            </div>

            <!-- Checkbox recordarme -->
            <div class="form-check mb-3">
                <input class="form-check-input" id="remember" name="remember" type="checkbox">
                <label class="form-check-label text-dark" for="remember">
                    Recordarme
                </label>
            </div>

            <!-- Botón de inicio de sesión -->
            <div class="d-grid mb-3">
                <button class="btn btn-primary btn-lg" type="submit">
                    Iniciar Sesión
                </button>
            </div>

            <!-- Mensaje adicional -->
            <div class="text-center">
                <p class="text-muted small mb-0">
                    Gestiona su cuenta y preferencias en cualquier momento para optimizar su
                    experiencia. Nuestro compromiso es ofrecerle herramientas y recursos de
                    alta calidad para satisfacer sus necesidades.
                </p>
            </div>
        </form>
    </div>
</div>
