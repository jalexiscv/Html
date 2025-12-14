<?php
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$musers = model("App\Modules\Security\Models\Security_Users");
$mfields = model("App\Modules\Security\Models\Security_Users_Fields");

$users = $musers->withDeleted()->findAll();

$code = "";

$grid = $bootstrap->get_Grid();
$grid->set_Headers(array(
    "#",
    "Usuario",
    "Alias",
    "Atributos"
));

$count = 0;
foreach ($users as $user) {
    $count++;
    $fields = $mfields->where("user", $user["user"])->countAllResults();
    $alias = $mfields->get_Field($user["user"], "alias");
    $grid->add_Row(array(
        $count,
        $user["user"],
        $alias,
        $fields,
    ));
}

$card = $bootstrap->get_Card("card-tools", array(
    "title" => "Analisis de Usuarios",
    "header-back" => "/development/home/" . lpk(),
    "content" => $grid,
));
echo($card);
?>