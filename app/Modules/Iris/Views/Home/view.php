<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK																	2025-04-09 16:38:38
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Home\breadcrumb.php]
* █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2025 - CloudEngine S.A.S., Inc. <admin@cgine.com>
* █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
* █																						 consulte la LICENCIA archivo que se distribuyó con este código fuente.
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
* █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
* █ ---------------------------------------------------------------------------------------------------------------------
**/
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_iris_permissions($module);
$bootstrap = service("bootstrap");
$server = service("server");
	$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Iris') / 102400), 6);
$card = $bootstrap->get_Card2("card-view-Iris", array(
		"class" => "mb-3",
    "header-title" => lang("Iris.module") . "<span class='text-muted'>v{$version}</span>",
		"header-back" => "/",
		"image" => "/themes/assets/images/header/iris.png",
		"image-class" => "img-fluid p-3",
		"content" => lang("Iris.intro-1")
));
echo($card);

if ($authentication->get_LoggedIn() && $authentication->has_Permission("iris-access")) {
		$shortcuts = $bootstrap->get_Shortcuts(array("id" => "shortcuts-panel"));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/patients/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Pacientes", "description" => "Listado")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/episodes/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Episodios ", "description" => "Clínicos")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/studies/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Estudios ", "description" => "Diagnósticos")));
    $shortcuts->add($bootstrap->get_Shortcut(array("href" => "/iris/files/list/" . lpk(), "icon" => ICON_TOOLS, "value" => "Archivos ", "description" => "Clínicos")));
    echo($shortcuts);
}
?>
