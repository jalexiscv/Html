<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
generate_sie_permissions($module);
$server = service("server");
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mdirects = model('App\Modules\Sie\Models\Sie_Directs');
$mattachments = model('App\Modules\Storage\Models\Storage_Attachments');
//[vars] ---------------------------------------------------------------------------------------------------------------
$directs = $mdirects->findAll();
?>
<div class="container my-5">
    <h2 class="text-center mb-4">Cursos Disponibles</h2>

    <div class="col-md-12">
        <div class="row g-4">
            <?php foreach ($directs as $direct) { ?>
                <?php $title = @$direct["title"]; ?>
                <?php $content = @$direct["content"]; ?>
                <?php $href = @$direct["href"]; ?>
                <?php $target = @$direct["target"]; ?>
                <?php $attachment=$mattachments->where("object", $direct["direct"])->orderBy('created_at', 'DESC')->first();?>
                <?php $image = cdn_url($attachment["file"]); ?>
                <!-- Ficha 1: Procesamiento y Análisis de Información -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo($image);?>?w=800&h=400&fit=crop"
                             class="card-img-top" alt="Procesamiento y Análisis de Información">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <p class="card-text"><?php echo $content; ?></p>
                            <a href="<?php echo $href; ?>" target="<?php echo $target; ?>"
                               class="btn btn-primary mt-auto">Matricúlate</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
