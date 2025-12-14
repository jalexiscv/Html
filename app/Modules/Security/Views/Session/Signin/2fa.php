<?php
$request = service("request");
$server = service("server");
$strings = service("strings");
$referer = $request->getVar("referer");
//$otp
//$email
if (!isset($error)) {
    $mfields = model("\App\Modules\Security\Models\Security_Users_Fields");
    $fotp = $mfields->where("value", $otp)->orderBy("created_at", "DESC")->first();
    $user = isset($fotp["user"]) ? $fotp["user"] : false;
    $phone = $mfields->get_Field($user, "phone");
    $email = safe_urldecode($mfields->get_Field($user, "email"));
    $firstname = $mfields->get_Field($user, "firstname");
    //[sms]-------------------------------------------------------------------------------------------------------------
    $sms = new \App\Libraries\Sms();
    $sms->send($phone, "Su código de verificación es: {$otp}");
    $hphone = substr($phone, 0, -4) . '****';
    //[mail]------------------------------------------------------------------------------------------------------------
    $mail = new \App\Libraries\Message();
    $mail->setFrom(lpk() . "@cgine.com", "Sistema de seguridad " . $server->get_Name());
    $mail->setSubject("Código de verificación");
    $mail->addContentHTML("<h1>Su código de verificación es: {$otp}</h1>");
    $mail->addTo($email, $firstname);
    $mail->send("email");
    $hemail = $strings->get_HideEmail($email);
} else {
    $hphone = "";
    $hemail = "";
}
?>

<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">

        <div class="text-center mt-4">
            <h1 class="h2">Verificando identidad</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="m-sm-3">
                    <?php if (isset($error) && $error) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo($error); ?></div>
                    <?php } ?>
                    <form method="post" action="/security/session/signin/<?php echo(lpk()); ?>" class="needs-validation"
                          novalidate>
                        <input type="hidden" name="origin" value="2fa">
                        <input type="hidden" name="referer" value="<?php echo($referer); ?>">
                        <input type="hidden" name="submited" value="<?php echo(lpk()); ?>">
                        <h6>Por favor ingrese el código de un solo uso que se le ha enviado para verificar el inicio de
                            sesión</h6>
                        <div><span>El código se ha enviado a</span>
                            <small><?php echo($hphone); ?></small> <?php echo($hemail); ?>
                        </div>
                        <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                            <input class="m-2 text-center form-control rounded " required type="text" id="first"
                                   name="first"
                                   maxlength="1"/>
                            <input class="m-2 text-center form-control rounded " required type="text" id="second"
                                   name="second"
                                   maxlength="1"/>
                            <input class="m-2 text-center form-control rounded " required type="text" id="third"
                                   name="third"
                                   maxlength="1"/>
                            <input class="m-2 text-center form-control rounded " required type="text" id="fourth"
                                   name="fourth"
                                   maxlength="1"/>
                            <input class="m-2 text-center form-control rounded " required type="text" id="fifth"
                                   name="fifth"
                                   maxlength="1"/>
                            <input class="m-2 text-center form-control rounded " required type="text" id="sixth"
                                   name="sixth"
                                   maxlength="1"/>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <button class="btn btn-lg btn-primary" type="submit">Validar</button>
                        </div>
                        <div class="content d-flex justify-content-center align-items-center p-3">
                            <span>No llego el código?</span>
                            <a href="#" class="text-decoration-none ms-3">Reenviar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    document.addEventListener("DOMContentLoaded", function (event) {
        function handleOTPInput() {
            const otpFields = Array.from(document.querySelectorAll('#otp > *[id]'));

            otpFields.forEach((field, index) => {
                field.addEventListener('input', function (event) {
                    const currentValue = field.value;

                    if (event.inputType === "deleteContentBackward") {
                        clearFieldValue(field);
                        if (index !== 0) {
                            focusPreviousField(index - 1);
                        }
                    } else {
                        if (currentValue.length === 1) {
                            if (index !== otpFields.length - 1) {
                                focusNextField(index + 1);
                            }
                        } else if (currentValue.length > 1) {
                            field.value = currentValue[currentValue.length - 1];
                        }
                    }
                });
            });

            function clearFieldValue(field) {
                field.value = '';
            }

            function focusPreviousField(previousIndex) {
                otpFields[previousIndex].focus();
            }

            function focusNextField(nextIndex) {
                otpFields[nextIndex].focus();
            }
        }

        handleOTPInput();
    });

</script>