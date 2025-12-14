<?php

$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics", true);
$dimensions = $mdimensions->get_List();

$politic = $mpolitics->find($oid);
$dimension = $mdimensions->where("dimension", $politic["dimension"])->first();

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
                        <li class="nav-item"><a class="nav-link " aria-current="page"
                                                href="/disa/mipg/politics/list/<?php echo($politic["dimension"]); ?>">políticas
                                de <?php echo(urldecode($dimension["name"])); ?></a></li>
                    </ul>
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>