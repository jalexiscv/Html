<?php if (isset($featureds) && is_array($featureds) > 0) { ?>
    <?php foreach ($featureds as $featured) { ?>
        <?php //print_r($featured); ?>
        <?php $title = isset($featured['title']) ? $featured['title'] : ""; ?>
        <?php $description = isset($featured['description']) ? $featured['description'] : ""; ?>
        <?php $href = "/web/semantic/{$featured['semantic']}.html"; ?>
        <?php $cover = "{$featured['cover']}"; ?>
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary"
             style="background-image: url(<?php echo(urldecode($cover)); ?>); background-repeat: no-repeat;background-size: cover;background-position-x: -50%;background-position-y: 50%;">
            <div class="col-lg-6 px-0">
                <h1 class="display-4 fst-italic"><?php echo(urldecode($title)); ?></h1>
                <p class="lead my-3"><?php echo(urldecode($description)); ?></p>
                <p class="lead mb-0"><a href="<?php echo($href); ?>" class="text-body-emphasis fw-bold">Continuar
                        leyendo...</a></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>

<?php } ?>