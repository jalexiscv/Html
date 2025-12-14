<?php

/*
 * -----------------------------------------------------------------------------
 *  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
 *  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK]
 *  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
 * -----------------------------------------------------------------------------
 * Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
 * Este archivo es parte de Higgs Bigdata Framework 7.1
 * Para obtener información completa sobre derechos de autor y licencia, consulte
 * la LICENCIA archivo que se distribuyó con este código fuente.
 * -----------------------------------------------------------------------------
 * EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * -----------------------------------------------------------------------------
 * @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @link https://www.Higgs.com
 * @Version 1.5.0
 * @since PHP 7, PHP 8
 * -----------------------------------------------------------------------------
 * Datos recibidos desde el controlador - @ModuleController
 * -----------------------------------------------------------------------------
 * @Authentication
 * @request
 * @dates
 * @view
 * @oid
 * @component
 * @views
 * @prefix
 * @parent
 * -----------------------------------------------------------------------------
 */
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Nexus."));
$option = $f->get_Value('option');
/*
 * -----------------------------------------------------------------------------
 * [Requests]
 * -----------------------------------------------------------------------------
*/
$f->set_ValidationRule("client", "trim|required");
if ($option == "interface") {
    //$f->set_ValidationRule("theme", "trim|required");
    //$f->set_ValidationRule("theme_color", "trim|required");
} elseif ($option == "profile") {
    $f->set_ValidationRule("name", "trim|required");
    $f->set_ValidationRule("domain", "trim|required");
    $f->set_ValidationRule("default_url", "trim|required");
} elseif ($option == "database") {
    $f->set_ValidationRule("db", "trim|required");
    $f->set_ValidationRule("db_host", "trim|required");
    $f->set_ValidationRule("db_port", "trim|required");
    $f->set_ValidationRule("db_user", "trim|required");
    $f->set_ValidationRule("db_password", "trim|required");
} else {

}
//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $errors = $f->validation->listErrors();
    $errors = $f->validation->listErrors();
    $c = $bootstrap->get_Card('access-denied', array(
        'class' => 'card-danger',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang("Questions.create-errors-message"),
        'errors' => $errors,
        'footer-class' => 'text-center',
        'voice' => "furag/questions-create-errors-message.mp3",
    ));
    $c .= view($component . '\form', $parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>