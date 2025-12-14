<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-14 15:43:03
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Modules\Editor\form.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$back = "/development/ui/home/" . lpk();
//[Request]-----------------------------------------------------------------------------
$code = "En Higgs, los botones son elementos interactivos que se usan para iniciar acciones específicas. Por defecto ofrecemos estilos predefinidos para los botones, que se pueden personalizar fácilmente con clases adicionales.";
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("App.Buttons"),
    "header-back" => $back,
    "content" => $code,
));
echo($card);
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h2 class="card-title">
                    Bótones y sus tamaños
                </h2>
            </div>
            <div class="card-body pad table-responsive " style="background-color: #d8d7d7;">
                <!--[chatbox]------------------------------------------------------------------------------------------>
                <div class="chat">
                    <div class="contact bar">
                        <div class="pic stark"></div>
                        <div class="name">
                            Tony Stark
                        </div>
                        <div class="seen">
                            Today at 12:56
                        </div>
                    </div>
                    <div class="messages" id="chat">
                        <div class="time">
                            Today at 11:41
                        </div>
                        <div class="message parker">
                            Hey, man! What's up, Mr Stark?&nbsp;👋
                        </div>
                        <div class="message stark">
                            Kid, where'd you come from?
                        </div>
                        <div class="message parker">
                            Field trip! 🤣
                        </div>
                        <div class="message parker">
                            Uh, what is this guy's problem, Mr. Stark? 🤔
                        </div>
                        <div class="message stark">
                            Uh, he's from space, he came here to steal a necklace from a wizard.
                        </div>
                        <div class="message stark">
                            <div class="typing typing-1"></div>
                            <div class="typing typing-2"></div>
                            <div class="typing typing-3"></div>
                        </div>
                    </div>
                    <div class="input">
                        <i class="fas fa-camera"></i><i class="far fa-laugh-beam"></i><input
                                placeholder="Type your message here!"
                                type="text"><i
                                class="fas fa-microphone"></i>
                    </div>
                </div>
                <!--[/chatbox]----------------------------------------------------------------------------------------->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.col -->
</div>
