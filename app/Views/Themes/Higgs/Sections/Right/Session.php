<div class="sidebar-header border-left border-bottom px-3">
    <div class="input-group input-group-navbar search-box-field ">
        <h2>Bienvenidos</h2>
    </div>
</div>
<div class="sidebar-content p-3">
    <div class="mt-3 fs-6 lh-6">
        ¡Te damos la bienvenida de nuevo! Completa tus datos. Si ya tienes una cuenta en nuestros portales
        informativos, inicia sesión con tu correo electrónico y contraseña registrada.
    </div>
    <form action="/security/session/signin/<?php echo(lpk()); ?>" id="form-signin" autocomplete="on"
          class="form-row mt-4"
          method="POST" accept-charset="utf-8">
        <input type="hidden" name="<?php echo(csrf_token()); ?>" value="<?php echo(csrf_hash()); ?>">
        <input type="hidden" name="submited" value="<?php echo(lpk()); ?>">
        <input type="hidden" name="origin" value="signin">
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input class="form-control " type="email" name="email" id="right-email"
                   placeholder="Ejemplo: usuario@gmail.com">
            <div class="invalid-feedback">
                Incorrecto o no registrado!.
            </div>
            <div class="valid-feedback">
                Usuario existente!
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input class="form-control " type="password" name="password" id="right-password"
                   placeholder="Contraseña">
            <div class="invalid-feedback">
                Contraseña incorrecta!.
            </div>
            <div class="valid-feedback">
                Contraseña aceptada!
            </div>
            <small>
                <a href="/security/session/recovery/<?php echo(lpk()); ?>">¿Has olvidado la contraseña?</a>
            </small>
        </div>
        <div>
            <label class="form-check">
                <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked="">
                <span class="form-check-label">Recordarme</span>
            </label>
        </div>
        <div class="text-center mt-3">
            <button id="btnsignin" type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </div>
    </form>
    <div class="mt-3 fs-6 lh-6">
        Gestione su cuenta y preferencias en cualquier momento para optimizar su experiencia.
        Nuestro
        compromiso es ofrecerle herramientas y recursos de alta calidad para satisfacer sus necesidades.
    </div>
</div>
