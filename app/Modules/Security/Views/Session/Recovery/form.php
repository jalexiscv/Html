<?php
$server = service("server");
$email = $request->getVar("email");
$error = isset($error) ? $error : false;


?>

<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">


        <div class="card">
            <div class="card-header">
                <h2 class="">Recuperar acceso</h2>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-sm-12">
                        <a class="my-1" href="/">
                            <img id="logo-light" class="logo d-none w-100 p-3"
                                 src="<?php echo(get_logo("logo_portrait_light")); ?>"/>
                            <img id="logo-dark" class="logo w-100 p-3"
                                 src="<?php echo(get_logo("logo_portrait")); ?>"/>
                        </a>
                        <p>Para acceder a la plataforma ingrese su usuario y contraseña con los cuales se encuentra
                            registrado, el usuario generalmente es su dirección de correo electrónico y esta asociado a
                            una contraseña que usted definió libremente al momento de su registro. En caso de no
                            recordar su contraseña o de ser un usuario que inicia su proceso de registro utilice los
                            enlaces correspondientes en la parte inferior de este mensaje.

                        <ul class="modal-list">
                            <li>
                                <a href="/security/session/signup/<?php echo(lpk()); ?>">
                                    Registrese ahora!
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Contactar a soporte técnico
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-6 col-sm-12">
                        <div class="text-center mt-4">
                            <h1 class="h2">¡Bienvenid@ de nuevo!</h1>
                            <p class="lead">
                                Ingrese la dirección de correo electrónico verificada de su cuenta de usuario y le
                                enviaremos un enlace para restablecer su contraseña.
                            </p>
                        </div>
                        <div class="m-sm-3">
                            <?php if ($error) { ?>
                                <div class="alert alert-danger" role="alert">Datos incorrectos por favor verifique.
                                </div>
                            <?php } ?>
                            <!--
                            <div class="d-grid gap-2 mb-3">
                                <a class="btn btn-google btn-lg" href="index.html"><i class="fab fa-fw fa-google"></i> Sign in with Google</a>
                                <a class="btn btn-facebook btn-lg" href="index.html"><i class="fab fa-fw fa-facebook-f"></i> Sign in with Facebook</a>
                                <a class="btn btn-microsoft btn-lg" href="index.html"><i class="fab fa-fw fa-microsoft"></i> Sign in with Microsoft</a>
                            </div>
                            <div class="row">
                                <div class="col"><hr></div>
                                <div class="col-auto text-uppercase d-flex align-items-center">Or</div>
                                <div class="col">
                                    <hr>
                                </div>
                            </div>
                            //-->
                            <form method="post" action="/security/session/recovery/<?php echo(lpk()); ?>"
                                  class="needs-validation"
                                  novalidate>
                                <input type="hidden" name="submited" value="<?php echo(lpk()); ?>">
                                <input type="hidden" name="type" value="standar">
                                <input type="hidden" name="referer" value="<?php echo($server::get_Referer()); ?>">
                                <div class="mb-3">
                                    <label class="form-label">Correo Electrónico</label>
                                    <input class="form-control form-control-lg"
                                           type="email"
                                           name="email"
                                           placeholder="Introduce tu correo electrónico"
                                           value="<?php echo($email); ?>"
                                           required>
                                    <div class="invalid-feedback">Obligatorio.</div>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button class="btn btn-lg btn-primary" type="submit">Recuperar</button>
                                </div>
                            </form>
                            <div class="text-center mb-3">
                                No tienes una cuenta? <a href="#">Registrate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>