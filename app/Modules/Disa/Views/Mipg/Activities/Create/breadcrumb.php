<?php
// Recibe el codigo del componente
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics");
$mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
$mcomponents = model("\App\Modules\Disa\Models\Disa_Components");
$mcategories = model("\App\Modules\Disa\Models\Disa_Categories");

$dimensions = $mdimensions->get_List();

$category = $mcategories->find($oid);
$component = $mcomponents->find($category["component"]);
$diagnostic = $mdiagnostics->find($component["diagnostic"]);
$politic = $mpolitics->find($diagnostic["politic"]);
$politics = $mpolitics->get_ListByDimension($politic["dimension"]);

$diagnostics = $mdiagnostics->get_ListByPolitic($diagnostic["politic"]);
$components = $mcomponents->get_ListByDiagnostic($diagnostic["diagnostic"]);

?>

<div class="row">
    <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar-light py-1 mb-3 breadcrumb w-100" aria-label="breadcrumb">
            <div class="container-fluid p-0">
                <a class="navbar-brand p-0" href="/"><i class="far fa-home-alt"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link " aria-current="page" href="/disa/">Disa</a></li>
                        <li class="nav-item-divider"></li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">Dimensiones</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php foreach ($dimensions as $key => $value) { ?>
                                    <li><a class="dropdown-item"
                                           href="/disa/mipg/politics/list/<?php echo($value["dimension"]); ?>"><?php echo(urldecode($value["name"])); ?></a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/disa/settings/help/<?php echo(lpk()); ?>">Ayuda</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item-divider"></li>


                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPolitics" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false"><?php echo(lang("App.Politics")); ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownPolitics">
                                <?php foreach ($politics as $key => $value) { ?>
                                    <li><a class="dropdown-item"
                                           href="/disa/mipg/components/list/<?php echo($value["politic"]); ?>"><?php echo(urldecode($value["name"])); ?></a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/disa/settings/help/<?php echo(lpk()); ?>">Ayuda</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item-divider"></li>


                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPolitics" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">Autodiagnósticos</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownPolitics">
                                <?php foreach ($diagnostics as $key => $value) { ?>
                                    <li><a class="dropdown-item"
                                           href="/disa/mipg/components/list/<?php echo($value["diagnostic"]); ?>"><?php echo(urldecode($value["name"])); ?></a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/disa/settings/help/<?php echo(lpk()); ?>">Ayuda</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item-divider"></li>


                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownComponentes" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">Componentes</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownComponentes">
                                <?php foreach ($components as $key => $value) { ?>
                                    <?php if ($value["component"] == $oid) { ?>
                                        <li><a class="dropdown-item active"
                                               href="/disa/mipg/categories/list/<?php echo($value["component"]); ?>"><?php echo(urldecode($value["name"])); ?></a>
                                        </li>
                                    <?php } else { ?>
                                        <li><a class="dropdown-item"
                                               href="/disa/mipg/categories/list/<?php echo($value["component"]); ?>"><?php echo(urldecode($value["name"])); ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/disa/settings/help/<?php echo(lpk()); ?>">Ayuda</a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item-divider"></li>


                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownComponentes" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">Categorías</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownComponentes">
                                <?php foreach ($components as $key => $value) { ?>
                                    <?php if ($value["component"] == $oid) { ?>
                                        <li><a class="dropdown-item active"
                                               href="/disa/mipg/categories/list/<?php echo($value["component"]); ?>"><?php echo(urldecode($value["name"])); ?></a>
                                        </li>
                                    <?php } else { ?>
                                        <li><a class="dropdown-item"
                                               href="/disa/mipg/categories/list/<?php echo($value["component"]); ?>"><?php echo(urldecode($value["name"])); ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/disa/settings/help/<?php echo(lpk()); ?>">Ayuda</a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item-divider"></li>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownOptions" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">Actividades</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownOptions">
                                <li><a class="dropdown-item" href="/disa/mipg/activities/create/<?php echo($oid); ?>">Crear</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/disa/settings/help/<?php echo(lpk()); ?>">Ayuda</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item-divider"></li>


                    </ul>
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>