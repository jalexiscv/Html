<div id="rightbar-signin" class="sidebar sidebar-right  d-none d-lg-block d-xl-block d-xxl-block">
    <div class="sidebar-header justify-content-center border-b-1">
        <h4 class="fs-3 m-0">
            <i class="fa fa-coffee text-orange-m1 mr-1"></i>
            Bienvenid@
        </h4>
    </div>
    <div class="sidebar-content p-3">
        <div class="mt-3 paragraph">
            ¡Te damos la bienvenida de nuevo! Completa tus datos. Si ya tienes una cuenta en nuestros portales
            informativos, inicia sesión con tu correo electrónico y contraseña registrada.
        </div>
        <form action="/security/session/signin/{lpk()}" id="form-signin" autocomplete="on" class="form-row mt-4"
              method="POST" accept-charset="utf-8">
            <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
            <input type="hidden" name="submited" value="{lpk()}">
            <input type="hidden" name="origin" value="signin">
            <div class="mb-3">
                <label class="form-label">{lang("App.Email")}</label>
                <input class="form-control form-control-lg" type="email" name="email" id="right-email"
                       placeholder="Ejemplo: usuario@gmail.com">
                <div class="invalid-feedback">
                    Incorrecto o no registrado!.
                </div>
                <div class="valid-feedback">
                    Usuario existente!
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">{lang("App.Password")}</label>
                <input class="form-control form-control-lg" type="password" name="password" id="right-password"
                       placeholder="Contraseña">
                <div class="invalid-feedback">
                    Contraseña incorrecta!.
                </div>
                <div class="valid-feedback">
                    Contraseña aceptada!
                </div>
                <small>
                    <a href="/security/session/recovery/{lpk()}"
                    >{lang("App.forgot-password-full")}</a>
                </small>
            </div>
            <div>
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked="">
                    <span class="form-check-label">{lang("App.Remember-me")}</span>
                </label>
            </div>
            <div class="text-center mt-3">
                <button id="btnsignin" type="submit" class="btn btn-lg btn-primary w-100">{lang("App.Sign-in")}</button>
            </div>
        </form>
        <div class="mt-3 paragraph">
            Disfruta del contenido exclusivo para suscriptores y accede a toda la información
            noticias, artículos, videos, especiales multimedia y galerías de fotos. Usted puede finalizar su suscripción
            o
            cancelar la renovación automática en cualquier momento.
        </div>
    </div>
</div>
{literal}

{/literal}